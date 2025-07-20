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
            include_once PATH_ROOT.'/app/ThirdParty/CI4Smarty.php';

            $smarty = new CI4Smarty();
            self::$instances['smarty'] = $smarty;
        }

        return self::$instances['smarty'];
    }

    public static function response()
    {
        if (!isset(self::$instances['response'])) {
            include_once PATH_ROOT.'/app/System/CResponse.php';

            $response = new CResponse();
            self::$instances['response'] = $response;
        }

        return self::$instances['response'];
    }

    public static function request()
    {
        if (!isset(self::$instances['request'])) {
            include_once PATH_ROOT.'/app/System/CRequest.php';

            $request = new CRequest();
            self::$instances['request'] = $request;
        }

        return self::$instances['request'];
    }

    public static function db()
    {
        if (!isset(self::$instances['db'])) {
            include_once PATH_ROOT.'/app/System/Database.php';
            $db = new \App\System\Database();
            self::$instances['db'] = $db;
        }
        return self::$instances['db'];
    }

    public static function userRepository()
    {
        if (!isset(self::$instances['userRepository'])) {
            include_once PATH_ROOT.'/app/Repository/UserRepository.php';
            $userRepository = new \App\Repository\UserRepository(self::db());
            self::$instances['userRepository'] = $userRepository;
        }
        return self::$instances['userRepository'];
    }

    public static function auth()
    {
        if (!isset(self::$instances['auth'])) {
            include_once PATH_ROOT.'/app/Auth/Auth.php';
            $auth = new \App\Auth\Auth(self::userRepository());
            self::$instances['auth'] = $auth;
        }
        return self::$instances['auth'];
    }
}
