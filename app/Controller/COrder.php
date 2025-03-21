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
            case 'list':
            default:
                return $this->index();
                break;
        }
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



        // $MainTpl = new FastTemplate(PATH_ROOT."/lunch/tpl");
        // $MainTpl->define(array('apg'=>"LunchMain.tpl")); 
        // $MainTpl->assign("FUNCTION",$str);
        // $MainTpl->assign("LOCATION","DinBenDon/訂購GO");
        // $MainTpl->parse('MAIN',"apg");
        // $MainTpl->FastPrint('MAIN');
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

}