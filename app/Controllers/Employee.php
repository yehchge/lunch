<?php

/**
 * Restful API 練習
 *
 * @ref
 *     產生 restful controller
 *     https://onlinewebtutorblog.com/restful-resource-controller-in-codeigniter-4/
 *     檢查輸入資料參考以下網頁
 *     https://programmingfields.com/how-to-create-restful-api-in-codeigniter-4-step-by-step/
 *     Disabled some csrf ref
 *     https://samsonasik.wordpress.com/2020/04/09/create-restful-api-in-codeigniter-4/
 *     JWT ref
 *     https://www.binaryboxtuts.com/php-tutorials/codeigniter-4-json-web-tokenjwt-authentication/
 *     設定 filter API 不使用 csrf
 *     http://blog.a-way-out.net/blog/2020/12/20/codeigniter4-rest-api/
 *     使用網頁顯示測試 restful API
 *     https://wpwebinfotech.com/blog/dynamic-web-app-with-crud-api-builder-in-codeigniter/
 *     AJAX 參考 CRUD
 *     https://github.com/tattersoftware/codeigniter4-forms/tree/develop/examples/Views
 * @cli
 *     php spark make:controller Employee --restful
 *     php spark make:model employee --suffix
 */

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\System\CResponse;
use App\System\CRequest;
use App\System\Validator;


class Employee
{
    public function index()
    {
        // all user
        $model = model(EmployeeModel::class);
        $data['employee'] = $model->orderBy('id', 'DESC')->findAll();

        $response = new CResponse();
        return $response->respond($data);
    }

    public function show($id = null)
    {
        // single user
        $model = model(EmployeeModel::class);
        $data = $model->where('id', $id)->first();

        $response = new CResponse();

        if($data) {
            // return $this->respond($data);
            return $response->respond($data);
        }else{
            // return $this->failNotFound('No employee found');
            return $response->failNotFound('No employee found');
        }
    }

    public function create()
    {
        // create
        // $validation = $this->validate([
        //     'name' => 'required',
        //     'email' => 'required|valid_email|min_length[6]|is_unique[employee.email]',
        // ]);

        // if(!$validation) {
        //     return $this->failValidationErrors($this->validator->getErrors());
        // }

        $resp = new CResponse();

        $model = model(EmployeeModel::class);

        // Using php://input to Access Raw POST Data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $validator = new Validator(
            $data, [
            'name' => 'required',
            'email'  => 'required|email',
            ]
        );

        if ($validator->validate()) {
            // echo "Validation passed!\n";
        } else {

            $data = [];
            // 輸出錯誤訊息
            foreach ($validator->getErrors() as $field => $errors) {
                foreach ($errors as $error) {
                    $data[$field] = $error;
                }
            }

            $response = new CResponse();

            return $response->fail(
                [
                'status' => 400,
                'error' => 400,
                'messages' => $data
                ]
            );
        }

        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Employee created successfully'
            ]
        ];

        return $resp->respondCreated($response);
    }

    public function update($id = null)
    {
        // update
        $model = new EmployeeModel();
        $resp = new CResponse();

        $data = $model->find($id);

        if($data) {
            // use postman, data set: body.raw[JSON], method: put
            // {
            //      "name": "Tony Stark",
            //      "email": "tony@mcu.com"
            // }


            // $validation = $this->validate([
            //     'name' => 'required',
            //     'email' => 'required|valid_email',
            // ]);

            // if(!$validation){
            //     return $this->failValidationErrors($this->validator->getErrors());
            // }

            // $data = [
            //     'name' => $this->request->getVar('name'),
            //     'email' => $this->request->getVar('email')
            // ];

            // Using php://input to Access Raw POST Data
            $json = file_get_contents('php://input');

            $data = json_decode($json, true);

            $validator = new Validator(
                $data, [
                'name' => 'required',
                'email'  => 'required|email',
                ]
            );

            if ($validator->validate()) {
                // echo "Validation passed!\n";
            } else {

                $data = [];
                // 輸出錯誤訊息
                foreach ($validator->getErrors() as $field => $errors) {
                    foreach ($errors as $error) {
                        $data[$field] = $error;
                    }
                }

                return $resp->fail(
                    [
                    'status' => 400,
                    'error' => 400,
                    'messages' => $data
                    ]
                );
            }


            $model->update($id, $data);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'Employee updated successfully'
                ]
            ];
            
            return $resp->respond($response);
        }
        return $resp->failNotFound('Sorry! no Employee found');
    }

    public function delete($id = null)
    {
        // delete
        $model = new EmployeeModel();
        $resp = new CResponse();

        $data = $model->find($id);
        if($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $resp->respondDeleted($response);
        }else{
            return $resp->failNotFound('No employee found by id: '.$id);
        }
    }
}
