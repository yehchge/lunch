<?php

namespace App\Controllers;

use App\System\Database;
use App\Repository\ManagerRepository;
use App\System\Template;
use App\System\Paginator;

class CManager
{
    // DinBenDon(今日)
    public function list()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        //產生本程式功能內容
        // Page Start ************************************************
        
        $Status = 1; // 只顯示訂購中

        // 資料總筆數
        $totalItems = $managerRepo->GetAllManagerCount($Status);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'manager/list', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************ 

        $rows = $managerRepo->GetAllManagerPage($Status, $PayType, $startRow, $maxRows); //* Page *//
        if ($rows) { $row = $managerRepo->fetch_assoc($rows);
        }

        $items = [];

        if ($row != null) {
            $i=0;
            while ($row != null) {
                $temp = [];
                if ($i==0) {
                    $class = "Forums_Item";
                    $i=1;
                } else {
                    $class = "Forums_AlternatingItem";
                    $i=0;
                }
                $temp['classname'] = $class;
                $temp['managerid'] = $row['RecordID'];
                $temp['createdate'] = date("Y-m-d H:i:s", $row['CreateDate']);
                $temp['man'] = $row['Manager'];
                $temp['storeid'] = $row['StoreID'];
                $info = $managerRepo->GetStoreDetailsByRecordID($row['StoreID']);
                $temp['storename'] = $info['StoreName'];
                $temp['status'] = $managerRepo->ManagerStatus[$row['Status']];

                $items[] = $temp;

                $row = $managerRepo->fetch_assoc($rows);
            }
        }

        $tpl->assign('items', $items);

        $tpl->assign('totalrows', "共 ".$managerRepo->GetAllManagerCount($Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('title', 'DinBenDon(指定店家) - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/OrderStore.htm');
    }

    // DinBenDon明細
    public function listOrder()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);
        
        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");
        
        // 產生本程式功能內容
        // Page Start ************************************************ 

        // 資料總筆數
        $totalItems = $managerRepo->GetActiveManagerPageCount();

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'manager/list_order', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************
        
        $Status = 1; // 只顯示訂購中
        $rows = $managerRepo->GetActiveManagerPage($Status, $PayType, $startRow, $maxRows); //* Page *//
        
        $items = [];
        $i = 0;

        while($row = $managerRepo->fetch_assoc($rows)){
            $temp = [];

            $info = $managerRepo->GetStoreDetailsByRecordID($row['StoreID']);

            if ($i==0) {
                $class = "Forums_Item";
                $i=1;
            } else {
                $class = "Forums_AlternatingItem";
                $i=0;
            }

            $temp['classname'] = $class;
            $temp['managerid'] = $row['RecordID'];
            $temp['createdate'] = date("Y-m-d H:i:s", $row['CreateDate']);
            $temp['editdate'] = date("Y-m-d H:i:s", $row['EditDate']);
            $temp['man'] = $row['Manager'];
            $temp['storename'] = $info['StoreName'];
            $temp['status'] = $managerRepo->ManagerStatus[$row['Status']];

            $items[] = $temp;
        }

        $tpl->assign('items', $items);

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);

        $tpl->assign('totalrows', "共 ".$managerRepo->GetActiveManagerPageCount()." 筆"); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('title', 'DinBenDon明細 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon明細');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/ListOrder.htm');
    }
}
