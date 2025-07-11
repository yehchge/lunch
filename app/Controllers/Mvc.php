<?php

namespace App\Controllers;

use App\System\CRequest;
use App\Models\MvcUserModel;
use App\Models\MvcDataModel;
use App\System\Hash;
use App\System\JavaScript;
use App\System\Form;
use App\System\Validator;

class Mvc
{
    public function index()
    {
        return view('mvc/header', ['title' => 'Home'])
            . view('mvc/index/index')
            . view('mvc/footer');
    }

    public function help()
    {
        return view('mvc/header', ['title' => 'Help'])
            . view('mvc/index/help')
            . view('mvc/footer');
    }

    public function login()
    {
        return view('mvc/header', ['title' => 'Login'])
            . view('mvc/index/login')
            . view('mvc/footer');
    }

    public function run()
    {
        $request = new CRequest();
        $post = $request->getPost(['login', 'password', 'remember']);

        $model = model(MvcUserModel::class);

        $password = Hash::create('md5', $post['password'], HASH_PASSWORD_KEY);

        $data = $model->where('login', $post['login'])
            ->where('password', $password)
            ->first();

        if ($data) {
            // login
            $session = session();
            $session->set('role', $data['role']);
            $session->set('loggedIn', true);
            $session->set('userid', $data['userid']);

            $cookiehash = md5(sha1($data['login'].CRequest::getAddress()));

            if ($post['remember'] === 'on') {
                // echo "has";exit;
                setcookie('username', $cookiehash, time() + 3600 * 24 * 365, '/');
            } else {
                // echo "no chek";exit;
                setcookie('username', $cookiehash, 0, '/');
            }

            $postData = [
                'login_session' => $cookiehash,
            ];

            // $this->db->update('mvc_user', $postData, "`userid` = '{$data['userid']}'");

            return JavaScript::redirectTo('../dashboard');

            // header('location: ../dashboard');
        } else {
            // show an error!
            // header('location: ../login');
            return JavaScript::redirectTo('../login');
        }

    }

    public function dashboard()
    {
        // Auth::handleLogin();

        return view('mvc/header', ['title' => 'Dashboard', 'js' => ['assets/public/js/default.js']])
            . view('mvc/index/dashboard')
            . view('mvc/footer');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        setcookie('username', '', 0, '/');
        return JavaScript::redirectTo('../login');

        // Session::destroy();
        // setcookie('username', '', 0, '/');
        // header('location: '.URL.'login');
        // exit;
    }

    public function xhrInsert()
    {
        // $this->model->xhrInsert();

        $request = new CRequest();
        $text = $request->getPost('text');

        // Read new token and assign in $data['token']
        $token = csrf_hash();

        $model = model(MvcDataModel::class);
        $model->insert(['text' => $text]);

        $data = ['text' => $text, 'id' => $model->getInsertID(), 'csrf' => $token];

        $response = service('response');
        return $response->json($data);
    }

    public function xhrGetListings()
    {
        // $this->model->xhrGetListings();

        $model = model(MvcDataModel::class);
        $data = $model->findAll();

        $response = service('response');
        return $response->json($data);
    }

    public function xhrDeleteListing()
    {
        // $this->model->xhrDeleteListing();

        $model = model(MvcDataModel::class);
        $request = new CRequest();
        $id = $request->getPost('id');
        $model->delete($id);

        // Read new token and assign in $data['token']
        $token = csrf_hash();

        $response = service('response');
        return $response->json(['csrf' => $token]);
    }

    public function form()
    {
        if (isset($_REQUEST['run'])) {
            try {

                $valid_way = 2; // 1 or 2

                if ($valid_way==2) {
                    $request = new CRequest();
                    $data = $request->getPost(['name', 'age']);

                    $validator = new Validator(
                        $data, [
                        'name' => 'required|min:2',
                        'age'  => 'required|numeric|min:2',
                        ]
                    );

                    if ($validator->validate()) {
                        echo "Validation passed!\n";

                        echo '<pre>';
                        print_r($data);
                        echo '</pre>';
                    } else {
                        $message = '';
                        // 輸出錯誤訊息
                        foreach ($validator->getErrors() as $field => $errors) {
                            foreach ($errors as $error) {
                                $message .= $error."<br>";
                            }
                        }

                        throw new \Exception($message);
                    }
                } else {
                    $form = new Form();

                    $form->post('name')
                        ->val('minlength', 2)

                        ->post('age')
                        ->val('minlength', 2)
                        ->val('digit')

                        ->post('gender');

                    $form->submit();

                    echo 'The form passed!';
                    $data = $form->fetch();

                    echo '<pre>';
                    print_r($data);
                    echo '</pre>';
                }

                $db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
                $db->insert('person', $data);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return view('mvc/header', ['title' => 'Form', 'js' => ['assets/public/js/default.js']])
            . view('mvc/index/form')
            . view('mvc/footer');
    }

}
