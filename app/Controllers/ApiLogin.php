<?php

/**
 * JWT API User
 *
 * @ref     https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *      https://medium.com/geekculture/codeigniter-4-tutorial-restful-api-jwt-authentication-d5963d797ec4
 * @created 2022/12/22
 */

namespace App\Controllers;

// use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;

// use CodeIgniter\API\ResponseTrait;


use App\Models\ApiUserModel;
use App\System\CResponse;
use App\System\CRequest;
use \Firebase\JWT\JWT;

class ApiLogin
{
    // use ResponseTrait;

    public function index()
    {
        $apiUserModel = new ApiUserModel();
        $resp = new CResponse();

        $request = new CRequest();

        $email = $request->getPost('email');
        $password = $request->getPost('password');

        $user = $apiUserModel->where('email', $email)->first();

        if(is_null($user)) {
            return $resp->respond(['error' => 'Invalid username or password.'], 401);
        }

        $pwd_verify = password_verify($password, $user['password']);

        if(!$pwd_verify) {
            return $resp->respond(['error' => 'Invalid user or password.'], 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, // Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
        );

        $token = JWT::encode($payload, $key, 'HS256');
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];

        return $resp->respond($response, 200);
    }
}
