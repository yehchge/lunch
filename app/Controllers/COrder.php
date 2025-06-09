<?php

namespace App\Controllers;

use App\System\Database;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\System\Template;
use App\System\JavaScript;
use App\System\Paginator;

class COrder
{
    // 訂購明細
    public function list()
    {
        $db = new Database();
        $orderRepo = new OrderRepository($db);
        
        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $Status = isset($_REQUEST['status'])?$_REQUEST['status']:0; // 只顯示訂購中
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $ManagerID = isset($_REQUEST['mid'])?$_REQUEST['mid']:0;

        //產生本程式功能內容
        // Page Start ************************************************ 
        

        // 資料總筆數
        $totalItems = $orderRepo->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'order/list', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();


        // Page Ended ************************************************ 
        $rows = $orderRepo->GetOrderDetailsPageByManagerID($ManagerID,$Status,$PayType,$startRow,$maxRows); //* Page *//
        
        $Minfo = $orderRepo->GetManagerDetailsByRecordID($ManagerID);

        $items = [];
        $i = 0;

        while($row = $orderRepo->fetch_assoc($rows)) {
            $temp = [];

            if ($i==0) {
                $class = "Forums_Item";
                $i=1;
            } else {
                $class = "Forums_AlternatingItem";
                $i=0;
            }
            
            if ($row['Status']==1) {
                $str = "正常";
            } else if ($row['Status']==2) {
                $str = "取消";
            } else if ($row['Status']==9) {
                $str = "刪除";
            } else {
                $str = "異常";
            }
            
            if ($Minfo['Status']==1) {
                $strStatus = "<a href='".BASE_URL."order/edit?id=".$row['RecordID']."&mid=$ManagerID'><img src='".BASE_URL."assets/images/edit_s.gif' border='0'></a>";
            } else {
                $strStatus = "<img src='".BASE_URL."assets/images/lock.gif' border='0'>";
            }

            $temp['classname'] = $class;
            $temp['orderid'] = $row['RecordID'];
            $temp['managerid'] = $ManagerID;
            $temp['pdsname'] = $row['PdsName'];
            $temp['count'] = $row['Count'];
            $temp['price'] = $row['Price'];
            $temp['man'] = $row['OrderMan'];
            $temp['note'] = mb_substr($row['Note'],0,30,'utf-8').'...';
            $temp['createdate'] = date("Y-m-d H:i:s",$row['CreateDate']);
            $temp['status'] = $str;
            $temp['editstatus'] = $strStatus;

            $items[] = $temp;
        }

        $tpl->assign('items', $items);

        $tpl->assign('totalrows',"共 ".$orderRepo->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);
        $tpl->assign('title', '訂購人明細 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon明細/訂購人明細');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/OrderDetails.htm');
    }

    public function add()
    {
        if($_POST){
            return $this->create();
        }

        $db = new Database();
        $orderRepo = new OrderRepository($db);
        $productRepo = new ProductRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $Status = 1; // 顯示正常狀態的資料
        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $ManagerID = isset($_REQUEST['mid'])?$_REQUEST['mid']:0;

        // 產生本程式功能內容
        // Page Start ************************************************
        
        // 資料總筆數
        $totalItems = $productRepo->GetAllPdsCountByStore($StoreID, $Status);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'order/add', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();

        // Page Ended ************************************************

        $rows = $productRepo->GetAllPdsPageByStore($StoreID,$Status,'',$startRow,$maxRows); //* Page *//

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
            $temp['editpdsid'] = "<a href='".BASE_URL."product/edit?id=".$row['RecordID']."&sid=$StoreID'>修改</a>";
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
        $tpl->assign('mid',$ManagerID);

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);

