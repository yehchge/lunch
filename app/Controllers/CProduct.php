<?php

namespace App\Controllers;

class CProduct
{
    // 顯示資料列表
    public function list()
    {
        $db = new Database();
        $productRepo = new ProductRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        //產生本程式功能內容
        // Page Start ************************************************ 
        

        // 資料總筆數
        $totalItems = $productRepo->GetAllPdsCountByStore($StoreID);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'product/list', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************

        $rows = $productRepo->GetAllPdsPageByStore($StoreID,'','',$startRow,$maxRows); //* Page *//
        
        $i=0;
        $items = [];

        while($row = $productRepo->fetch_assoc($rows)){
            $temp = [];

           if ($i==0) {
                $class = "Forums_Item";
                $i=1;
            } else {
                $class = "Forums_AlternatingItem";
                $i=0;
            }

            $status = ($row['Status']==1)?"正常":"停用";

            $temp['classname'] = $class;
            $temp['storeid'] = $StoreID;
            $temp['pdsid'] = $row['RecordID'];
            $temp['status'] = $status;
            $temp['pdsname'] = $row['PdsName'];
            $temp['pdstype'] = $row['PdsType'];
            $temp['price'] = $row['Price'];
            $temp['note'] = mb_substr($row['Note'],0,30,'utf-8').'...';

            $items[] = $temp;
        }
             
        $tpl->assign('items', $items);
        $tpl->assign('totalrows',"共 ".$productRepo->GetAllPdsCountByStore($StoreID)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);

        $tpl->assign('id', $StoreID);

        $tpl->assign('title', '商品明細維護 - DinBenDon系統');
        $tpl->assign('breadcrumb', '商品明細維護');
        $tpl->assign('baseUrl', BASE_URL);
        return $tpl->display(class_basename($this).'/PdsDetails.htm');
    }

    // 新增表單送出
    public function add()
    {
        if (!$_POST) return '';

        $db = new Database();
        $userRepo = new UserRepository($db);
        $productRepo = new ProductRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);
        
        $PdsName = trim($_POST["pdsname"]);
        $PdsType = trim($_POST["pdstype"]);
        $Price = trim($_POST["pdsprice"]);
        $Note = trim($_POST["pdsnote"]);
        $StoreID = trim($_POST["pdsid"]);
      
        //產生本程式功能內容
        if ($productRepo->CreateProduct($StoreID,$PdsName,$PdsType,$Price,$Online['email'],$Note)) {
            JavaScript::vAlertRedirect('新增成功!', BASE_URL."product/list?id=$StoreID");
        } else {
            JavaScript::vAlertBack('新增失敗!');
        }
    }

    // 顯示編輯表單
    public function edit()
    {
        $db = new Database();
        $productRepo = new ProductRepository($db);

        $id = trim($_GET['id']);
        $sid = trim($_GET['sid']);

        // 產生本程式功能內容; 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $info = $productRepo->GetPdsDetailsByRecordID($id);

        $status = ($info['Status']==1)?'':"checked";

        $tpl->assign('pdsid', $id);
        $tpl->assign('sid', $sid);
        $tpl->assign('pdsid', $info['RecordID']);
        $tpl->assign('pdsname', htmlspecialchars($info['PdsName']));
        $tpl->assign('pdstype', $info['PdsType']);
        $tpl->assign('price', $info['Price']);
        $tpl->assign('note', $info['Note']);
        $tpl->assign('status', $status);
   
        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);
        $tpl->assign('title', '更新商品明細 - DinBenDon系統');
        $tpl->assign('breadcrumb', '店家維護/明細維護/更新明細');
        $tpl->assign('baseUrl', BASE_URL);
        return $tpl->display(class_basename($this).'/EditPds.htm');
    }

    // 編輯表單送出
    public function update()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $productRepo = new ProductRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $RecordID = trim($_POST["pdsid"]);
        $StoreID = trim($_POST["sid"]);
        $PdsName = trim($_POST["pdsname"]);
        $PdsType = trim($_POST["pdstype"]);
        $Price = trim($_POST["price"]);
        $Tel = isset($_POST["tel"])?trim($_POST["tel"]):'';
        $Note = trim($_POST["note"]);
        $status = isset($_POST["status"])?trim($_POST["status"]):1;
      
        if ($status=="on") {$cancel=2;} else {$cancel=1;}
        
        //產生本程式功能內容
        if ($productRepo->UpdateProduct($RecordID,$StoreID,$PdsName,$PdsType,$Price,$Online['email'],$Note,$cancel)) {
            JavaScript::vAlertRedirect('更新明細成功!', BASE_URL."product/list?id=$StoreID");
        } else {
            JavaScript::vAlertBack('更新明細失敗!');
        }
    }

    // 顯示店家商品明細
    public function listStore()
    {
        $db = new Database();
        $productRepo = new ProductRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $Status = 1; // 顯示正常狀態的資料


        // 產生本程式功能內容
        // Page Start ************************************************
        
        // 資料總筆數
        $totalItems = $productRepo->GetAllPdsCountByStore($StoreID,$Status);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'product/listStore', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************

        $row = NULL;
        $rows = $productRepo->GetAllPdsPageByStore($StoreID,$Status,'',$startRow,$maxRows); //* Page *//

        $items = [];
        $i=0;

        while($row = $productRepo->fetch_assoc($rows)) {
            $temp = [];
         
            if ($i==0) {
                $class = "Forums_Item";
                $i=1;
            } else {
                $class = "Forums_AlternatingItem";
                $i=0;
            }
            
            $status = ($row['Status']==1)?"正常":"停用";

            $temp['classname'] = $class;
            $temp['pdsid'] = $row['RecordID'];
            $temp['status'] =  $status;
            $temp['pdsname'] = $row['PdsName'];
            $temp['pdstype'] = $row['PdsType'];
            $temp['price'] = $row['Price'];
            $temp['note'] = mb_substr($row['Note'],0,30,'utf-8').'...';
                
            $items[] = $temp;
        }

        $tpl->assign('items', $items);
        $tpl->assign('totalrows',"共 ".$productRepo->GetAllPdsCountByStore($StoreID,$Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *//

        $tpl->assign('id',$StoreID);
        $tpl->assign('baseUrl', BASE_URL);

        return $tpl->display(class_basename($this).'/UsrPdsDetails.htm');
    }

}