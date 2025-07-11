<?php

// core/Session.php
namespace App\System;

class Session
{
    protected static $instance;
    protected $flashdataKey = '_flashdata';

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 將 Flashdata 取出備用後刪除，確保只用一次
        if (isset($_SESSION[$this->flashdataKey])) {
            $_SESSION[$this->flashdataKey . '_old'] = $_SESSION[$this->flashdataKey];
            unset($_SESSION[$this->flashdataKey]);
        }
    }

    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    // --- Flashdata 支援 ---
    public function setFlashdata(string $key, $value): void
    {
        $_SESSION[$this->flashdataKey][$key]['value'] = $value;
    }

    public function getFlashdata(string $key, $default = null)
    {
        $value = $_SESSION[$this->flashdataKey . '_old'][$key]['value'] ?? $default;

        $_SESSION[$this->flashdataKey . '_old'][$key]['read'] = true;

        // unset($_SESSION[$this->flashdataKey . '_old'][$key]); // 不使用是因為會被讀取兩次
        return $value;
    }

    public function clearFlashdata()
    {
        if (!isset($_SESSION[$this->flashdataKey . '_old'])) { return;
        }

        foreach ($_SESSION[$this->flashdataKey . '_old'] as $data) {
            if (!empty($data['read'])) {
                unset($_SESSION[$this->flashdataKey . '_old']); // 取完刪除
            }
        }

        // 如果清空了就移除
        if (empty($_SESSION[$this->flashdataKey . '_old'])) {
            unset($_SESSION[$this->flashdataKey . '_old']);
        }

    }

    public function hasFlashdata(string $key): bool
    {
        return isset($_SESSION[$this->flashdataKey . '_old'][$key]);
    }


    public function destroy()
    {
        //unset($_SESSION);
        session_destroy();
    }
}
