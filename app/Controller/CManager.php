<?php

class CManager
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';

        switch($action){
            case 'list_order':
                return $this->listOrder();
                break;
            case 'list':
            default:
                return $this->index();
                break;
        }
    }

    // DinBenDon(今日)
    private function index()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 
      
        $Lnh = new LnhLnhCfactory();
        $LnhG = new LnhLnhCglobal();

        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"OrderStore.tpl"));
        $tpl->define_dynamic("row","TplBody");
      
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = 1; // 只顯示訂購中
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $SysID = 1;
     
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=manager&action=list&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $Lnh->GetAllManagerCount($Status);
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************ 
        $rows = $Lnh->GetAllManagerPage($Status,$PayType,$startRow,$maxRows); //* Page *//
        if ($rows) $row = $Lnh->fetch_assoc($rows);
        if ($row == NULL) {
            $tpl->clear_dynamic("row");
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
                $tpl->assign('managerid',$row['RecordID']);
                $tpl->assign('createdate',date("Y-m-d H:i:s",$row['CreateDate']));
                $tpl->assign('man',$row['Manager']);
                $tpl->assign('storeid',$row['StoreID']);
                $info = $Lnh->GetStoreDetailsByRecordID($row['StoreID']);
                //$tpl->assign('storename',"<a target='_blank' href='./UsrPdsDetails.php?id=$row[StoreID]'>".$info[StoreName]."</a>");
                $tpl->assign('storename',$info['StoreName']);
                //$tpl->assign('order',"<a href='./OrderLunch.php?id=$row[StoreID]&mid=$row[RecordID]'>".$LnhG->ManagerStatus[$row[Status]]."</a>");
                $tpl->assign('status',$LnhG->ManagerStatus[$row['Status']]);
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllManagerCount($Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');
    }

    // DinBenDon明細
    private function listOrder()
    {
        include_once PATH_ROOT."/lunch/lib/LnhLnhCfactory.php"; 
        include_once PATH_ROOT."/lunch/gphplib/class.FastTemplate.php";
        include_once PATH_ROOT."/lunch/lib/LnhLnhCglobal.php"; 
      
        $Lnh = new LnhLnhCfactory();
        $LnhG = new LnhLnhCglobal();
        
        // 內頁功能 (FORM)
        $tpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        $tpl->define(array('TplBody'=>"ListOrder.tpl"));
        $tpl->define_dynamic("row","TplBody");
      
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/lunch/gphplib/SysPagCfactory.php"; 
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = 1; // 只顯示訂購中
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $SysID = 1;
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url=$_SERVER['PHP_SELF']."?func=manager&action=list_order&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page=$page; 
        $SysPag->msg_total = $Lnh->GetActiveManagerPageCount();
        $SysPag->max_rows = $maxRows; 
        $SysPag->max_pages= 10;

        $pagestr = $SysPag->SysPagShowMiniLink( $page, "last");
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "last"); 
        $pagestr.= $SysPag->SysPagShowPageNumber($page,"number");  
        $pagestr.= $SysPag->SysPagShowPageLink( $page, "next");
        $pagestr.= $SysPag->SysPagShowMiniLink( $page, "next"); 
        // Page Ended ************************************************ 
        $rows = $Lnh->GetActiveManagerPage($Status,$PayType,$startRow,$maxRows); //* Page *//
        $row = $Lnh->fetch_assoc($rows);
        if ($row == NULL) {
            $tpl->assign('managerid',"");
            $tpl->assign('createdate',"");
            $tpl->assign('man',"");
            $tpl->assign('storename',"");
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
                $tpl->assign('managerid',$row['RecordID']);
                $tpl->assign('createdate',date("Y-m-d H:i:s",$row['CreateDate']));
                $tpl->assign('editdate',date("Y-m-d H:i:s",$row['EditDate']));
                $tpl->assign('man',$row['Manager']);
                $info = $Lnh->GetStoreDetailsByRecordID($row['StoreID']);
                $tpl->assign('storename',$info['StoreName']);
                $tpl->assign('status',$LnhG->ManagerStatus[$row['Status']]);
                $tpl->parse('ROWS',".row");         
                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('totalrows',"共 ".$Lnh->GetActiveManagerPageCount()." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->parse('BODY',"TplBody");
        return $str = $tpl->fetch('BODY');
    }

}