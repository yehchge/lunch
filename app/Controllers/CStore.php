<?php

namespace App\Controllers;

use App\System\Database;
use App\System\CRequest;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use App\Repository\ManagerRepository;
use App\Repository\OrderRepository;
use App\System\Template;
use App\System\JavaScript;
use App\System\Paginator;
use App\System\Validator;

class CStore
{
    // 顯示資料列表
    public function list()
    {
        $db = new Database();
        $request = new CRequest();
        $storeRepo = new StoreRepository($db);
        $tpl = new Template("app/Views");

        // 取得查詢參數
        // $queryParams = $request->getQueryParams();

        // 當前頁數
        // $currentPage = $queryParams['page'] ?? 1;
        
        // 總筆數
        $totalItems = $storeRepo->GetAllStoreCount();

        // 每頁幾筆
        $itemsPerPage = 5;

        $searchData  = $request->getGet();

        $search = '';
        if (isset($searchData) && isset($searchData['search'])) {
            $search = $searchData['search'];
        }

        if ($search == '') {
            $items = $storeRepo->paginate($itemsPerPage);
        } else {
            // do something ...
            
            // $paginator = new Paginator(
            //     $totalItems,
            //     $itemsPerPage,
            //     $currentPage,
            //     BASE_URL.'store/list',
            //     $request->withoutPageParam($queryParams)
            // );

            // $startRow = $paginator->offset();
            // $maxRows = $paginator->limit();
            
            // 查詢條件可從 $queryParams 帶入
            // $Status = 0;
            // $Name = '';
            // $PayType = 0;

            // $rows = $storeRepo->GetAllStorePage($Status, $Name, $PayType, $startRow, $maxRows);
        }

        $tpl->assign('StoreStatus', $storeRepo->StoreStatus);
        $tpl->assign('items', $items);
        $tpl->assign('totalrows', "共 $totalItems 筆");
        $tpl->assign('pageselect', $storeRepo->links());
        $tpl->assign('title', '店家維護 - DinBenDon系統');
        $tpl->assign('breadcrumb', '店家維護');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());

