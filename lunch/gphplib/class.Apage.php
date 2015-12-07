<?php

	// ��x�޲z�{���D�ح�
	include_once "/adm/lib/AdmAdmCfactory.php";
	include_once "/adm/lib/AdmAdmCCreater.php";
	include_once "/gphplib/class.FastTemplate.php";  
	
	class Apage {
		var $Online;
		var $Info;
		function __construct($RW='W') {
			// ��ݺ޲z�t���v���޲z start
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
				header("Location: /adm/AdmAdmError.php?String=�A�S���v��!");
				return;
			}
			return $this->Online[0];
			// ��ݺ޲z�t���v���޲z end
		}
  	
		public function GetUserInfo() {
			return $this->Online;
		}
		public function GetIDInfo() {
			return $this->Info;
		}
  	
		function display($title='',$str='') {
			//���ͥ\��ﶵ
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
				$tpl->assign("lang","�c�餤��");
			}

			$tpl->parse(MAIN,  "apg6");
			$tpl->FastPrint(MAIN);
		}
	}
?>