        $tpl->assign('title', 'DinBenDon - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon/訂購GO');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/OrderLunch.htm');
    }

    // 新增表單送出
    public function create()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $orderRepo = new OrderRepository($db);
        $productRepo = new ProductRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $UserInfo['name'] = 'John';
        $chkid = isset($_POST["chk"])?$_POST["chk"]:0;
        $ManagerID = $_POST["mid"];

        //CheckBox 抓值
        $str = "您所訂購商品明細如下：<br>";
        $str .= "========================<br>";

        if (!$chkid) {
            $str .= "您未勾選!!<br>";
        } 

        $i = 0;
        $items = [];

        foreach ($chkid as $key => $value) {
            $temp = [];

            if ($i==0) {
                $class = "Forums_Item";
                $i=1;
            } else {
                $class = "Forums_AlternatingItem";
                $i=0;
            }

            $PdsID = $value;
            $Count = trim($_POST["cnt".$value]);
            $Note = trim($_POST["note".$value]);

            $info = $productRepo->GetPdsDetailsByRecordID($PdsID);

            $PdsName = $info['PdsName'];
            $Price = $info['Price'];

            // 寫入訂單中
            $ret = $orderRepo->CreateOrder($ManagerID,$UserInfo['name'],$PdsID,$PdsName,$Price,$Count,$Note,$Online['email']);

            if ($ret) {
                $strret = "訂購成功! RecordID: $ret";
            } else {
                $strret = "失敗!";
            }
            $str .= "商品:$PdsName, 單價:$Price, 數量:$Count,備註:$Note, $strret<br>";

            $temp['classname'] = $class;
            $temp['pdsname'] = $PdsName;
            $temp['price'] = $Price;
            $temp['count'] = $Count;
            $temp['note'] = $Note;

            $items[] = $temp;
        }

        echo "str =  $str<br>";

        if ($i==0) {
            $class = "Forums_Item";
        } else {
            $class = "Forums_AlternatingItem";
        }

        $tpl->assign('items', $items);
        $tpl->assign('classname1',$class);
        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);
        $tpl->assign('title', '訂購結果 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon/訂購GO/訂購商品結果');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/OrderLunched.htm');
    }

    // 訂單編輯
    public function edit()
    {
        if ($_POST){
            return $this->update();
        }

        $db = new Database();
        $userRepo = new UserRepository($db);
        $orderRepo = new OrderRepository($db);

        $id = trim($_REQUEST['id']);
        $ManagerID = trim($_REQUEST['mid']);
     
        $Online = $userRepo->findById($_SESSION['user_id']);

        $info = $orderRepo->GetOrderDetailsByRecordID($id);
      
        // 限制只有訂購人可修改狀態
        if (strcmp(trim($Online['email']), trim($info['CreateMan']))<>0) {
            JavaScript::vAlertBack('ㄟ! 只有訂購人可修改!別偷改喔!');
            return;
        }   
        
        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $tpl->assign('orderid',$id);
        $tpl->assign('managerid',$ManagerID);
        $tpl->assign('orderman',$info['OrderMan']);
        $tpl->assign('pdsname',$info['PdsName']);
        $tpl->assign('price',$info['Price']);
        $tpl->assign('count',$info['Count']);
        $tpl->assign('note',$info['Note']);
        $tpl->assign('createdate',date("Y-m-d",$info['CreateDate']));

        // 選擇DropDownList設定狀態保留
        if (!empty($info['Status'])) {
            $tpl->assign('javaScript', "<script>seldroplist(this.frm.status,'".$info['Status']."');</script>");
        }

        $tpl->assign('title', '管理使用者訂單狀態 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon明細/訂購人明細/管理訂購人明細狀態');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        return $tpl->display(class_basename($this).'/EditOrder.htm');      
    }

    // 訂單編輯送出
    public function update()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $orderRepo = new OrderRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $RecordID = trim($_POST["orderid"]);
        $Status = trim($_POST["status"]);
        $ManagerID = trim($_POST["managerid"]);
      
        //產生本程式功能內容
        if ($orderRepo->UpdateOrderStatusByRecordID($RecordID,$Status,$Online['email'])) {
            JavaScript::vAlertRedirect('更新狀態成功!', BASE_URL."order/list?mid=$ManagerID");
        } else {
            JavaScript::vAlertBack('更新狀態失敗!');
        }   
    }

}
