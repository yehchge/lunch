<?php

/**
 * 註冊事件
 */

// 維護功能
require PATH_ROOT."/app/ThirdParty/MyMaintenance.php";

// 維護
$MyMaintenance = new MyMaintenance();
Events::on('pre_system', [$MyMaintenance, 'offline_check'], Events::PRIORITY_HIGH);
