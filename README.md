# 框架分析

本專案是一個遵循標準 MVC 設計模式的 PHP 框架。程式進入點 `index.php` 負責初始化應用，並將請求分派給核心處理。其請求生命週期清晰、模組化且易於擴展。

## 請求生命週期 (Request Lifecycle)

整個框架的請求處理流程如下：

1.  **進入點 (`index.php`)**
    *   載入設定檔 (`app/Config/Config.php`)。
    *   初始化核心服務，如資料庫 (`Database`) 和身份驗證 (`Auth`)。
    *   建立 `Application` 實例並呼叫 `handleRequest()` 方法來處理傳入的 HTTP 請求。

2.  **應用程式核心 (`app/System/Application.php`)**
    *   **過濾器 (Filters)**：在執行主要邏輯前後，執行前置 (Before) 和後置 (After) 過濾器。主要用於處理 CSRF 保護、身份驗證等安全性任務。
    *   **路由 (Routing)**：載入 `app/Config/Routes.php` 中定義的路由規則。
    *   **分派 (Dispatch)**：根據當前請求的 URL，`dispatch()` 方法會找到並執行對應的控制器 (Controller) 方法。
    *   **錯誤處理 (Error Handling)**：提供統一的錯誤處理機制。若是 AJAX 請求則回傳 JSON 格式的錯誤，否則顯示一個 HTML 錯誤頁面。

3.  **路由定義 (`app/Config/Routes.php`)**
    *   使用 `get()`, `post()` 等方法來定義路由，對應到 HTTP 的不同請求方法。
    *   支援靜態路由 (`/login`) 和動態路由 (`/news/(:segment)`)。
    *   可為每個路由或路由群組指定中介層 (Middleware)，例如 `AuthUser::class`，以實現路由級別的存取控制。

這個結構確保了程式碼的高度組織性和可維護性，完全符合一個現代 PHP 框架的設計原則。

---

# README

這是一個自行撰寫的 PHP 框架, 使用 MVC 的架構, 部份程式及練習, 
模仿 CodeIgniter4 的寫法, 模板引擎學習 Smarty, 詢問 AI (Grok),
打造出一個簡易的 Template.php 程式, 後來在學習 CodeIgniter4 的時候,
又尋問 AI, 打造出 ViewEngine.php 的模板引擎.
所以這個專案一直尚未完全, 有想法, 就去嘗試寫出來.
這裡有大部分的程式, 都是之前在練習 CodeIgniter4 的時候, 所練習的範例.
希望這個專案之後能夠朝向好測試、好維護、好開發、輕量、微型框架邁進.

## 網站說明

- 資料庫帳號密碼: .env
- 網站程式風格: .editorconfig
- 網站套件: composer.json (大部分都是檢測網站程式)
- 資料表: ./sqls/*
- 說明文件: ./docs/* (放置之後登入時想做的流程)
- 網站程式: ./app
- 其他資源: ./assets (css、javascript、images、icons)

## 建置方式

- 將 .env.sample 改為 .env , 並修改 .env 內的參數, 符合所需要的資料庫及其他設定.
- Apache 或 PHP 需要內建處理 Rewrite


## RESTful API JWT Authentication

```bash
# Install JWT Package
composer require firebase/php-jwt

# Add JWT Model
php spark make:model ApiUserModel

# Add JWT Migration
php spark make:migration ApiAddUser

# Run JWT Migration
php spark migrate

# Create Controllers
php spark make:controller ApiLogin
php spark make:controller ApiRegister
php spark make:controller ApiUser

# Create Controller Filter
php spark make:filter ApiAuthFilter

# Add ApiAuthFilter to Filters.php
```

## Add JWT_SECRET on .env file
```txt
#----------------------------------------------------------------
# JWT
#----------------------------------------------------------------
JWT_SECRET = 'CodeIgniter4 JSON Web Token (JWT) Authentication'
```

## Register Routes
```php
// JWT API
$routes->group("api", function($routes){
    $routes->post('register', 'ApiRegister::index');
    $routes->post('login', 'ApiLogin::index');
    $routes->get('users', 'ApiUser::index', ['filter' => 'authFilter']);
});
```