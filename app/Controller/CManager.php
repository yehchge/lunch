<?php

class CManager
{
    public function tManager()
    {
        $action = $_GET['action'] ?? '';
        try{
            switch($action){
                case 'list_order':
                    return $this->listOrder();
                    break;
                case 'list':
                default:
                    return $this->index();
                    break;
            }
        }catch (\Exception $e){
            echo $e->getMessage().PHP_EOL;
            exit;
        }
    }

    // DinBenDon(今日)
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

        $items = [];

        if ($row != NULL) {
            $i=0;
            while ($row != NULL) {
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
                $temp['createdate'] = date("Y-m-d H:i:s" ,$row['CreateDate']);
                $temp['man'] = $row['Manager'];
                $temp['storeid'] = $row['StoreID'];
                $info = $Lnh->GetStoreDetailsByRecordID($row['StoreID']);
                $temp['storename'] = $info['StoreName'];
                $temp['status'] = $LnhG->ManagerStatus[$row['Status']];

                $items[] = $temp;

                $row = $Lnh->fetch_assoc($rows);
            }
        }

        $tpl->assign('items', $items);

        $tpl->assign('totalrows',"共 ".$Lnh->GetAllManagerCount($Status)." 筆 "); //* Page *// 
        $tpl->assign('pageselect',$pagestr); //* Page *// 

        $tpl->assign('title', 'DinBenDon(指定店家) - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon');
        return $tpl->display('OrderStore.htm');
    }

    // DinBenDon明細
    private function listOrder()
    {
        $Lnh = new LnhLnhCfactory();
        $LnhG = new LnhLnhCglobal();
        
        // 內頁功能 (FORM)
        $tpl = new Template("tpl");
        
        //產生本程式功能內容
        // Page Start ************************************************ 
        include_once PATH_ROOT."/gphplib/SysPagCfactory.php"; 
        $page= isset($_REQUEST['page'])?$_REQUEST['page']:0; 
        $Status = 1; // 只顯示訂購中
        $Name = isset($_REQUEST['Name'])?$_REQUEST['Name']:'';
        $PayType = isset($_REQUEST['PayType'])?$_REQUEST['PayType']:0;
        $SysID = 1;
      
        if(!$page) $page=1; 
        $maxRows = 10; 
        $startRow = ($page-1)*$maxRows; 
        $SysPag = new SysPagCfactory(); 
        $SysPag->url = $_SERVER['PHP_SELF']."?func=manager&action=list_order&Status=$Status&Name=$Name&PayType=$PayType&SysID=$SysID"; 
        $SysPag->page = $page; 
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
        
        $items = [];
        $i = 0;

        while($row = $Lnh->fetch_assoc($rows)){
            $temp = [];

            $info = $Lnh->GetStoreDetailsByRecordID($row['StoreID']);

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
            $temp['status'] = $LnhG->ManagerStatus[$row['Status']];

            $items[] = $temp;
        }

        $tpl->assign('items', $items);

        $tpl->assign('PHP_SELF', $_SERVER['PHP_SELF']);

        $tpl->assign('totalrows',"共 ".$Lnh->GetActiveManagerPageCount()." 筆"); //* Page *// 
        $tpl->assign('pageselect', $pagestr); //* Page *// 

        $tpl->assign('title', '訂便當明細 - DinBenDon系統');
        $tpl->assign('breadcrumb', 'DinBenDon明細');
        return $tpl->display('ListOrder.htm');
    }

}