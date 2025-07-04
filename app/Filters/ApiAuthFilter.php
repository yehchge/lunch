<?php

/**
 * JWT API Filter
 *
 * @ref     https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *      https://medium.com/geekculture/codeigniter-4-tutorial-restful-api-jwt-authentication-d5963d797ec4
 * @created 2022/12/22
 */

// namespace App\Filters;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiAuthFilter
{
    public function handle()
    {
        $key = getenv('JWT_SECRET');

        $request = new CRequest();
        $header = $request->getHeader('Authorization');
        $token = null;

        // extract the token from the header
        if(!empty($header)) {
            if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                $token = $matches[1];
            }
        }


        // check if token is null or empty
        if(is_null($token) || empty($token)) {
            $response = service('response');
            return $response->setTerminate()->setBody('Access denied')->setStatusCode(401)->send();
        }

        try {
            // $decoded = JWT::decode($token, $key, array("HS256"));
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $ex) {
            $response = service('response');
            // $response->setBody('Access denied');
            // $response->setStatusCode(401);
            return $response->setTerminate()->setBody('Access denied')->setStatusCode(401)->send();
        }
    }
}
