<?php

declare(strict_types=1); // 嚴格類型

class StoreRepository {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
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

}
