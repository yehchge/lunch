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
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 

        $Lnh = new LnhLnhCfactory(); 

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"PdsDetails.tpl"));
        $tpl->define_dynamic("row","TplBody");
        
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
        $page = isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = isset($_REQUEST['Status'])?$_REQUEST['Status']:0;
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $StoreID = isset($_REQUEST['id'])?$_REQUEST['id']:0;
        $SysID = 1;
      
        $tpl->assign('id',$StoreID);
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=product&action=list&id=$StoreID&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $Lnh->GetAllPdsCountByStore($StoreID);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************ 
        $rows = $Lnh->GetAllPdsPageByStore($StoreID,'','',$startRow,$maxRows); //* Page *//
        $row = $Lnh->fetch_assoc($rows);
        if ($row == NULL) {
            $tpl->clear_dynamic("row");
            /*
            $tpl->assign(editpdsid,"");
            $tpl->assign(pdsid,"");
            $tpl->assign(pdsname,"");
            $tpl->assign(pdstype,"");
            $tpl->assign(price,"");
            $tpl->assign(note,"");
            $tpl->assign(status,"");
            $tpl->parse(ROWS,"row");    
            */
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
                $tpl->assign('storeid',$StoreID);
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

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllPdsCountByStore($StoreID)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');



        // $MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        // $MainTpl->define(array('apg'=>"LunchMain.tpl")); 
        // $MainTpl->assign("FUNCTION",$str); 
        // $MainTpl->assign("LOCATION","店家維護/便當明細維護"); 
        // $MainTpl->parse('MAIN',"apg");
        // $MainTpl->FastPrint('MAIN');
    }

    // 新增表單送出
    private function create()
    {
        if (!$_POST) return '';

        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        $Lnh = new LnhLnhCfactory();

        // 檢查使用者有沒有登入
        $Online = $Lnh->GetOnline();
        
        $PdsName = trim($_POST["pdsname"]);
        $PdsType = trim($_POST["pdstype"]);
        $Price = trim($_POST["pdsprice"]);
        $Note = trim($_POST["pdsnote"]);
        $StoreID = trim($_POST["pdsid"]);
      
        //產生本程式功能內容
        if ($Lnh->CreateProduct($StoreID,$PdsName,$PdsType,$Price,$Online['Account'],$Note)) {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('新增便當成功!');\r\n";
            echo "location='./PdsDetails.php?id=$StoreID';\r\n";
            echo "location='./index.php?func=product&action=list&id=$StoreID';\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('新增便當失敗!');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        }
        //echo "<a href='/lunch/PdsDetails.php?id=$StoreID'>回上一頁</a>";
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
        $sid = trim($_GET['sid']); 
     
        //產生本程式功能內容
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('apg6'=>"EditPds.tpl")); 
      
        $info = $Lnh->GetPdsDetailsByRecordID($id);
        $tpl->assign('pdsid',$id);
        $tpl->assign('sid',$sid);
        $tpl->assign('pdsid',$info['RecordID']);
        $tpl->assign('pdsname', htmlspecialchars($info['PdsName']));
        $tpl->assign('pdstype',$info['PdsType']);
        $tpl->assign('price',$info['Price']);
        $tpl->assign('note',$info['Note']);
        if ($info['Status']==1) {
            $tpl->assign('status',"");
        } else {
            $tpl->assign('status',"checked");
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
        if ($Lnh->UpdateProduct($RecordID,$StoreID,$PdsName,$PdsType,$Price,$Online['Account'],$Note,$cancel)) {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('更新便當明細成功!');\r\n";
            // echo "location='./PdsDetails.php?id=$StoreID';\r\n";
            echo "location='./index.php?func=product&action=list&id=$StoreID';\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        } else {
            echo "<script>\r\n";
            echo "<!--\r\n";
            echo "alert('更新便當明細失敗!');\r\n";
            echo "history.back();\r\n";
            echo "//-->\r\n";
            echo "</script>\r\n";
        }
        //echo "<a href='/lunch/PdsDetails.php?id=$StoreID'>回便當明細維護</a>";
    }

    // 顯示店家商品明細
    private function listStore()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";

        $Lnh = new LnhLnhCfactory(); 
     
        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"UsrPdsDetails.tpl"));
        $tpl->define_dynamic("row","TplBody");
        
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
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
        $SysPag->msg_total = $Lnh->GetAllPdsCountByStore($StoreID,$Status);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************
        $row = NULL;
        $rows = $Lnh->GetAllPdsPageByStore($StoreID,$Status,'',$startRow,$maxRows); //* Page *//
        if ($rows) $row = $Lnh->fetch_assoc($rows);
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

                $tpl->assign('editpdsid',"<a href='./EditPds.php?id=$row[RecordID]&sid=$StoreID'>修改</a>");
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
        //$str = $tpl->fetch('BODY');
        $tpl->FastPrint('BODY');
        exit;

    }

}