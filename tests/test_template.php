<?php

/**
 * 測試 template.php
 * @created 2025/04/04
 */

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/app/System/Template.php";

$template = new Template('views');
$template->setDelimiters('<{', '}>');

$template->assign('title', '我的網站');
$template->assign('message', '這是一條訊息');
$template->assign('isLoggedIn', true);
$template->assign('username', 'Alice');
$template->assign('items', ['蘋果', '香蕉', '櫻桃']);

// 指定變數
$template->assign('objects', [
    (object)['title' => 'First'],
    (object)['title' => 'Second']
]);

// 指定變數2
$template->assign('skys', [
    ['title' => '太陽'],
    ['title' => '月亮']
]);

echo $template->render('example.htm');
