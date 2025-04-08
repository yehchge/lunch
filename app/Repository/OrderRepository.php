<?php

class OrderRepository
{
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    public function insert(string $table, array $data): bool {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->execute($sql, array_values($data));
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

    public function CreateOrder($ManagerID=0,$OrderMan='',$PdsID=0,$PdsName='',$Price=0,$Count=0,$Note='',$CreateMan='') {
        if (!$ManagerID or !$OrderMan or !$PdsID or !$PdsName or !$Price or !$Count  or !$CreateMan) return 0;
        $tt = time();

        $result = $this->insert('lunch_order', [
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
        ]);

        if($result){
            return $this->getLastInsertID('lunch_order');
        }

        return 0;                  
    }

    public function getLastInsertID($table='') {
        return $this->pdo->lastInsertId();
    }
    
}