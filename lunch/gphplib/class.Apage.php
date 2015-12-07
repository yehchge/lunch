<?php

	// 後台管理程式主框頁
	include_once "/adm/lib/AdmAdmCfactory.php";
	include_once "/adm/lib/AdmAdmCCreater.php";
	include_once "/gphplib/class.FastTemplate.php";  
	
	class Apage {
		var $Online;
		var $Info;
		function __construct($RW='W') {
			// 後端管理系統權限管理 start
			$SysID= $_REQUEST['SysID'];
			$AdmAdm =  new AdmAdmCfactory();
			$this->Online = $AdmAdm->GetOnline();
			if(!$this->Online[0]) {
				header("Location:/adm/AdmAdmLogin.php");
				return;
			}	
			$this->Info = $AdmAdm->GetUserByUid($this->Online["EmployeeID"]);
			if(!$this->Info) {
				header("Location:/adm/AdmAdmLogin.php");
				return;
			}	
			$promi = $AdmAdm->CheckLimtByUidAndCataLog($this->Online["EmployeeID"],$RW);
			if(!$promi) {
				header("Location: /adm/AdmAdmError.php?String=你沒有權限!");
				return;
			}
			return $this->Online[0];
			// 後端管理系統權限管理 end
		}
  	
		public function GetUserInfo() {
			return $this->Online;
		}
		public function GetIDInfo() {
			return $this->Info;
		}
  	
		function display($title='',$str='') {
			//產生功能選項
			$AdmAdm =  new AdmAdmCfactory();
			$Cc = new AdmAdmCCreater();
			$Application = $Cc->getAllSystemHtml($this->Online["EmployeeID"]);
			$Cc = NULL;
			$info = $AdmAdm->GetUserByUid($this->Online["EmployeeID"]);
			//echo "<pre>";echo print_r($info);echo "</pre>";
			$Location = $title;
		
			global $_COOKIE;
			$clang = $_COOKIE["StyleLang"];
			if ($clang=="en") {
				$tpl = new FastTemplate("/adm/tpl/en");
			} else {
				$tpl = new FastTemplate("/adm/tpl");
			}
			$tpl->define(array(apg6 => "AdmAdmMain.tpl"));
			$tpl->assign("APPLICATION", $Application);
			$tpl->assign("LOCATION", $Location);
			$tpl->assign("username",$info["Name"]);
			$tpl->assign("FUNCTION", $str);
			$tpl->assign("url",ereg_replace('&','|',$_SERVER['REQUEST_URI']));
			$tpl->assign("SYSID", $SysID);
			if ($clang=="en") {
				$tpl->assign("lang","English");
			} else {
				$tpl->assign("lang","繁體中文");
			}

			$tpl->parse(MAIN,  "apg6");
			$tpl->FastPrint(MAIN);
		}
	}
?>