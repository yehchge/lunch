<?php

/**
 * 測試分頁
 */

declare(strict_types=1); // 嚴格類型

header('Content-Type: text/html; charset=utf-8');
defined('PATH_ROOT')|| define('PATH_ROOT', realpath(dirname(__FILE__) . '/..'));

require PATH_ROOT."/app/System/Paginator.php";



// 你取得資料總筆數，例如來自資料庫
$totalItems = 1125;

// 每頁幾筆資料
$itemsPerPage = 10;

// 當前頁數（可從 $_GET['page'] 取得）
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 保留其他 query 參數（例如搜尋條件）
$queryParams = $_GET;
unset($queryParams['page']);

$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, '', $queryParams,
    [
        'container_class' => 'flex space-x-1 text-sm',
        'link_class' => 'px-3 py-1 border rounded hover:bg-gray-100',
        'active_class' => 'bg-blue-500 text-white font-bold',
        'disabled_class' => 'opacity-50 cursor-not-allowed',
        'dots_class' => 'px-3 py-1',
        'prev_text' => '←',
        'next_text' => '→',
    ]);

// 拿去查資料的 SQL 用：
$offset = $paginator->offset();
$limit = $paginator->limit();

// 例如：SELECT * FROM table LIMIT $limit OFFSET $offset

// 分頁 HTML 輸出：
echo $paginator->render();
