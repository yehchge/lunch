<?php

/**
 * 基本 Model
 */

namespace App\System;

class Model
{
    protected $pdo;
    protected $debug = 1;
    private $perPage;
    public $pager;
    public $segment = 0;

    private $select = '';
    private $where = '';
    private $order = '';

    /**
     * Last insert ID
     *
     * @var int|string
     */
    protected $insertID = 0;


    /**
     * Holds information passed in via 'set'
     * so that we can capture it (not the builder)
     * and ensure it gets validated first.
     *
     * @var         array{escape: array, data: array}|array{}
     * @phpstan-var array{escape: array<int|string, bool|null>, data: row_array}|array{}
     */
    protected $tempData = [];


    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getPdo();
    }

    private function handleError(string $message): void
    {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
        }
    }

    protected function query(string $sql, array $params = []): array|false
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function select($query)
    {
        $this->select = $query;
        return $this;
    }

    public function where($key, $value = '')
    {
        if(is_array($key)) {
            $data = $key;

            $myData = [];

            foreach($data as $field => $value){
                array_push($myData, "$field = '$value'");
            }

            $columns = implode(' AND ', $myData);

            if (!$this->where) {
                $this->where = $columns;
            } else {
                $this->where .= ' AND '.$columns;
            }
        }else{
            if (!$this->where) {
                $this->where = "$key = '$value'";
            } else {
                $this->where .= ' AND '."$key = '$value'";
            }
        }

        return $this;
    }

    public function like($field, $value)
    {
        if (!$this->where) {
            $this->where = "$field LIKE '%$value%'";
        } else {
            $this->where .= " AND $field LIKE '%$value%'";
        }
        return $this;
    }

    public function orLike($field, $value)
    {
        if (!$this->where) {
            $this->where = "$field LIKE '%$value%'";
        } else {
            $this->where .= " OR $field LIKE '%$value%'";
        }
        return $this;
    }

    public function orderBy($field, $value)
    {
        if (!$this->order) {
            $this->order = "ORDER BY $field $value";
        } else {
            $this->order .= " ORDER BY $field $value";
        }
        return $this;
    }


    public function first()
    {
        if ($this->select) {
            $sql = "SELECT ".$this->select." FROM ".$this->table;
        } else {
            $sql = "SELECT * FROM ".$this->table;
        }

        if ($this->where) {
            $sql .= " WHERE ".$this->where;
        }

        if ($this->order) {
            $sql .= ' '.$this->order;
        }

        try {
            $stmt = $this->queryIterator($sql);
            $row = $this->fetch_assoc($stmt);
            return $row;
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function find($id)
    {
        if ($this->select) {
            $sql = "SELECT ".$this->select." FROM ".$this->table;
        } else {
            $sql = "SELECT * FROM ".$this->table;
        }

        $sql .= " WHERE ".$this->primaryKey." = $id";

        try {
            $stmt = $this->queryIterator($sql);
            $row = $this->fetch_assoc($stmt);
            return $row;
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function paginate($perPage = 10, $group = 'default', $setPage = null, $segment = 0)
    {
        $this->segment = $segment;

        $request = new CRequest();

        // 取得查詢參數
        $queryParams = $request->getQueryParams();

        // 當前頁數
        $currentPage = $queryParams['page'] ?? 1;

        if ($segment) {
            $currentPage = $this->iGetPageByURI($segment);
        }

        $offset = ($currentPage - 1) * $perPage;

        $this->perPage = $perPage;

        if ($this->select) {
            $sql = "SELECT ".$this->select." FROM ".$this->table;
        } else {
            $sql = "SELECT * FROM ".$this->table;
        }

        if ($this->where) {
            $sql .= " WHERE ".$this->where;
        }

        if ($this->order) {
            $sql .= ' '.$this->order;
        }

        $sql .= " LIMIT $offset, $perPage";

        $this->pager = $this->getPagebar();

        return $this->query($sql);
    }

    public function countAll()
    {
        $request = new CRequest();

        $fileds = "COUNT(*) AS total";

        $sql = "SELECT $fileds FROM ".$this->table;

        if ($this->where) {
            $sql .= " WHERE ".$this->where;
        }

        if ($this->order) {
            $sql .= ' '.$this->order;
        }

        $stmt = $this->queryIterator($sql);

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
    }

    private function queryIterator(string $sql, array $params = []): ?\PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;  // 可用來逐筆 fetch
        } catch (\PDOException $e) {
            $this->handleError("QueryIterator Error: ".$e->getMessage().PHP_EOL);
            return null;
        }
    }

    public function fetch_assoc($stmt)
    {
        if(!$stmt) { return null;
        }
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(!$row) { return null;
        }
        return $row;
    }

    protected function getPagebar()
    {
        $UrlParse = new UrlParse();

        $func = $UrlParse->getFunction();
        // $action = $UrlParse->getAction();
        // $params = $UrlParse->getParams();

        $request = new CRequest();

        // 取得查詢參數
        $queryParams = $request->getQueryParams();

        // 當前頁數
        $currentPage = $queryParams['page'] ?? 1;
        $mode = 'query';

        if ($this->segment) {
            $currentPage = $this->iGetPageByURI($this->segment);
            $mode = 'uri';
        }

        // 總筆數
        $totalItems = $this->countAll();

        // 每頁幾筆
        $itemsPerPage = $this->perPage;

        $paginator = new Pagebar(
            $totalItems,
            $itemsPerPage,
            $currentPage,
            // BASE_URL.'loadRecord',
            BASE_URL.$func,
            $request->withoutPageParam($queryParams),
            ['mode' => $mode]
        );

        return $paginator;
    }


    public function iGetPageByURI($segment)
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(dirname($scriptName), '/');

        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $path = parse_url($requestUri, PHP_URL_PATH);

        // 去掉專案根目錄
        if(str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        } else {
            $path = $requestUri;
        }
        $path = trim($path, '/');

        // 如果還有 index.php/ 開頭，把它移除（支援 index.php/about/contact）
        if (str_starts_with($path, 'index.php')) {
            $path = ltrim(substr($path, strlen('index.php')), '/');
        }

        $path = trim($path, '/');

        if ($path) { $segments = explode('/', $path);
        } else { $segments = [];
        }

        // 當前頁數
        $currentPage = $segments[$segment-1] ?? 1;
        return $currentPage;
    }

    public function findAll()
    {
        try {
            if ($this->select) {
                $sql = "SELECT ".$this->select." FROM ".$this->table;
            } else {
                $sql = "SELECT * FROM ".$this->table;
            }

            if ($this->where) {
                $sql .= " WHERE ".$this->where;
            }

            if ($this->order) {
                $sql .= ' '.$this->order;
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function insert(array $data): bool
    {
        return $this->save($data);
    }

    public function save(array $data): bool
    {
        $table = $this->table;

        // 過濾不允許的欄位
        if($this->allowedFields) {
            foreach($data as $key => $value){
                if(!in_array($key, $this->allowedFields)) {
                    unset($data[$key]);
                }
            }
        }

        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $result = $this->execute($sql, array_values($data));

        if ($result) {
            $this->insertID = $this->getLastInsertID();
        }

        return $result;
    }

    /**
     * Returns last insert ID or 0.
     *
     * @return int|string
     */
    public function getInsertID()
    {
        return is_numeric($this->insertID) ? (int) $this->insertID : $this->insertID;
    }

    public function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }

     /**
      * Captures the builder's set() method so that we can validate the
      * data here. This allows it to be used with any of the other
      * builder methods and still get validated data, like replace.
      *
      * @param array|object|string               $key    Field name, or an array of field/value pairs, or an object
      * @param bool|float|int|object|string|null $value  Field value, if $key is a single field
      * @param bool|null                         $escape Whether to escape values
      *
      * @return $this
      */
    public function set($key, $value = '', ?bool $escape = null)
    {
        // if (is_object($key)) {
        //     $key = $key instanceof stdClass ? (array) $key : $this->objectToArray($key);
        // }

        $data = is_array($key) ? $key : [$key => $value];

        foreach (array_keys($data) as $k) {
            $this->tempData['escape'][$k] = $escape;
        }

        $this->tempData['data'] = array_merge($this->tempData['data'] ?? [], $data);

        return $this;
    }

    /**
     * Updates a single record in the database. If an object is provided,
     * it will attempt to convert it into an array.
     *
     * @param         array|int|string|null $id
     * @param         array|object|null     $row
     * @phpstan-param row_array|object|null $row
     *
     * @throws ReflectionException
     */
    public function update($id = null, $row = null): bool
    {
        if (isset($this->tempData['data'])) {
            if ($row === null) {
                $row = $this->tempData['data'];
            } else {
                // $row = $this->transformDataToArray($row, 'update');
                $row = array_merge($this->tempData['data'], $row);
            }
        }

        $this->escape   = $this->tempData['escape'] ?? [];
        $this->tempData = [];

        return $this->_update($id, $row);
    }


    private function _update($id, array $data)
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE ".$this->table." SET $set";

        if ($this->where) {
            $sql .= " WHERE ".$this->where;
        } elseif ($id) {
            $sql .= " WHERE ".$this->primaryKey." = $id";
        }

        return $this->execute($sql, array_merge(array_values($data)));
    }


    public function delete($id)
    {
        $sql = "DELETE FROM ".$this->table." WHERE ".$this->primaryKey." = ?";
        return $this->execute($sql, [$id]);
    }

    public function execute(string $sql, array $params = []): bool
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

}
