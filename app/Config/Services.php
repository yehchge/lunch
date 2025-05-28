<?php

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

}
