<?php

namespace App\Controllers;

use App\Models\DummyTableModel;
use App\System\CRequest;
use App\Models\MvcUserModel;
use App\Models\MvcDataModel;
use App\System\Hash;
use App\System\JavaScript;

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

        // $sth = $this->db->prepare('SELECT userid, login, role FROM mvc_user WHERE
        //         login = :login AND password = :password');
        // $sth->execute([
        //     ':login' => $_POST['login'],
        //     ':password' => Hash::create('md5', $_POST['password'], HASH_PASSWORD_KEY),
        // ]);
        // $data = $sth->fetch();

        // $count = $sth->rowCount();

        if ($data) {
            // login
            $session = session();
            $session->set('role', $data['role']);
            $session->set('loggedIn', true);
            $session->set('userid', $data['userid']);

            $cookiehash = md5(sha1($data['login'].CRequest::getAddress()));



            // Session::init();
            // Session::set('role', $data['role']);
            // Session::set('loggedIn', true);
            // Session::set('userid', $data['userid']);

            // $cookiehash = md5(sha1($data['login'].Misc::sGetIP()));

            // if (isset($_POST['remember'])) {
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


            return JavaScript::redirect('../dashboard');

            // header('location: ../dashboard');
        } else {
            // show an error!
            // header('location: ../login');
            return JavaScript::redirect('../mvc/login');
        }

    }

    public function dashboard()
    {
        // Auth::handleLogin();
        // $this->view->js = ['dashboard/js/default.js'];

        return view('mvc/header', ['title' => 'Dashboard', 'js' => ['assets/public/js/default.js']])
            . view('mvc/index/dashboard')
            . view('mvc/footer');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        setcookie('username', '', 0, '/');
        return JavaScript::redirect('../login');

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

}

    // public function xhrInsert()
    // {
    //     $text = $_POST['text'];

    //     $this->db->insert('data', ['text' => $text]);

    //     $data = ['text' => $text, 'id' => $this->db->lastInsertId()];
    //     echo json_encode($data);
    // }

    // public function xhrGetListings()
    // {
    //     $result = $this->db->select('SELECT * FROM data');
    //     echo json_encode($result);
    // }

    // public function xhrDeleteListing()
    // {
    //     $id = (int) $_POST['id'];
    //     $this->db->delete('data', "dataid=$id");
    // }
