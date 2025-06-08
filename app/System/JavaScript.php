<?php

declare(strict_types=1); // 嚴格類型

// JavaScript::redirect('success.php', '操作成功！');
// JavaScript::displayFlashMessage();
// JavaScript::setFlashMessage('這是一個提示訊息！');
// JavaScript::displayFlashMessage();

namespace App\System;

class JavaScript
{
    private $output = '';

    /* 靜態代理方法, 維持原本的使用方式 */

    public static function vAlertRedirect($msg, $url)
    {
        (new self())->jsAlert($msg)->jsRedirect($url)->render();
    }

    public static function vAlert($msg)
    {
        (new self())->jsAlert($msg)->render();
    }

    public static function vRedirect($url)
    {
        (new self())->redirect($url)->render();
    }

    public static function vAlertBack($msg, $go = -1)
    {
        (new self())->jsAlert($msg)->jsBack($go)->render();
    }

    public function jsBack($go = -1)
    {
        $this->output .= "history.back($go);";
        return $this;
    }

    /* 動態方法供內部與進階使用 */

    public function jsAlert($message)
    {
        $this->output .= "alert('" . addslashes($message) . "');";
        return $this;
    }

    public function jsRedirect($url)
    {
        $this->output .= "window.location.href='" . addslashes($url) . "';";
        return $this;
    }

    public function render($withHeader = true)
    {
        if($withHeader){
            header('Content-type: text/html; charset=utf8');
        }
        echo "<script>{$this->output}</script>";
        $this->clear();
    }

    private function clear()
    {
        $this->output = '';
    }

    /* 貼近框架邏輯，也兼顧安全性與彈性！ */

    // 設定 Flash Message
    public static function setFlashMessage($message)
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $_SESSION['flash_message'] = $message;
    }

    // 取得 Flash Message 並清除
    public static function getFlashMessage()
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $message = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        return $message;
    }

    // 伺服器端轉址
    public static function redirect($url, $message = null)
    {
        if($message){
            self::setFlashMessage($message);
        }
        header('Location: ' . $url);
        exit;
    }

    // 在頁面載入時顯示提示訊息
    public static function displayFlashMessage()
    {
        $message = self::getFlashMessage();
        if($message){
            echo '<div class="flash-message">' . htmlspecialchars($message) . '</div>';
        }
    }
}
