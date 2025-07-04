<?php

/**
 * 工具類 function
 *
 * @created 2023/01/05
 */

/**
 * 顯示目前分配給 PHP 的記憶體
 *
 * @param   string $unit 顯示單位
 * @return  string       目前佔用的記憶體
 * @created 2022/12/23
 */
function memory(string $unit = 'MB')
{
    switch($unit){
    case 'BYTES':
        $memory_usage = function_exists('memory_get_usage') ? number_format(memory_get_usage(), 2) . ' Bytes' : 'N/A';
        break;
    case 'KB':
        $memory_usage = function_exists('memory_get_usage') ? number_format(memory_get_usage()/1024, 2) . ' KB' : 'N/A';
        break;
    case 'MB':
    default:
        $memory_usage = function_exists('memory_get_usage') ? number_format(memory_get_usage()/(1024*1024), 2) . ' MB': 'N/A';
        break;
    }
    return $memory_usage;
}

function println($string_message)
{
    isset($_SERVER['SERVER_PROTOCOL']) ? print "$string_message<br />" : print "$string_message\n";
}

function message($string_message)
{
    $now = date('Y-m-d H:i:s', strtotime('+8hour', strtotime(date('Y-m-d H:i:s'))));
    // $now = date('Y-m-d H:i:s');
    $memory = memory();
    if(isset($_SERVER['SERVER_PROTOCOL'])) {
        print "[$now][$memory]$string_message<br />";
    }else{
        print "[$now][$memory]$string_message\n";
    }
}

function message_cli($string_message)
{
    $now = date('Y-m-d H:i:s', strtotime('+8hour', strtotime(date('Y-m-d H:i:s'))));
    // $now = date('Y-m-d H:i:s');
    $memory = memory();
    println("[$now][$memory]$string_message");
}

function getMicrotime()
{
    list( $usec, $sec ) = explode(' ', microtime());
    return ( (float)$usec + (float)$sec );
}

/**
 * 計算兩個日期差幾小時
 *
 * @created 2025/02/24
 */
function dateHourDiff($startTime, $endTime)
{
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $timeDiff = $end - $start;
    return floor($timeDiff / (60 * 60));
}

function log2file($filename, $contents)
{
    file_put_contents($filename, $contents);
}

/**
 * 判斷是否在 command line 下執行?
 *
 * @return boolean 在 cli 下執行: true, 網頁執行: false
 */
function is_cli()
{
    return (php_sapi_name() === 'cli') ? true : false;
}
