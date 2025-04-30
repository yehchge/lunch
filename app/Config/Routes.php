<?php

/**
 * Routes
 */

return [
    '' => ['Home', 'index', false],
    'pagination' => ['PaginationController', 'index', false], // 分頁練習
    'loadRecord' => ['PaginationController', 'loadRecord', false], // 分頁練習
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
    'pages' => ['Pages', 'index', false],
    '(:segment)' => ['Pages', 'view', false]
];