<?php
    $dbms='mysql'; //資料庫類型
    $host='172.16.1.230';      //資料庫主機名稱
    $dbName='test_bill';    //資料庫名稱
    $user='robot';      //連線帳號
    $pass='robot';      //連線密碼
    $dsn="$dbms:host=$host;dbname=$dbName";
    try
    {
        $dbh = new PDO($dsn, $user, $pass);
        echo "資料庫連線成功<br/>";
        $dbh = null;
    }
    catch (PDOException $e) 
    {
        die("Error!: " . $e->getMessage() . "<br/>");
    }
    $db = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
