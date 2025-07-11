<?php

/**
 * JWT API User
 *
 * @ref https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *      https://medium.com/geekculture/codeigniter-4-tutorial-restful-api-jwt-authentication-d5963d797ec4
 * @created 2022/12/22
 */

namespace App\Controllers;

use App\Models\ApiUserModel;
use App\System\CResponse;
use App\System\CRequest;
use App\System\Validator;

class ApiRegister
{
    public function index()
    {
        $request = new CRequest();

        $email = $request->getPost('email');

        $data = [
            'email' => $email,
            'password' => $request->getPost('password'),
            'confirm_password' => $request->getPost('confirm_password')
        ];

        $model = new ApiUserModel();

        $row = $model->where('email', $email)->first();

        if($row) {
            $response = [
                'errors' => 'The email field must contain a unique value.',
                'message' => 'Invalid Inputs'
            ];

            $resp = new CResponse();
            return $resp->fail($response, 409);
        }

        $rules = [
            'email' => 'required|email|min:4|max:255',
            'password' => 'required|min:8|max:255',
            'confirm_password' => 'required|min:8|max:255|same:password',
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            print_r($validator->getErrors());

            $resp = new CResponse();
            return $resp->fail($validator->getErrors(), 409);
        }

        $data['password'] = password_hash($request->getPost('password'), PASSWORD_DEFAULT);
        $model->save($data);

        $response = new CResponse();
        return $response->respond(['message' => 'registerd Successfully'], 200);
    }
}
