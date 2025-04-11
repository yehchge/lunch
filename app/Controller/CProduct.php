<?php

class CProduct
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';

        switch($action){
            case 'add':
                return $this->create();
                break;
            case 'edit':
                return $this->edit();
                break;
            case 'list_store':
                return $this->listStore();
                break;
            case 'list':
            default:
                return $this->index();
                break;
        }
    }

    // 顯示資料列表
    private function index()
    {
        $db = new Database();
        $productRepo = new ProductRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("tpl");

        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/gphplib/SysPagCfactory.php"; 
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = isset($_REQUEST['Status'])?$_REQUEST['Status']:0;
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $SysID = 1;
      
        $tpl->assign('id', $StoreID);
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=product&action=list&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $productRepo->GetAllPdsCountByStore($StoreID);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
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
            $temp['note'] = $row['Note'];

            $items[] = $temp;
        }
             
        $tpl->assign('items', $items);
        $tpl->assign('totalrows',"共 ".$productRepo->GetAllPdsCountByStore($StoreID)." 筆 "); //* Page *// 
        $tpl->assign('pageselect', $pagestr); //* Page *// 

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);
        $tpl->assign('title', '商品明細維護 - DinBenDon系統');
        $tpl->assign('breadcrumb', '商品明細維護');
        return $tpl->display('PdsDetails.htm');
    }

    // 新增表單送出
    private function create()
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
            JavaScript::vAlertRedirect('新增便當成功!', $_SERVER['PHP_SELF']."?func=product&action=list&id=$StoreID");
        } else {
            JavaScript::vAlertBack('新增便當失敗!');
        }
    }

    // 顯示編輯表單
    private function edit()
    {
        if ($_POST){
            return $this->update();
        }

        $db = new Database();
        $productRepo = new ProductRepository($db);

        $id = trim($_GET['id']);
        $sid = trim($_GET['sid']);

        // 產生本程式功能內容; 內頁功能 (FORM)
        $tpl = new Template("tpl");

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
        $tpl->assign('breadcrumb', '店家維護/便當明細維護/更新便當明細');
        return $tpl->display('EditPds.htm');
    }

    // 編輯表單送出
    private function update()
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
            JavaScript::vAlertRedirect('更新便當明細成功!', $_SERVER['PHP_SELF']."?func=product&action=list&id=$StoreID");
        } else {
            JavaScript::vAlertBack('更新便當明細失敗!');
        }
    }

    // 顯示店家商品明細
    private function listStore()
    {
        $db = new Database();
        $productRepo = new ProductRepository($db);

        // 內頁功能 (FORM)
        $tpl = new Template("tpl");

        // 產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/gphplib/SysPagCfactory.php"; 
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = 1; // 顯示正常狀態的資料
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $SysID = 1;
      
        $tpl->assign('id',$StoreID);
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url = $_SERVER['PHP_SELF']."?1=1&Status=$Status&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $productRepo->GetAllPdsCountByStore($StoreID,$Status);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
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
            $temp['note'] = $row['Note'];
                
            $items[] = $temp;
        }

        $tpl->assign('items', $items);
        $tpl->assign('totalrows',"共 ".$productRepo->GetAllPdsCountByStore($StoreID,$Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        return $tpl->display('UsrPdsDetails.htm');
    }

}