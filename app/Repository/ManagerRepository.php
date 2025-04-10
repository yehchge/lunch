<?php

class ManagerRepository
{
    private $pdo;
    private $debug = 1;

    // 設定指定店家管理狀態
    public $ManagerStatus = [
        '0' => "請選擇",
        '1' => "訂購中",
        '2' => "截止訂購",
        '3' => "取消",
        '9' => "刪除"
    ];

    public function __construct(Database $db)
    {
        $this->pdo = $db->getPdo();
    }

    public function UpdateManagerStatusByRecordID($RecordID=0,$Status=0) {
        if(!$RecordID or !$Status) return 0;
        $tt = time();
        $values  = "Status=$Status,EditDate=$tt";
        $condition = 'RecordID = ?';

        return $this->update([
            'Status' => $Status,
            'EditDate' => time(),
        ], $condition, [$RecordID]);
     }

    public function CreateManager($StoreID=0, $Manager='', $Note='', $EndDate=0) {
        if (!$StoreID || !$Manager || !$Note) return 0;

        $tt = time();

        $result = $this->insert('lunch_manager', [
            'StoreID' => $StoreID,
            'Manager' => $Manager,
            'Note' => $Note,
            'Status' => 1,
            'CreateDate' => $tt,
            'EditDate' => $tt,
            'EndDate' => $EndDate,
        ]);

        if($result){
            return $this->getLastInsertID();
        }
        return 0;
    }

    public function GetActiveManagerPage($Status=0,$PayType=0,$startRow=0,$maxRows=10) {
        $values = "*";
        $condition = "Status in (1,2)";
        $condition .= " ORDER BY CreateDate DESC";

        return $this->queryIterator("SELECT $values FROM lunch_manager WHERE $condition LIMIT $startRow, $maxRows");
    }

    public function GetActiveManagerPageCount() {
        $fileds = "count(*) AS total";
        $condition = "Status in (1,2)";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_manager WHERE $condition");

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
     }

    public function GetAllManagerPage($Status=0,$PayType=0,$startRow=0,$maxRows=10)
    {
        $DateString = date("Ymd",mktime(0, 0, 0,date("m"),date("d"),date("Y")));
        $condition = "Status!=9 AND CreateDate>=unix_timestamp('$DateString')";

        if($Status) $condition .= " AND Status=$Status";
        if($PayType) $condition .= " AND PayType=$PayType";

        $condition .= " ORDER BY CreateDate DESC";

        return $this->queryIterator("SELECT * FROM lunch_manager WHERE $condition LIMIT $startRow, $maxRows");
    }

    public function GetAllManagerCount($Status=0) {
        $fileds = "COUNT(*) AS total";

        $DateString = date("Ymd",mktime(0, 0, 0,date("m"),date("d"),date("Y")));
        $condition = "Status!=9 AND CreateDate>=unix_timestamp('$DateString')";

        if ($Status) $condition .= " AND Status=$Status";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_manager WHERE $condition");

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
    }

    public function GetStoreDetailsByRecordID($RecordID=0) {
        if(!$RecordID) return 0;
        $fileds = "*";
        $condition = "RecordID=$RecordID";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_store WHERE $condition");

        return $this->fetch_assoc($stmt);
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

    public function insert(string $table, array $data): bool {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->execute($sql, array_values($data));
    }

    public function getLastInsertID() {
        return $this->pdo->lastInsertId();
    }

    public function update(array $data, string $where, array $params): bool {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE lunch_manager SET $set WHERE $where";  
        return $this->execute($sql, array_merge(array_values($data), $params));
    }

    public function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
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
}