<?php

namespace App\Config;

use App\System\CRequest;
use App\System\CResponse;
use App\ThirdParty\CI4Smarty;

class Services
{
    protected static array $instances = [];

    public static function smarty()
    {
        if (!isset(self::$instances['smarty'])) {
            require_once PATH_ROOT.'/app/ThirdParty/CI4Smarty.php';

            $smarty = new CI4Smarty();
            self::$instances['smarty'] = $smarty;
        }

        return self::$instances['smarty'];
    }

    public static function response()
    {
        if (!isset(self::$instances['response'])) {
            require_once PATH_ROOT.'/app/System/CResponse.php';

            $response = new CResponse();
            self::$instances['response'] = $response;
        }

        return self::$instances['response'];
    }

    public static function request()
    {
        if (!isset(self::$instances['request'])) {
            require_once PATH_ROOT.'/app/System/CRequest.php';

            $request = new CRequest();
            self::$instances['request'] = $request;
        }

        return self::$instances['request'];
    }

}
