<?php

// namespace App\Models;

// use CodeIgniter\Model;

class PaginationModel
{
    private $pdo;
    private $debug = 1;

    private $perPage;

    public $pager;
    public $select = '';
    public $where = '';

    protected $table            = 'pagination_users';
    protected $primaryKey       = 'id';

    protected $returnType       = 'array';

    protected $allowedFields    = ['name', 'email', 'city'];
    protected $useTimestamps = false;

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;


    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getPdo();

        $this->pager = $this;
    }

    public function query(string $sql, array $params = []): array|false {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }

    private function handleError(string $message): void {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
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

    public function paginate($perPage = 10)
    { 
        $request = new CRequest();

        // 取得查詢參數
        $queryParams = $request->getQueryParams();
        
        // 當前頁數
        $currentPage = $queryParams['page'] ?? 1;

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

        $this->pager = $this;

        return $this->query($sql);
    }

    public function fetch_assoc($stmt)
    {
        if(!$stmt) return 0;
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function iGetCount(){
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

    public function links(){

        $request = new CRequest();

        // 取得查詢參數
        $queryParams = $request->getQueryParams();
        
        // 當前頁數
        $currentPage = $queryParams['page'] ?? 1;
        
        // 總筆數
        $totalItems = $this->iGetCount();

        // 每頁幾筆
        $itemsPerPage = $this->perPage;

        $paginator = new Paginator(
            $totalItems,
            $itemsPerPage,
            $currentPage,
            BASE_URL.'loadRecord',
            $request->withoutPageParam($queryParams)
        );

        return $paginator->render();
    }

}
