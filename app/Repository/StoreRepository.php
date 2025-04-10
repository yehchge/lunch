<?php

declare(strict_types=1); // 嚴格類型

class StoreRepository
{
    private $pdo;
    private $debug = 1;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    public function CreateStore($UserName='',$Password='',$StoreName='',$StoreIntro='',$StoreClass='',$MainMan='',$Tel='',$Address='',$CreateMan='',$Note='') {
        if (!$StoreName || !$StoreIntro || !$StoreClass || !$MainMan || !$Tel || !$Address || !$CreateMan || !$Note) return 0;
        
        $tt = time();
        
        $result = $this->insert('lunch_store', [
            'UserName' => $UserName,
            'Password' => $Password,
            'StoreName' => $StoreName,
            'StoreIntro' => $StoreIntro,
            'StoreClass' => $StoreClass,
            'MainMan' => $MainMan,
            'Tel' => $Tel,
            'Address' => $Address,
            'CreateDate' => $tt,
            'CreateMan' => $CreateMan,
            'EditDate' => $tt,
            'EditMan' => '',
            'Note' => $Note,
            'Status' => 1,
        ]);

        if($result){
            return $this->getLastInsertID();
        }
        return 0;
    }

    public function GetAllStorePage($Status=0,$Name='',$PayType=0,$startRow=0,$maxRows=10) {
        $values = "*";

        $condition = "1=1";
        if($Status) $condition.= " AND Status=$Status";
        if($Name) $condition .= " AND Name like '%$Name''";
        if($PayType) $condition .= " AND PayType=$PayType";
        $condition .= " ORDER BY CreateDate DESC";

        return $this->queryIterator("SELECT $values FROM lunch_store WHERE $condition LIMIT $startRow, $maxRows");
    }

    public function GetAllStoreCount($Status=0) {
        $fileds = "COUNT(*) AS total";

        $condition = "1=1";
        if($Status) $condition.= " AND Status=$Status";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_store WHERE $condition");

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
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

    public function update(array $data, string $where, array $params): bool {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE lunch_store SET $set WHERE $where";  
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

    public function getLastInsertID() {
        return $this->pdo->lastInsertId();
    }

    private function handleError(string $message): void {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
        }
    }

}
