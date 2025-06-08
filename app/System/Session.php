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
        $_SESSION[$this->flashdataKey][$key] = $value;
    }

    public function getFlashdata(string $key, $default = null)
    {
        $value = $_SESSION[$this->flashdataKey . '_old'][$key] ?? $default;
        unset($_SESSION[$this->flashdataKey . '_old'][$key]); // 取完刪除
        return $value;
    }

    public function hasFlashdata(string $key): bool
    {
        return isset($_SESSION[$this->flashdataKey . '_old'][$key]);
    }
}
