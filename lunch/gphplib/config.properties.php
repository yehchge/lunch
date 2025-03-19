<?php

declare(strict_types=1); // 嚴格類型

// 網站公用參數設定	
#
# database settings
#
$config["db_host"] = "localhost";
$config["db_username"] = "root";
$config["db_password"] = "123456";
$config["db_database"] = "plog";
#
# the database prefix will be appended to the name of each database tables in case you want
# to have more than one version of plog running at the same time, such as the stable and
# unstable one for testing. Each one could use a different prefix and therefore they could
# coexist in the same unique database. If you change this after the initial configuration done
# with the installation wizard, please make sure that you also rename the tables.
#
$config["db_prefix"] = "lt_";
$config["host_name"] = "localhost";
$config["www_url"] = "www.lunch.com.tw";
