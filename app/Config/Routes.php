<?php

/**
 * Routes
 */


$routes = new Router();


// $routes->get('home/index', [Home::class, 'index'], true); // 需要登入
$routes->get('store/list', [CStore::class, 'list'], true);
$routes->get('store/add', [CStore::class, 'add'], true);
$routes->get('store/create', [CStore::class, 'create'], true);
$routes->get('store/edit', [CStore::class, 'edit'], true);
$routes->get('store/update', [CStore::class, 'update'], true);
$routes->get('store/show', [CStore::class, 'show'], true);
$routes->get('store/assign', [CStore::class, 'assign'], true);
$routes->get('store/assigned', [CStore::class, 'assigned'], true);
$routes->get('store/listAssign', [CStore::class, 'listAssign'], true);
$routes->get('store/editStatus', [CStore::class, 'editStatus'], true);
$routes->get('store/editStatused', [CStore::class, 'editStatused'], true);
$routes->get('product/list', [CProduct::class, 'list'], true);
$routes->get('product/add', [CProduct::class, 'add'], true);
$routes->get('product/edit', [CProduct::class, 'edit'], true);
$routes->get('product/update', [CProduct::class, 'update'], true);
$routes->get('product/listStore', [CProduct::class, 'listStore'], true);
$routes->get('manager/list', [CManager::class, 'list'], true);
$routes->get('manager/listOrder', [CManager::class, 'listOrder'], true);
$routes->get('order/list', [COrder::class, 'list'], true);
$routes->get('order/add', [COrder::class, 'add'], true);
$routes->get('order/create', [COrder::class, 'create'], true);
$routes->get('order/edit', [COrder::class, 'edit'], true);
$routes->get('order/update', [COrder::class, 'update'], true);
$routes->get('login', [CLogin::class, 'index'], false);   // 不需要登入
$routes->get('logout', [CLogout::class, 'index'], false); // 不需要登入





















$routes->get('', 'Home::index', false);

// 10. RESTful API
// $routes->resource('employee');
// $routes->resource('employee', ['only' =>['index', 'create', 'show', 'update', 'delete']]);
// $routes->resource('employee', ['except' =>['new', 'edit']]);
// $routes->presenter('emp');

$routes->get('employee', 'Employee::index', false);
$routes->get('employee/(:segment)', 'Employee::show/$1', false);
$routes->post('employee', 'Employee::create', false);
$routes->put('employee/(:segment)', 'Employee::update/$1', false);
$routes->delete('employee/(:segment)', 'Employee::delete/$1', false);

// 9. Working with Uploaded Files
$routes->get('upload', [Upload::class, 'index'], false);         // Add this line.
$routes->post('upload/upload', [Upload::class, 'upload'], false); // Add this line.

// 8. News Section
$routes->get('news', [News::class, 'index'], false);
$routes->get('news/new', [News::class, 'new'], false);
$routes->post('news/create', [News::class, 'create'], false);
$routes->get('news/(:segment)', [News::class, 'show'], false);

// 7. Custom Pagination
$routes->get('codestar', [Main::class, 'index'], false);

// 6. Pagination Specifying the URI Segment for Page
$routes->get('pgusers/(:segment)', [PaginationController::class, 'getAll'], false);
$routes->get('pgusers', [PaginationController::class, 'getAll'], false);

// 5. maintenance Page
$routes->get('maintenance', [Maintenance::class, 'index'], false); // 4. 維護頁練習

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



];
