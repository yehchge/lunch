<?php

class COrder
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';

        switch($action){
            case 'add':
                return $this->add();
                break;
            case 'edit':
                return $this->edit();
                break;
            case 'list':
            default:
                return $this->index();
                break;
        }
    }


    // 訂購明細
    private function index()
    {
        $Lnh = new LnhLnhCfactory();
        $LnhG = new LnhLnhCglobal();
        
        // 內頁功能 (FORM)
        $tpl = new Template("tpl");

        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/gphplib/SysPagCfactory.php"; 
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = isset($_REQUEST['status'])?$_REQUEST['status']:0; // 只顯示訂購中
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $SysID = 1;
        $ManagerID = isset($_REQUEST['mid'])?$_REQUEST['mid']:0;
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=order&action=list&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID&mid=$ManagerID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $Lnh->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************ 
        $rows = $Lnh->GetOrderDetailsPageByManagerID($ManagerID,$Status,$PayType,$startRow,$maxRows); //* Page *//
        
        $Minfo = $Lnh->GetManagerDetailsByRecordID($ManagerID);

        $items = [];
        $i = 0;

        while($row = $Lnh->fetch_assoc($rows)) {
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
                $strStatus = "<a href='./index.php?func=order&action=edit&id=".$row['RecordID']."&mid=$ManagerID'><img src='tpl/images/edit_s.gif' border='0'></a>";
            } else {
                $strStatus = "<img src='tpl/images/lock.gif' border='0'>";
            }

            $temp['classname'] = $class;
            $temp['orderid'] = $row['RecordID'];
            $temp['managerid'] = $ManagerID;
            $temp['pdsname'] = $row['PdsName'];
            $temp['count'] = $row['Count'];
            $temp['price'] = $row['Price'];
            $temp['man'] = $row['OrderMan'];
            $temp['note'] = $row['Note'];
            $temp['createdate'] = date("Y-m-d H:i:s",$row['CreateDate']);
            $temp['status'] = $str;
            $temp['editstatus'] = $strStatus;

            $items[] = $temp;
        }

        $tpl->assign('items', $items);

        $tpl->assign('totalrows',"共 ".$Lnh->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);
        $tpl->assign('title', '訂購人明細 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon明細/訂購人明細');
        return $tpl->display('OrderDetails.htm');
    }

    private function add()
    {
        if($_POST){
            return $this->create();
        }

        $Lnh = new LnhLnhCfactory(); 

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
        $ManagerID = isset($_REQUEST['mid'])?$_REQUEST['mid']:0;
        $SysID = 1;

        $tpl->assign('id',$StoreID);
        $tpl->assign('mid',$ManagerID);

        if(!$page) $page=1;
        $maxRows = 10;
        $startRow = ($page-1)*$maxRows;
        $SysPag = new SysPagCfactory();
        $SysPag->url = $_SERVER['PHP_SELF']."?func=order&action=add&Status=$Status&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page = $page;
        $SysPag->msg_total = $Lnh->GetAllPdsCountByStore($StoreID,$Status);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************

        $rows = $Lnh->GetAllPdsPageByStore($StoreID,$Status,'',$startRow,$maxRows); //* Page *//

        $i=0;
        $items = [];

        while($row = $Lnh->fetch_assoc($rows)){
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
            $temp['editpdsid'] = "<a href='./EditPds.php?id=".$row['RecordID']."&sid=$StoreID'>修改</a>";
            $temp['pdsid'] = $row['RecordID'];
            $temp['status'] =  $status;
            $temp['pdsname'] = $row['PdsName'];
            $temp['pdstype'] = $row['PdsType'];
            $temp['price'] = $row['Price'];
            $temp['note'] = $row['Note'];

            $items[] = $temp;
        }

        $tpl->assign('items', $items);

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllPdsCountByStore($StoreID,$Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);

        $tpl->assign('title', 'DinBenDon - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon/訂購GO');
        return $tpl->display('OrderLunch.htm');
    }

    // 新增表單送出
    private function create()
    {
        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        // $Online = $Lnh->GetOnline();

        $db = new Database();
        $userRepo = new UserRepository($db);
        $orderRepo = new OrderRepository($db);


        $Online = $userRepo->findById($_SESSION['user_id']);

        // 內頁功能 (FORM)
        $tpl = new Template("tpl");

        $UserInfo['name'] = 'John';
        $chkid = isset($_POST["chk"])?$_POST["chk"]:0;
        $ManagerID = $_POST["mid"];

        //CheckBox 抓值
        $str = "您所訂購的便當明細如下：<br>";
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

            $info = $Lnh->GetPdsDetailsByRecordID($PdsID);

            $PdsName = $info['PdsName'];
            $Price = $info['Price'];

            // 寫入訂單中
            $ret = $Lnh->CreateOrder($ManagerID,$UserInfo['name'],$PdsID,$PdsName,$Price,$Count,$Note,$Online['email']);

            if ($ret) {
                $strret = "訂購成功!";
            } else {
                $strret = "失敗!";
            }
            $str .= "便當:$PdsName, 單價:$Price, 數量:$Count,備註:$Note, $strret<br>";


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
        $tpl->assign('breadcrumb', 'DinBenDon/訂購GO/訂購便當結果');
        return $tpl->display('OrderLunched.htm');
    }

    // 訂單編輯
    private function edit()
    {
        if ($_POST){
            return $this->update();
        }
      
        $Lnh = new LnhLnhCfactory(); 
        $LnhG = new LnhLnhCglobal();

        $id = trim($_REQUEST['id']);
        $ManagerID = trim($_REQUEST['mid']);
     
        // 檢查使用者有沒有登入
        // $Online = $Lnh->GetOnline();

        $db = new Database();
        $userRepo = new UserRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);

        $info = $Lnh->GetOrderDetailsByRecordID($id);
      
        // 限制只有訂購人可修改狀態
        if (strcmp($Online['email'], $info['CreateMan'])<>0) {
            echo "????";exit;
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('ㄟ! 只有訂購人可修改!別偷改喔!');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
            return;
        }   
        
        //產生本程式功能內容; 內頁功能 (FORM)
        $tpl = new Template("tpl");


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
        return $tpl->display('EditOrder.htm');      
    }

    // 訂單編輯送出
    private function update()
    {
        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        // $Online = $Lnh->GetOnline();

        $db = new Database();
        $userRepo = new UserRepository($db);

        $Online = $userRepo->findById($_SESSION['user_id']);


        $RecordID = trim($_POST["orderid"]);
        $Status = trim($_POST["status"]);
        $ManagerID = trim($_POST["managerid"]);
      
        //產生本程式功能內容
        if ($Lnh->UpdateOrderStatusByRecordID($RecordID,$Status,$Online['email'])) {
            // JavaScript::vAlertRedirect('更新狀態成功!', );
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('更新狀態成功!');\r\n";
            echo "location='./index.php?func=order&action=list&mid=$ManagerID';\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('更新狀態失敗!');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        }   
    }

}