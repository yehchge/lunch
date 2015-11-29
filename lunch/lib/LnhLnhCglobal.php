<?php

class LnhLnhCglobal {
     
	public $ManagerStatus;

    public function LnhLnhCglobal() {
		// 設定指定店家管理狀態
        $this->ManagerStatus[0] = "請選擇";
        $this->ManagerStatus[1] = "訂購中";
        $this->ManagerStatus[2] = "截止訂購";
        $this->ManagerStatus[3] = "取消";
        $this->ManagerStatus[9] = "刪除";
    }
}

?>
