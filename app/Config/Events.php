<?php

/**
 * 註冊事件
 */

// 維護功能
// require PATH_ROOT."/app/ThirdParty/MyMaintenance.php";

// namespace App\Config;

use App\System\Events;
use App\ThirdParty\MyMaintenance;

// 維護
$MyMaintenance = new MyMaintenance();
Events::on('pre_system', [$MyMaintenance, 'offline_check'], Events::PRIORITY_HIGH);
