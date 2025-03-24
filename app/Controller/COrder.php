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
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 
      
        $Lnh = new LnhLnhCfactory();
        $LnhG = new LnhLnhCglobal();
        
        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"OrderDetails.tpl"));
        $tpl->define_dynamic("row","TplBody");
      
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
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
        $row = $Lnh->fetch_assoc($rows);
        if ($row == NULL) {
            $tpl->assign('orderid',"");
            $tpl->assign('managerid',$ManagerID);
            $tpl->assign('pdsname',"");
            $tpl->assign('count',"");
            $tpl->assign('price',"");
            $tpl->assign('man',"");
            $tpl->assign('note',"");
            $tpl->assign('createdate',"");
            $tpl->assign('status',"");
            $tpl->assign('editstatus',"");
            $tpl->parse('ROWS',"row");        
        } else {
            $Minfo = $Lnh->GetManagerDetailsByRecordID($ManagerID);
            $i=0;
            while ($row != NULL) {
                if ($i==0) {
                    $class = "Forums_Item";
                    $i=1;
                } else {
                    $class = "Forums_AlternatingItem";
                    $i=0;
                }
                $tpl->assign('classname',$class);
                $tpl->assign('orderid',$row['RecordID']);
                $tpl->assign('managerid',$ManagerID);
                $tpl->assign('pdsname',$row['PdsName']);
                $tpl->assign('count',$row['Count']);
                $tpl->assign('price',$row['Price']);
                $tpl->assign('man',$row['OrderMan']);
                $tpl->assign('note',$row['Note']);
                $tpl->assign('createdate',date("Y-m-d H:i:s",$row['CreateDate']));
                $info = $Lnh->GetStoreDetailsByRecordID($row['RecordID']);

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
                $tpl->assign('status',$str);
                $tpl->assign('editstatus',$strStatus);
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('totalrows',"共 ".$Lnh->GetOrderDetailsPageCountByManagerID($ManagerID,$Status,$PayType)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');
    }

    private function add()
    {
        if($_POST){
            return $this->create();
        }

        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory(); 

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"OrderLunch.tpl"));
        $tpl->define_dynamic("row","TplBody");

        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
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
        $SysPag->url=$_SERVER['PHP_SELF']."?func=order&action=add&Status=$Status&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
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
            $row = $Lnh->fetch_assoc($rows);
            if ($row == NULL) {
                $tpl->assign('editpdsid',"");
            $tpl->assign('pdsid',"");
                $tpl->assign('pdsname',"");
            $tpl->assign('pdstype',"");
            $tpl->assign('price',"");
            $tpl->assign('note',"");
            $tpl->assign('status',"");
            $tpl->parse('ROWS',"row");        
            } else {
            $i=0;
                while ($row != NULL) {
                if ($i==0) {
                    $class = "Forums_Item";
                    $i=1;
                } else {
                    $class = "Forums_AlternatingItem";
                    $i=0;
                }
                $tpl->assign('classname',$class);
                    $tpl->assign('editpdsid',"<a href='./EditPds.php?id=".$row['RecordID']."&sid=$StoreID'>修改</a>");
                    $tpl->assign('pdsid',$row['RecordID']);
                    if ($row['Status']==1) {
                        $tpl->assign('status',"正常");
                    } else {
                        $tpl->assign('status',"停用");
                    }
                    
                $tpl->assign('pdsname',$row['PdsName']);
                $tpl->assign('pdstype',$row['PdsType']);
                $tpl->assign('price',$row['Price']);
                $tpl->assign('note',$row['Note']);
                
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
                }
            }

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllPdsCountByStore($StoreID,$Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');
    }

    // 新增表單送出
    private function create()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"OrderLunched.tpl"));
        $tpl->define_dynamic("row","TplBody");

        $UserInfo['name'] = 'John';
        $chkid = isset($_POST["chk"])?$_POST["chk"]:0;
        $ManagerID = $_POST["mid"];

        //CheckBox 抓值
        $i=0;
        $str = "您所訂購的便當明細如下：<br>";
        $str .= "========================<br>";
        if (!$chkid) {
            $str .= "您未勾選!!<br>";
            $tpl->clear_dynamic("row");
            $tpl->parse('ROWS',".row");     
        } else {
            foreach ($chkid as $key => $value) {
                if ($i==0) {
                    $class = "Forums_Item";
                    $i=1;
                } else {
                    $class = "Forums_AlternatingItem";
                    $i=0;
                }
                $tpl->assign('classname',$class);
                $PdsID = $value;
                $Count = trim($_POST["cnt".$value]);
                $Note = trim($_POST["note".$value]);
                $info = $Lnh->GetPdsDetailsByRecordID($PdsID);
                $PdsName = $info['PdsName'];
                $Price = $info['Price'];
                // 寫入訂單中
                $ret = $Lnh->CreateOrder($ManagerID,$UserInfo['name'],$PdsID,$PdsName,$Price,$Count,$Note,$Online['Account']);
                if ($ret) {
                    $strret = "訂購成功!";
                } else {
                    $strret = "失敗!";
                }
                $str .= "便當:$PdsName, 單價:$Price, 數量:$Count,備註:$Note, $strret<br>";
                $tpl->assign('pdsname',$PdsName);
                $tpl->assign('price',$Price);
                $tpl->assign('count',$Count);
                $tpl->assign('note',$Note);
                
                $tpl->parse('ROWS',".row");         
            }
        }

        echo "str =  $str<br>";
        if ($i==0) {
            $class = "Forums_Item";
            $i=1;
        } else {
            $class = "Forums_AlternatingItem";
            $i=0;
        }
        $tpl->assign('classname1',$class);

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');

        // $MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        // $MainTpl->define(array('apg'=>"LunchMain.tpl")); 
        // $MainTpl->assign("FUNCTION",$str); 
        // $MainTpl->assign("LOCATION","DinBenDon/訂購GO/訂購便當結果"); 
        // $MainTpl->parse('MAIN',"apg");
        // $MainTpl->FastPrint('MAIN');
    }

    // 訂單編輯
    private function edit()
    {
        if ($_POST){
            return $this->update();
        }

        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 
      
        $Lnh = new LnhLnhCfactory(); 
        $LnhG = new LnhLnhCglobal();

        $id = trim($_REQUEST['id']);
        $ManagerID = trim($_REQUEST['mid']);
     
        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();

        $info = $Lnh->GetOrderDetailsByRecordID($id);
        
        // 限制只有訂購人可修改狀態
        if (strcmp($Online['Account'],$info['CreateMan'])<>0) {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('ㄟ! 只有訂購人可修改!別偷改喔!');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
            //echo "<br><a href='./ListAssignStore.php'>回上一步</a>";
            return;
        }   
        
        //產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"EditOrder.tpl")); 
      
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
      
        
        $tpl->parse('BODY',"apg6");
        return $str = $tpl->fetch('BODY');

        // $MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        // $MainTpl->define(array('apg'=>"LunchMain.tpl")); 
        // $MainTpl->assign("FUNCTION",$str); 
        // $MainTpl->assign("LOCATION","DinBenDon明細/訂購人明細/管理訂購人明細狀態"); 
        // $MainTpl->parse('MAIN',"apg");
        // $MainTpl->FastPrint('MAIN');
    }

    // 訂單編輯送出
    private function update()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();

        $RecordID = trim($_POST["orderid"]);
        $Status = trim($_POST["status"]);
        $ManagerID = trim($_POST["managerid"]);
      
        //產生本程式功能內容
        if ($Lnh->UpdateOrderStatusByRecordID($RecordID,$Status,$Online['Account'])) {
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
        //echo "<a href='./OrderDetails.php?mid=$ManagerID'>回指定店家管理列表</a>";
    }

}