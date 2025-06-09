<?php

namespace App\Repository;

use App\System\Database;

class ProductRepository
{
    private $pdo;
    private $debug = 1;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    public function UpdateProduct($RecordID=0,$StoreID=0,$PdsName='',$PdsType='',$Price=0,$EditMan='',$Note='',$Status=0) {
        if(!$RecordID) return 0;

        $result = $this->update([
            'StoreID' => $StoreID,
            'PdsName' => $PdsName,
            'PdsType' => $PdsType,
            'Price' => $Price,
            'EditMan' => $EditMan,
            'EditDate' => time(),
            'Note' => $Note,
            'Status' => $Status
        ], 'RecordID = ?', [$RecordID]);

        if($result) return 1;
        return 0;
    }

    public function CreateProduct($StoreID=0,$PdsName='',$PdsType='',$Price=0,$CreateMan='',$Note='') {
        if (!$StoreID || !$PdsName || !$Price || !$CreateMan) return 0;
        
        $tt = time();

        $result = $this->insert('lunch_product', [
            'StoreID' => $StoreID,
            'PdsName' => $PdsName,
            'PdsType' => $PdsType,
            'Price' => $Price,
            'CreateMan' => $CreateMan,
            'Note' => $Note,
            'Status' => 1,
            'CreateDate' => $tt,
            'EditDate' => $tt,
            'EditMan' => ''
        ]);

        if($result){
            return $this->getLastInsertID();
        }

        return 0;                  
    }

    public function getLastInsertID() {
        return $this->pdo->lastInsertId();
    }

    public function GetPdsDetailsByRecordID($RecordID=0) {
        if(!$RecordID) return 0;
        
        $fileds = "*";
        $condition = "RecordID=$RecordID";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_product WHERE $condition");
        return $this->fetch_assoc($stmt);
    }

    public function GetAllPdsPageByStore($StoreID=0,$Status=0,$PayType=0,$startRow=0,$maxRows=10) {
        if (!$StoreID) return 0;

        $values = "*";

        $condition = "StoreID=$StoreID";
        if($Status) $condition .= " AND Status=$Status";
        if($PayType) $condition .= " AND PayType=$PayType";
        $condition .= " ORDER BY CreateDate DESC";

        return $this->queryIterator("SELECT $values FROM lunch_product WHERE $condition LIMIT $startRow, $maxRows");
    }

    public function GetAllPdsCountByStore($StoreID=0, $Status=0) {
        if (!$StoreID) return 0;
        $fileds = "COUNT(*) AS total";

        $condition = "StoreID=$StoreID";
        if ($Status) $condition .= " AND Status=$Status";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_product WHERE $condition");

        $row = $this->fetch_assoc($stmt);
        return $row['total'];
    }

    public function fetch_assoc($stmt)
    {
        if(!$stmt) return 0;
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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

    public function insert(string $table, array $data): bool {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->execute($sql, array_values($data));
    }

    public function update(array $data, string $where, array $params): bool {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE lunch_product SET $set WHERE $where";  
        return $this->execute($sql, array_merge(array_values($data), $params));
    }

    public function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
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
