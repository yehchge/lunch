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

}
