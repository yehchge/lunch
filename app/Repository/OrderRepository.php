<?php

namespace App\Repository;

use App\System\Database;

class OrderRepository
{
    private $pdo;
    private $debug = 1;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getPdo();
    }

    public function update(array $data, string $where, array $params): bool
    {
        $set = implode(' = ?, ', array_keys($data)) . ' = ?';
        $sql = "UPDATE lunch_order SET $set WHERE $where";  
        return $this->execute($sql, array_merge(array_values($data), $params));
    }

    public function UpdateOrderStatusByRecordID($RecordID=0,$Status=0,$EditMan='')
    {
        if(!$RecordID || !$Status || !$EditMan) { return 0;
        }

        $condition = 'RecordID = ?';

        return $this->update(
            [
            'Status' => $Status,
            'EditDate' => time(),
            'EditMan' => $EditMan
            ], $condition, [$RecordID]
        );
    }

    public function GetOrderDetailsByRecordID($RecordID=0)
    {
        if(!$RecordID) { return 0;
        }
        
        $fileds = "*";
        $condition = "RecordID=$RecordID";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_order WHERE $condition");
        return $this->fetch_assoc($stmt);
    }

    public function GetManagerDetailsByRecordID($RecordID=0)
    {
        if(!$RecordID) { return 0;
        }
        
        $fileds = "*";
        $condition = "RecordID=$RecordID";

        $stmt = $this->queryIterator("SELECT $fileds FROM lunch_manager WHERE $condition");
        return $this->fetch_assoc($stmt);
    }

    public function GetOrderDetailsPageByManagerID($ManagerID=0,$Status=0,$PayType=0,$startRow=0,$maxRows=10)
    {
        if (!$ManagerID) { return 0;
        }

        $values = "*";
        $condition = "1=1 AND Status!=9 AND ManagerID=$ManagerID";
        if($Status) { $condition .= " AND Status=$Status";
        }
        if($PayType) { $condition .= " AND PayType=$PayType";
        }
        $condition .= " ORDER BY Status,PdsID,CreateDate DESC";

        return $this->queryIterator("SELECT $values FROM lunch_order WHERE $condition LIMIT $startRow, $maxRows");
    }

    public function GetOrderDetailsPageCountByManagerID($ManagerID=0,$Status=0,$PayType=0)
    {
        if (!$ManagerID) { return 0;
        }

        $values = "count(*) AS total";
        $condition = "1=1 AND Status!=9 AND ManagerID=$ManagerID";

        if($Status) { $condition .= " AND Status=$Status";
        }
        if($PayType) { $condition .= " AND PayType=$PayType";
        }

        $stmt = $this->queryIterator("SELECT $values FROM lunch_order WHERE $condition");

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
        if(!$stmt) { return 0;
        }
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->execute($sql, array_values($data));
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

    private function handleError(string $message): void
    {
        if ($this->debug) {
            echo "DB Error: $message" . PHP_EOL;
        }
    }

    public function CreateOrder($ManagerID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$CreateMan='')
    {
        if (!$ManagerID or !$OrderMan or !$PdsID or !$PdsName or !$Price or !$Count  or !$CreateMan) { return 0;
        }
        $tt = time();

        $result = $this->insert(
            'lunch_order', [
            'ManagerID' => $ManagerID,
            'OrderMan' => $OrderMan,
            'PdsID' => $PdsID,
            'PdsName' => $PdsName,
            'Price' => $Price,
            'Count' => $Count,
            'Note' => $Note,
            'CreateMan' => $CreateMan,
            'CreateDate' => $tt,
            'EditDate' => $tt,
            'EditMan' => '',
            'Status' => 1
            ]
        );

        if($result) {
            return $this->getLastInsertID();
        }
        return 0;
    }

    public function getLastInsertID()
    {
        return $this->pdo->lastInsertId();
    }
    
}
