# README #

This is a lunch system. 

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
