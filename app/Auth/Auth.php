<?php

namespace App\Auth;

use App\Repository\UserRepository;

class Auth {

    private $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login($username, $password, $rememberMe = false) {
        $user = $this->userRepo->findByEmail($username);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];

            if ($rememberMe) {
                $token = bin2hex(random_bytes(50));
                setcookie("remember_me", $token, time() + 86400 * 30, "/", "", false, true);
                $this->userRepo->updateRememberToken($user['id'], $token);
            }

            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        setcookie("remember_me", "", time() - 3600, "/", "", false, true);
    }

    public function check() {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        if (!empty($_COOKIE['remember_me'])) {

            $user = $this->userRepo->findByRememberToken($_COOKIE['remember_me']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                return true;
            }
        }

        return false;
    }

    public function user() {
        if (isset($_SESSION['user_id'])) {
            return $this->userRepo->findByEmail($_SESSION['user_id']);
        }
        return null;
    }
}