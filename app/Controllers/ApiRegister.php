<?php

/**
 * JWT API User
 * @ref https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *      https://medium.com/geekculture/codeigniter-4-tutorial-restful-api-jwt-authentication-d5963d797ec4
 * @created 2022/12/22
 */

namespace App\Controllers;

// use App\Controllers\BaseController;
// use CodeIgniter\HTTP\ResponseInterface;

// use CodeIgniter\API\ResponseTrait;
// use App\Models\ApiUserModel;

class ApiRegister
{
    // use ResponseTrait;

    public function index()
    {
        $rules = [
            // 'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[api_users.email]'],
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[api_users.email]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirm_password' => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];

        $request = new CRequest();

        $email = $request->getPost('email');

        $data = [
            'email' => $email,
            'password' => $request->getPost('password'),
            'confirm_password' => $request->getPost('confirm_password')
        ];

        $model = new ApiUserModel();

        $row = $model->where('email', $email)->first();

        if($row){
            $response = [
                'errors' => 'The email field must contain a unique value.',
                'message' => 'Invalid Inputs'
            ];

            $resp = new CResponse();
            return $resp->fail($response, 409);
            // return $this->fail($response, 409);
        }

        // if($this->validate($rules)){
        // if($this->validateData($data, $rules, [], $model->DBGroup)){
            $data['password'] = password_hash($request->getPost('password'), PASSWORD_DEFAULT);
            $model->save($data);

            $response = new CResponse();
            return $response->respond(['message' => 'registerd Successfully'], 200);
            // return $this->respond(['message' => 'registerd Successfully'], 200);
        // }
    }
}
