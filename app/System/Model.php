<?php

/**
 * 基本 Model
 */

class Model
{
    protected $pdo;
    protected $debug = 1;
    private $perPage;
    public $pager;
    public $segment = 0;

    private $select = '';
    private $where = '';

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getPdo();
    }

    private function handleError(string $message): void {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
        }
    }

    protected function query(string $sql, array $params = []): array|false {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    public function select($query)
    {
        $this->select = $query;
        return $this;
    }

    public function orLike($field, $value)
    {
        if(!$this->where) {
            $this->where = "$field LIKE '%$value%'";
        } else {
            $this->where .= " OR $field LIKE '%$value%'";
        }
        return $this;
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

        $sql .= " LIMIT $offset, $perPage";

        $this->pager = $this->getPagebar();

        return $this->query($sql);
    }

    public function countAll(){
        $request = new CRequest();

        // 取得查詢參數
        $queryParams = $request->getQueryParams();

        // 當前頁數
        $currentPage = $queryParams['page'] ?? 1;

        $offset = ($currentPage - 1) * $this->perPage;

        $fileds = "COUNT(*) AS total";

        $sql = "SELECT $fileds FROM ".$this->table;

        if ($this->where) {
            $sql .= " WHERE ".$this->where;
        }

        $stmt = $this->queryIterator($sql);

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
    }

    private function queryIterator(string $sql, array $params = []): ?PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;  // 可用來逐筆 fetch
        } catch (PDOException $e) {
            $this->handleError("QueryIterator Error: ".$e->getMessage().PHP_EOL);
            return null;
        }
    }

    public function fetch_assoc($stmt)
    {
        if(!$stmt) return 0;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function getPagebar()
    {
        $router = new Router();

        $func = $router->func();
        $action = $router->action();
        $params = $router->params();

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

        if ($path) $segments = explode('/', $path);
        else $segments = [];

        // 當前頁數
        $currentPage = $segments[$segment-1] ?? 1;
        return $currentPage;
    }

}
