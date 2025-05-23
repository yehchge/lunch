<?php

/**
 * Routes
 */


$routes = new Router();

$routes->get('', 'Home::index', false);

$routes->get('news', [News::class, 'index'], false);
$routes->get('news/new', [News::class, 'new'], false);
$routes->post('news/create', [News::class, 'create'], false);
$routes->get('news/(:segment)', [News::class, 'show'], false);

$routes->get('employee', 'Employee::index', false);
$routes->get('employee/(:segment)', 'Employee::show/$1', false);
$routes->post('employee', 'Employee::create', false);
$routes->put('employee/(:segment)', 'Employee::update/$1', false);
$routes->delete('employee/(:segment)', 'Employee::delete/$1', false);


// 4. Smarty sample
$routes->get('smarty', [SmartyController::class, 'index'], false); // Smarty


// 3. CodeIgniter 3 Version Page
$routes->get('welcome', [Home::class, 'welcome'], false); // 3. CodeIgniter 3 Version Page


// 2. Pagination with search filter (Pagination sample)
$routes->get('pagination', [PaginationController::class, 'index'], false); // 分頁練習
$routes->get('loadRecord', [PaginationController::class, 'loadRecord'], false); // 分頁練習

// 1. Static Pages
$routes->get('pages', [Pages::class, 'index'], false);
$routes->get('(:segment)', [Pages::class, 'view'], false);


return $routes;






return [
    '' => ['Home', 'index', false],

    // 'home/index' => ['Home', 'index', true], // 需要登入
    'store/list' => ['CStore', 'list', true],
    'store/add' => ['CStore', 'add', true],
    'store/create' => ['CStore', 'create', true],
    'store/edit' => ['CStore', 'edit', true],
    'store/update' => ['CStore', 'update', true],
    'store/show' => ['CStore', 'show', true],
    'store/assign' => ['CStore', 'assign', true],
    'store/assigned' => ['CStore', 'assigned', true],
    'store/listAssign' => ['CStore', 'listAssign', true],
    'store/editStatus' => ['CStore', 'editStatus', true],
    'store/editStatused' => ['CStore', 'editStatused', true],
    'product/list' => ['CProduct', 'list', true],
    'product/add' => ['CProduct', 'add', true],
    'product/edit' => ['CProduct', 'edit', true],
    'product/update' => ['CProduct', 'update', true],
    'product/listStore' => ['CProduct', 'listStore', true],
    'manager/list' => ['CManager', 'list', true],
    'manager/listOrder' => ['CManager', 'listOrder', true],
    'order/list' => ['COrder', 'list', true],
    'order/add' => ['COrder', 'add', true],
    'order/create' => ['COrder', 'create', true],
    'order/edit' => ['COrder', 'edit', true],
    'order/update' => ['COrder', 'update', true],
    'login' => ['CLogin', 'index', false],  // 不需要登入
    'logout' => ['CLogout', 'index', false], // 不需要登入

    // 10. RESTful API
    // $routes->resource('employee');
    // $routes->resource('employee', ['only' =>['index', 'create', 'show', 'update', 'delete']]);
    // $routes->resource('employee', ['except' =>['new', 'edit']]);
    // $routes->presenter('emp');

    'employee' => ['Employee', 'index', false],
    'employee/(:segment)' => ['Employee', 'show', false],
    'employee' => ['Employee', 'create', false],
    // 'employee/new' => ['Employee::new', false],
    // 'employee/(:segment)/edit' => ['Employee::edit/$1', false],
    // 'employee/(:segment)' => ['Employee::update/$1', false],
    // 'employee/(:segment)' => ['Employee::update/$1', false],
    // 'employee/(:segment)' => ['Employee::delete/$1', false],




    // 9. Working with Uploaded Files
    'upload' => ['Upload', 'index', false],         // Add this line.
    'upload/upload' => ['Upload', 'upload', false], // Add this line.

    // 8. News Section
    'news' => ['News', 'index', false],
    'news/new' => ['News', 'new', false],
    'news/create' => ['News', 'create', false],
    'news/(:segment)' => ['News', 'show', false],

    // 7. Custom Pagination
    'codestar' => ['Main', 'index', false],

    // 6. Pagination Specifying the URI Segment for Page
    'pgusers/(:segment)' => ['PaginationController', 'getAll', false],
    'pgusers' => ['PaginationController', 'getAll', false],

    // 5. maintenance Page
    'maintenance' => ['Maintenance', 'index', false], // 4. 維護頁練習

    // 4. Smarty sample
    'smarty' => ['SmartyController', 'index', false], // Smarty

    // 3. CodeIgniter 3 Version Page
    'welcome' => ['Home', 'welcome', false], // 3. CodeIgniter 3 Version Page

    // 2. Pagination with search filter (Pagination sample)
    'pagination' => ['PaginationController', 'index', false], // 分頁練習
    'loadRecord' => ['PaginationController', 'loadRecord', false], // 分頁練習

    // 1. Static Pages
    'pages' => ['Pages', 'index', false],
    '(:segment)' => ['Pages', 'view', false]
];
