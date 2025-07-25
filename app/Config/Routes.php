<?php

/**
 * Routes
 */

use App\System\Router;
use App\Filters\AuthUser;
use App\Filters\AuthMvcUser;
use App\Filters\AuthMvcOwner;
use App\Filters\ApiAuthFilter;

$routes = new Router();

// $routes->get('home/index', [Home::class, 'index'], [AuthUser::class]); // 需要登入
$routes->get('store/list', [CStore::class, 'list'], [AuthUser::class]);
$routes->get('store/add', [CStore::class, 'add'], [AuthUser::class]);
$routes->post('store/create', [CStore::class, 'create'], [AuthUser::class]);
$routes->get('store/edit', [CStore::class, 'edit'], [AuthUser::class]);
$routes->post('store/update', [CStore::class, 'update'], [AuthUser::class]);
$routes->get('store/show', [CStore::class, 'show'], [AuthUser::class]);
$routes->get('store/assign', [CStore::class, 'assign'], [AuthUser::class]);
$routes->get('store/assigned', [CStore::class, 'assigned'], [AuthUser::class]);
$routes->get('store/list_assign', [CStore::class, 'listAssign'], [AuthUser::class]);
$routes->get('store/edit_status', [CStore::class, 'editStatus'], [AuthUser::class]);
$routes->post('store/editStatus', [CStore::class, 'editStatus'], [AuthUser::class]);
$routes->get('product/list', [CProduct::class, 'list'], [AuthUser::class]);
$routes->post('product/add', [CProduct::class, 'add'], [AuthUser::class]);
$routes->get('product/edit', [CProduct::class, 'edit'], [AuthUser::class]);
$routes->post('product/update', [CProduct::class, 'update'], [AuthUser::class]);
$routes->get('product/list_store', [CProduct::class, 'listStore'], [AuthUser::class]);
$routes->get('manager/list', [CManager::class, 'list'], [AuthUser::class]);
$routes->get('manager/list_order', [CManager::class, 'listOrder'], [AuthUser::class]);
$routes->get('order/list', [COrder::class, 'list'], [AuthUser::class]);
$routes->get('order/add', [COrder::class, 'add'], [AuthUser::class]);
$routes->post('order/add', [COrder::class, 'add'], [AuthUser::class]);
$routes->get('order/edit', [COrder::class, 'edit'], [AuthUser::class]);
$routes->post('order/edit', [COrder::class, 'edit'], [AuthUser::class]);
$routes->get('login', [CLogin::class, 'index']);   // 不需要登入
$routes->post('login', [CLogin::class, 'index']);   // 不需要登入
$routes->get('logout', [CLogout::class, 'index']); // 不需要登入


$routes->get('', 'Home::index');

// 13. ci_tutorial
$routes->get('tutorial', [Tutorial::class, 'index']);
$routes->get('tutorial/dashboard', [Tutorial::class, 'dashboard']);
$routes->get('tutorial/dashboard/login', [Tutorial::class, 'login']);
$routes->post('tutorial/dashboard/login/(:segment)', [Tutorial::class, 'login']);
$routes->get('tutorial/dashboard/home', [Tutorial::class, 'home']);
$routes->get('tutorial/dashboard/account', [Tutorial::class, 'account']);

$routes->get('tutorial/admin', [TutorialAdmin::class, 'index']);
$routes->get('tutorial/admin/login', [TutorialAdmin::class, 'login']);
$routes->post('tutorial/admin/login/(:segment)', [TutorialAdmin::class, 'login']);
$routes->get('tutorial/admin/home', [TutorialAdmin::class, 'home']);
$routes->get('tutorial/admin/logout', [TutorialAdmin::class, 'logout']);
$routes->post('tutorial/admin/create_user', [TutorialAdmin::class, 'create_user']);
$routes->get('tutorial/admin/delete_user/(:segment)', [TutorialAdmin::class, 'delete_user']);