        return $tpl->display(class_basename($this).'/ListStore.htm');
    }

    // 顯示新增表單
    public function add()
    {
        $tpl = new Template("app/Views");

        $errors = session()->getFlashdata('errors');

        $data = explode('<br>', $errors);

        $result = '<ul>';

        foreach ($data as $val) {
            if(!$val) { continue;
            }
            $result .= "<li>$val</li>";
        }

        $result .= '</ul>';


        $tpl->assign('title', '新增店家 - DinBenDon系統');
        $tpl->assign('breadcrumb', '新增店家');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->assign('errors', $result);
        $tpl->display(class_basename($this).'/AddStore.htm');
    }

    // 新增表單送出
    public function create()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $storeRepo = new StoreRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $StoreName = trim($_POST["name"]);
        $StoreIntro = trim($_POST["intro"]);
        $StoreClass = trim($_POST["sclass"]);
        $MainMan = trim($_POST["man"]);
        $Address = trim($_POST["addr"]);
        $Tel = trim($_POST["tel"]);
        $Note = trim($_POST["note"]);


        $data = $_POST;

        $validator = new Validator(
            $data, [
                'name' => 'required',
                'intro'  => 'required',
                'sclass' => 'required',
                'man' => 'required',
                'addr' => 'required',
                'tel' => 'required',
                'note' => 'required',
            ]
        );

        if ($validator->validate()) {
            // echo "Validation passed!\n";
        } else {
            $message = '';
            // 輸出錯誤訊息
            foreach ($validator->getErrors() as $errors) {
                foreach ($errors as $error) {
                    $message .= $error."<br>";
                }
            }

            session()->setFlashdata('errors', $message);
            // return $this->new();
            return JavaScript::redirectTo('./add');
        }




        //產生本程式功能內容
        if ($storeRepo->CreateStore('', '', $StoreName, $StoreIntro, $StoreClass, $MainMan, $Tel, $Address, $Online['email'], $Note)) {
            JavaScript::vAlertRedirect('新增成功!', BASE_URL."store/list");
        } else {
            JavaScript::redirectTo('./add', '新增失敗!');
            // vAlertBack('新增失敗!');
        }
    }

    // 顯示編輯表單
    public function edit()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);

        $id = trim($_GET['id']);
     
        //產生本程式功能內容
        $tpl = new Template("app/Views");

        $info = $managerRepo->GetStoreDetailsByRecordID($id);
        
        $result = [];

        $result['storeid'] = $info['RecordID'];
        $result['sname'] = $info['StoreName'];
        $result['intro'] = $info['StoreIntro'];

        $result['man'] = $info['MainMan'];
        $result['tel'] = $info['Tel'];
        $result['addr'] = $info['Address'];
        $result['createdate'] = date("Y-m-d", $info['CreateDate']);
        $result['editdate'] = date("Y-m-d", $info['EditDate']);
        $result['note'] = $info['Note'];
        if ($info['Status']==1) {
            $result['status'] = "";
        } else {
            $result['status'] = "checked";
        }
      
        // 選擇DropDownList設定狀態保留
        if (!empty($info['StoreClass'])) {
            $result['javaScript'] =  "<script>seldroplisttext(this.frm.sclass,'".$info['StoreClass']."');</script>";
        }

        $tpl->assign('result', $result);
        $tpl->assign('title', '更新店家 - DinBenDon系統');
        $tpl->assign('breadcrumb', '店家維護/更新店家');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->display(class_basename($this).'/EditStore.htm');
    }

    // 編輯表單送出
    public function update()
    {
        // 檢查使用者有沒有登入
        $db = new Database();
        $userRepo = new UserRepository($db);
        $storeRepo = new StoreRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $RecordID = trim($_POST["storeid"]);
        $StoreName = trim($_POST["sname"]);
        $StoreIntro = trim($_POST["intro"]);
        $StoreClass = trim($_POST["sclass"]);
        $MainMan = trim($_POST["man"]);
        $Address = trim($_POST["addr"]);
        $Tel = trim($_POST["tel"]);
        $Note = trim($_POST["note"]);
        $status = isset($_POST["status"])?trim($_POST["status"]):1;
      
        if ($status=="on") {$cancel=2;
        } else {$cancel=1;
        }

        $ret = $storeRepo->update(
            [
            'UserName'   => '',
            'Password'   => '',
            'StoreName'  => $StoreName,
            'StoreIntro' => $StoreIntro,
            'StoreClass' => $StoreClass,
            'MainMan'    => $MainMan,
            'Tel'        => $Tel,
            'Address'    => $Address,
            'EditMan'    => $Online['email'],
            'EditDate'   => time(),
            'Note'       => $Note,
            'Status'     => $cancel,
            ], 'RecordID = ?', [$RecordID]
        );
        
        // 產生本程式功能內容
        if ($ret) {
            JavaScript::vAlertRedirect('更新成功!', BASE_URL.'store/list');
        } else {
            JavaScript::vAlertBack('更新失敗!');
        }
    }

    // 顯示店家單筆詳細資料
    public function show()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);

        $id = trim($_GET['id']);

        $info = $managerRepo->GetStoreDetailsByRecordID($id);

        //產生本程式功能內容
        $tpl = new Template("app/Views");

        $row = [];
              
        $row['storeid'] = $info['RecordID'];
        $row['store'] = $info['StoreName'];
        $row['intro'] = $info['StoreIntro'];
        $row['sclass'] = $info['StoreClass'];
        $row['man'] = $info['MainMan'];
        $row['tel'] = $info['Tel'];
        $row['addr'] = $info['Address'];
        $row['createdate'] = date("Y-m-d", $info['CreateDate']);
        $row['editdate'] = date("Y-m-d", $info['EditDate']);
        $row['note'] = $info['Note'];
        if ($info['Status']==1) {
            $row['status'] = "正常"; 
        } else {
            $row['status'] = "停用";
        }

        $tpl->assign('row', $row);     
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->display(class_basename($this).'/StoreDetail.htm');
    }

    // 指定店家
    public function assign()
    {
        $db = new Database();
        $storeRepo = new StoreRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");

        $Status = 1; // 正常狀態才顯示
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;

        if ($id) {
            echo "<script>\r\n";
            echo "yy=confirm('今日確定要訂購此間店嗎?');\r\n";
            echo "if (yy==0) {history.back();}\r\n";
            echo " else {location='".BASE_URL."store/assigned?id=$id&Url=".urlencode(BASE_URL.'store/assign')."';}\r\n";
            echo "</script>\r\n";
            return;
        }

        //產生本程式功能內容
        // Page Start ************************************************
        
        $Name = '';
        $PayType = 0;
        $page = isset($_GET['page']) ? (int)$_GET['page']:0;
        $SysID = 0;

        // 資料總筆數
        $totalItems = $storeRepo->GetAllStoreCount($Status);

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'store/assign', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************ 

        $rows = $storeRepo->GetAllStorePage($Status, $Name, $PayType, $startRow, $maxRows); //* Page *//
        $row = $storeRepo->fetch_assoc($rows);
        
        if ($row == null) {
            $tpl->assign('items', []);      
        } else {
            $items = [];

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
                $temp['editstoreid'] = "<a href='".BASE_URL."store/assign?Status=$Status&page=$page&Name=$Name&PayType=$PayType&SysID=$SysID&id=".$row['RecordID']."'>指定</a>";
                $temp['storeid'] = $row['RecordID'];
                if ($row['Status']==1) {
                    $temp['status'] = "正常";
                } else {
                    $temp['status'] = "停用";
                }
                
                $temp['storename'] = "<a href='javascript:ShowDetail(\"".BASE_URL."\", {$row['RecordID']});'>{$row['StoreName']}</a>";
                $temp['tel'] = $row['Tel'];
                $temp['man'] = $row['MainMan'];
                $temp['editdate'] = date("Y-m-d", $row['EditDate']);
                
                $items[] = $temp;

                $row = $storeRepo->fetch_assoc($rows);
            }

            $tpl->assign('items', $items);
        }

        $tpl->assign('totalrows', "共 ".$storeRepo->GetAllStoreCount($Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('title', '指定店家 - DinBenDon系統');
        $tpl->assign('breadcrumb', '指定店家');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->display(class_basename($this).'/AssignStore.htm');        
    }

    public function assigned()
    {
        $db = new Database();
        $userRepo = new UserRepository($db);
        $managerRepo = new ManagerRepository($db);
 
        $Online = $userRepo->findById($_SESSION['user_id']);

        $StoreID = trim($_GET["id"]);
        $Url = trim(urldecode($_GET["Url"]));

        if ($managerRepo->CreateManager($StoreID, $Online['email'], '說明:系統指定')) {
            JavaScript::vAlertRedirect('指定商家成功!', $Url);
        } else {
            JavaScript::vAlertBack('指定商家失敗!');
        }
    }

    // 顯示指定店家
    public function listAssign()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("app/Views");
      
        //產生本程式功能內容
        // Page Start ************************************************ 
        
        // 資料總筆數
        $totalItems = $managerRepo->GetAllManagerCount();

        // 每頁幾筆資料
        $itemsPerPage = 10;

        // 當前頁數（可從 $_GET['page'] 取得）
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // 保留其他 query 參數（例如搜尋條件）
        $queryParams = $_GET;
        unset($queryParams['page']);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, BASE_URL.'store/list_assign', $queryParams);

        $startRow = $paginator->offset();
        $maxRows = $paginator->limit();
        // Page Ended ************************************************

        $PayType = 0;
        $Status = 0;

        $rows = $managerRepo->GetAllManagerPage($Status, $PayType, $startRow, $maxRows); //* Page *//
        $row = $managerRepo->fetch_assoc($rows);
        if ($row == null) {
            $tpl->assign('items', []);
        } else {
            $i=0;
            $items = [];
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

                $temp['storename'] = $info['StoreName'] ?? '商家遺失';
                $temp['status'] = $managerRepo->ManagerStatus[$row['Status']];

                $items[] = $temp;
                $row = $managerRepo->fetch_assoc($rows);
            }

            $tpl->assign('items', $items);
        }

        $tpl->assign('totalrows', "共 ".$managerRepo->GetAllManagerCount()." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $paginator->render()); //* Page *// 

        $tpl->assign('title', '指定商家管理/截止/取消 - DinBenDon系統');
        $tpl->assign('breadcrumb', '指定店家管理、截止、取消');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->display(class_basename($this).'/ListAssignStore.htm'); 
    }

    // 狀態管理
    public function editStatus()
    {
        if($_POST) {
            return $this->editStatused();
        }

        $db = new Database();
        $userRepo = new UserRepository($db);
        $orderRepo = new OrderRepository($db);
        $managerRepo = new ManagerRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $id = trim($_REQUEST['id']);
        
        //產生本程式功能內容
        $tpl = new Template("app/Views");
      
        $info = $orderRepo->GetManagerDetailsByRecordID($id);
        
        // 限制只有負責人可修改狀態
        if (strcmp($Online['email'], $info['Manager'])<>0) {
            JavaScript::vAlertBack('ㄟ! 只有負責人可修改!別偷改喔!');
            return;
        }

        $row = [];
        
        $row['managerid'] = $info['RecordID'];
        $row['storeid'] = $info['StoreID'];
        $storeinfo = $managerRepo->GetStoreDetailsByRecordID($info['StoreID']);
        $row['storename'] = $storeinfo['StoreName'];
        $row['man'] = $info['Manager'];
        $row['note'] = $info['Note'];
        $row['createdate'] = date("Y-m-d H:i:s", $info['CreateDate']);
      
        // 選擇DropDownList設定狀態保留
        if (!empty($info['Status'])) {
            $tpl->assign('javaScript', "<script>seldroplist(this.frm.status,'".$info['Status']."');</script>");
        }

        $strStatus = "";
        foreach($managerRepo->ManagerStatus as $key => $value) {
            $strStatus .= "<option value='$key'>$value";
        }
        $row['strStatus'] = $strStatus;


        $tpl->assign('row', $row);

        $tpl->assign('title', '管理指定店家狀態 - DinBenDon系統');
        $tpl->assign('breadcrumb', '指定店家管理、截止、取消/管理指定店家狀態');
        $tpl->assign('baseUrl', BASE_URL);
        $tpl->assign('csrf', csrf_field());
        $tpl->display(class_basename($this).'/EditManager.htm');
    }

    // 送出狀態管理表單
    public function editStatused()
    {
        $db = new Database();
        $managerRepo = new ManagerRepository($db);

        $RecordID = trim($_POST["managerid"]);
        $Status = trim($_POST["status"]);
      
        //產生本程式功能內容
        if ($managerRepo->UpdateManagerStatusByRecordID($RecordID, $Status)) {
            JavaScript::vAlertRedirect('更新狀態成功!', BASE_URL.'store/list_assign');
        } else {
            JavaScript::vAlertBack('更新狀態失敗!');
        }
    }

}
