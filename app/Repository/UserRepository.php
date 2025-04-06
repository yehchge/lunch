<?php

declare(strict_types=1); // 嚴格類型

class UserRepository {
    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateRememberToken($userId, $token) {
        $stmt = $this->pdo->prepare("UPDATE user SET remember_token = :token WHERE id = :id");
        $stmt->execute(['token' => $token, 'id' => $userId]);
    }

    public function findByRememberToken($token) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE remember_token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
