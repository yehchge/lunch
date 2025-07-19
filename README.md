# README #

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
