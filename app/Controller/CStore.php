<?php

class CStore
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';

        switch($action){
            case 'add':
                return $this->new();
                break;
            case 'edit':
                return $this->edit();
                break;
            case 'show':
                return $this->show();
                break;
            case 'assign':
                return $this->assign();
                break;
            case 'assigned':
                return $this->assigned();
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
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory(); 

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"ListStore.tpl"));
        $tpl->define_dynamic("row","TplBody");

        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = isset($_REQUEST['Status'])?$_REQUEST['Status']:0;
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $SysID = 1;

        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=store&action=list&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $Lnh->GetAllStoreCount();
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 

        // Page Ended ************************************************ 
        $rows = $Lnh->GetAllStorePage($Status,$Name,$PayType,$startRow,$maxRows); //* Page *//

        $row = $Lnh->fetch_assoc($rows);

        if ($row == NULL) {
            $tpl->assign('editstoreid',"");
            $tpl->assign('editdetails',"");
            $tpl->assign('storename',"");
            $tpl->assign('tel',"");
            $tpl->assign('man',"");
            $tpl->assign('editdate',"");
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
                //$tpl->assign('editstoreid',"<a href='./EditStore.php?id=$row[RecordID]'>修改</a>");
                $tpl->assign('storeid',$row['RecordID']);
                if ($row['Status']==1) {
                    $tpl->assign('status',"正常");
                    // $tpl->assign('editdetails',"<a href='./PdsDetails.php?id=".$row['RecordID']."'>新增維護</a>");
                    $tpl->assign('editdetails',"<a href='./index.php?func=product&action=list&id=".$row['RecordID']."'>新增維護</a>");
                } else {
                    $tpl->assign('status',"停用");
                    $tpl->assign('editdetails',"新增維護");
                }
                
                //$tpl->assign(storename,"<a target='_blank' href='./StoreDetail.php?id=$row[RecordID]'>$row[StoreName]</a>");
                //$tpl->assign(storename,"<a target='_blank' href='javascript:window.open(\"./StoreDetail.php?id=$row[RecordID]\",\"sdetail\",\"height=400,width=400,left=0,scrollbars=no,location=0,status=0,menubat=0,top=430\");'>$row[StoreName]</a>");
                $tpl->assign('storename',"<a href='javascript:ShowDetail($row[RecordID]);'>$row[StoreName]</a>");
                //window.open("News2.htm","NEW2","height=260,width=400,left=0,scrollbars=no,location=0,status=0,menubar=0,top=430");
                $tpl->assign('tel',$row['Tel']);
                $tpl->assign('man',$row['MainMan']);
                $tpl->assign('editdate',date("Y-m-d",$row['EditDate']));
                
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllStoreCount()." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 
        
        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');
    }

    // 顯示新增表單
    private function new()
    {
        if ($_POST) {
            return $this->create();
        }

        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

        $Lnh = new LnhLnhCfactory();

        //產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"AddStore.tpl")); 
        $tpl->parse('BODY',"apg6");
        return $str = $tpl->fetch('BODY');
    }

    // 新增表單送出
    private function create()
    {
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php";

        $Lnh = new LnhLnhCfactory();

        $StoreName = trim($_POST["name"]);
        $StoreIntro = trim($_POST["intro"]);
        $StoreClass = trim($_POST["sclass"]);
        $MainMan = trim($_POST["man"]);
        $Address = trim($_POST["addr"]);
        $Tel = trim($_POST["tel"]);
        $Note = trim($_POST["note"]);

        $Online = $Lnh->GetOnline();

        //產生本程式功能內容
        if ($Lnh->CreateStore('','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online['Account'],$Note)) {
            echo "<script>\r\n";
            echo "alert('新增成功!');\r\n";
            echo "history.back();\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "alert('新增失敗!');\r\n";
            echo "history.back();\r\n";
            echo "</script>\r\n";
        }
    }

    // 顯示編輯表單
    private function edit()
    {
        if ($_POST){
            return $this->update();
        }

        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

        $Lnh = new LnhLnhCfactory(); 

        $id = trim($_GET['id']);
     
        //產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"EditStore.tpl")); 
        
        $info = $Lnh->GetStoreDetailsByRecordID($id);
      
        $tpl->assign('storeid',$info['RecordID']);
        $tpl->assign('sname',$info['StoreName']);
        $tpl->assign('intro',$info['StoreIntro']);

        $tpl->assign('man',$info['MainMan']);
        $tpl->assign('tel',$info['Tel']);
        $tpl->assign('addr',$info['Address']);
        $tpl->assign('createdate',date("Y-m-d",$info['CreateDate']));
        $tpl->assign('editdate',date("Y-m-d",$info['EditDate']));
        $tpl->assign('note',$info['Note']);
        if ($info['Status']==1) {
            $tpl->assign('status',"");
        } else {
            $tpl->assign('status',"checked");
        }
      
        // 選擇DropDownList設定狀態保留
        if (!empty($info['StoreClass'])) {
            $tpl->assign('javaScript', "<script>seldroplisttext(this.frm.sclass,'".$info['StoreClass']."');</script>");
        }

        $tpl->parse('BODY',"apg6");
        return $str = $tpl->fetch('BODY');
    }

    // 編輯表單送出
    private function update()
    {
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();

        $RecordID = trim($_POST["storeid"]);
        $StoreName = trim($_POST["sname"]);
        $StoreIntro = trim($_POST["intro"]);
        $StoreClass = trim($_POST["sclass"]);
        $MainMan = trim($_POST["man"]);
        $Address = trim($_POST["addr"]);
        $Tel = trim($_POST["tel"]);
        $Note = trim($_POST["note"]);
        $status = isset($_POST["status"])?trim($_POST["status"]):1;
      
        if ($status=="on") {$cancel=2;} else {$cancel=1;}
        
        // 產生本程式功能內容
        if ($Lnh->UpdateStore($RecordID,'','',$StoreName,$StoreIntro,$StoreClass,$MainMan,$Tel,$Address,$Online['Account'],$Note,$cancel)) {
            echo "<script>\r\n";
            echo "alert('更新成功! ');\r\n";
            echo "location='./index.php?func=store&action=list';\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('更新失敗! ');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        }
    }

    // 顯示單筆詳細資料
    private function show()
    {
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
     
        $Lnh = new LnhLnhCfactory(); 

        $id = trim($_GET['id']);

        $info = $Lnh->GetStoreDetailsByRecordID($id);

        //產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"StoreDetail.tpl")); 
      
        $tpl->assign('storeid',$info['RecordID']);
        $tpl->assign('store',$info['StoreName']);
        $tpl->assign('intro',$info['StoreIntro']);
        $tpl->assign('sclass',$info['StoreClass']);
        $tpl->assign('man',$info['MainMan']);
        $tpl->assign('tel',$info['Tel']);
        $tpl->assign('addr',$info['Address']);
        $tpl->assign('createdate',date("Y-m-d",$info['CreateDate']));
        $tpl->assign('editdate',date("Y-m-d",$info['EditDate']));
        $tpl->assign('note',$info['Note']);
        if ($info['Status']==1) {
            $tpl->assign('status',"正常"); 
        } else {
            $tpl->assign('status',"停用");
        }
     
        $tpl->parse('MAIN',"apg6");
        $tpl->FastPrint('MAIN');
        exit();
    }

    // 指定店家
    private function assign()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory();

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"AssignStore.tpl"));
        $tpl->define_dynamic("row","TplBody");

        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = 1; // 正常狀態才顯示
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:0;



        if ($id) {
            echo "<Script>\r\n";
            echo "yy=confirm('今日確定要訂購此間店的便當嗎?');\r\n";
            echo "if (yy==0) {history.back();}\r\n";
            echo " else {location='./index.php?func=store&action=assigned&id=$id&Url=".$_SERVER["REQUEST_URI"]."';}\r\n";
            // echo " else {location='./AssignStoreed.php?id=$id&Url=".$_SERVER["REQUEST_URI"]."';}\r\n";
            echo "</Script>\r\n";
            return;
        }


        $SysID = 1;
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=store&action=assign&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        


        $SysPag->msg_total = $Lnh->GetAllStoreCount($Status);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;


        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************ 


        $rows = $Lnh->GetAllStorePage($Status,$Name,$PayType,$startRow,$maxRows); //* Page *//
        $row = $Lnh->fetch_assoc($rows);
        if ($row == NULL) {
            $tpl->assign('editstoreid',"");
            $tpl->assign('storename',"");
            $tpl->assign('tel',"");
            $tpl->assign('man',"");
            $tpl->assign('editdate',"");
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
                $tpl->assign('editstoreid',"<a href='./index.php?func=store&action=assign&Status=$Status&page=$page&Name=$Name&PayType=$PayType&SysID=$SysID&id=".$row['RecordID']."'>指定</a>");
                $tpl->assign('storeid',$row['RecordID']);
                if ($row['Status']==1) {
                    $tpl->assign('status',"正常");
                } else {
                    $tpl->assign('status',"停用");
                }
                
                //$tpl->assign('storename',"<a target='_blank' href='/lunch/StoreDetail.php?id=$row[RecordID]'>$row[StoreName]</a>");
                $tpl->assign('storename',"<a href='javascript:ShowDetail($row[RecordID]);'>$row[StoreName]</a>");
                $tpl->assign('tel',$row['Tel']);
                $tpl->assign('man',$row['MainMan']);
                $tpl->assign('editdate',date("Y-m-d",$row['EditDate']));
                
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllStoreCount($Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');




        // $MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        // $MainTpl->define(array('apg'=>"LunchMain.tpl")); 
        // $MainTpl->assign("FUNCTION",$str);
        // $MainTpl->assign("LOCATION","指定店家");
        // $MainTpl->parse('MAIN',"apg");
        // $MainTpl->FastPrint('MAIN');
    }

    private function assigned()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        
        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();

        $StoreID = trim($_GET["id"]);
        $Url = trim($_GET["Url"]);

        if ($Lnh->CreateManager($StoreID,$Online['Account'],'說明:系統指定')) {
            echo "<script>\r\n";
            echo "alert('指定便當商家成功!');\r\n";
            echo "location='$Url';\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "alert('指定便當商家失敗!');\r\n";
            echo "history.back();\r\n";
            echo "</script>\r\n";
        }
        //echo "<a href='$Url'>回便當明細維護</a>";


    }


}