// 12. MVC
$routes->get('mvc', [Mvc::class, 'index']);
$routes->get('mvc/index', [Mvc::class, 'index']);
$routes->get('mvc/help', [Mvc::class, 'help']);
$routes->get('mvc/login', [Mvc::class, 'login']);
$routes->post('mvc/login/run', [Mvc::class, 'run']);
$routes->get('mvc/form', [Mvc::class, 'form']);
$routes->post('mvc/form', [Mvc::class, 'form']);

$routes->get('mvc/dashboard', [Mvc::class, 'dashboard'], [AuthMvcUser::class]);
$routes->get('mvc/dashboard/logout', [Mvc::class, 'logout']);
$routes->get('mvc/xhrGetListings', [Mvc::class, 'xhrGetListings']);
$routes->post('mvc/xhrDeleteListing', [Mvc::class, 'xhrDeleteListing']);
$routes->post('mvc/xhrInsert', [Mvc::class, 'xhrInsert']);

$routes->get('mvc/note', [Note::class, 'index'], [AuthMvcUser::class]);
$routes->post('mvc/note/create', [Note::class, 'create'], [AuthMvcUser::class]);
$routes->get('mvc/note/delete/(:segment)', [Note::class, 'delete']);
$routes->get('mvc/note/edit/(:segment)', [Note::class, 'edit'], [AuthMvcUser::class]);
$routes->post('mvc/note/editSave/(:segment)', [Note::class, 'editSave'], [AuthMvcUser::class]);

$routes->get('mvc/user', [MvcUser::class, 'index'], [AuthMvcOwner::class]);
$routes->post('mvc/user/create', [MvcUser::class, 'create'], [AuthMvcOwner::class]);
$routes->get('mvc/user/edit/(:segment)', [MvcUser::class, 'edit'], [AuthMvcOwner::class]);
$routes->post('mvc/user/editSave/(:segment)', [MvcUser::class, 'editSave'], [AuthMvcOwner::class]);
$routes->get('mvc/user/delete/(:segment)', [MvcUser::class, 'delete'], [AuthMvcOwner::class]);

// 11. RESTful API JWT Authentication

// JWT API
$routes->post('api/register', [ApiRegister::class, 'index']);
$routes->post('api/login', [ApiLogin::class, 'index']);
$routes->get('api/users', [ApiUser::class, 'index'], [ApiAuthFilter::class]); // 'filter' => 'authFilter'

// 10. RESTful API
// $routes->resource('employee');
// $routes->resource('employee', ['only' =>['index', 'create', 'show', 'update', 'delete']]);
// $routes->resource('employee', ['except' =>['new', 'edit']]);
// $routes->presenter('emp');

$routes->get('emp', 'Emp::index');
$routes->get('emp/new', 'Emp::new');
$routes->get('emp/edit/(:segment)', 'Emp::edit/$1');

$routes->get('employee', 'Employee::index');
$routes->get('employee/(:segment)', 'Employee::show/$1');
$routes->post('employee', 'Employee::create');
$routes->put('employee/(:segment)', 'Employee::update/$1');
$routes->delete('employee/(:segment)', 'Employee::delete/$1');

// 9. Working with Uploaded Files
$routes->get('upload', [Upload::class, 'index']);         // Add this line.
$routes->post('upload/upload', [Upload::class, 'upload']); // Add this line.

// 8. News Section
$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news/create', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show']);

// 7. Custom Pagination
$routes->get('codestar', [Main::class, 'index']);

// 6. Pagination Specifying the URI Segment for Page
$routes->get('pgusers/(:segment)', [PaginationController::class, 'getAll']);
$routes->get('pgusers', [PaginationController::class, 'getAll']);

// 5. maintenance Page
$routes->get('maintenance', [Maintenance::class, 'index']); // 4. 維護頁練習

// 4. Smarty sample
$routes->get('smarty', [SmartyController::class, 'index']); // Smarty

// 3. CodeIgniter 3 Version Page
$routes->get('welcome', [Home::class, 'welcome']); // 3. CodeIgniter 3 Version Page

// 2. Pagination with search filter (Pagination sample)
$routes->get('pagination', [PaginationController::class, 'index']); // 分頁練習
$routes->get('loadRecord', [PaginationController::class, 'loadRecord']); // 分頁練習

// 1. Static Pages
$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);

return $routes;
