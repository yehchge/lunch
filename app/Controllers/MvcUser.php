<?php

namespace App\Controllers;

use App\System\CRequest;
use App\Models\MvcUserModel;
use App\Models\MvcDataModel;
use App\System\Hash;
use App\System\JavaScript;

class MvcUser
{
    public function __construct()
    {
        // parent::__construct();
        // Auth::handleLogin();
    }

    public function index()
    {
        // $this->view->title = 'Users';
        // $this->view->userList = $this->model->userList();

        $model = model(MvcUserModel::class);
        
        return view('mvc/header', ['title' => 'Users'])
            . view('mvc/user/index', ['userList' => $model->findAll()])
            . view('mvc/footer');
    }


    public function create()
    {
        $request = new CRequest();
        $data = $request->getPost(['login', 'password', 'role']);

        // $data = [];
        // $data['login'] = $_POST['login'];
        // $data['password'] = $_POST['password'];
        // $data['role'] = $_POST['role'];

        // @TODO: Do your error checking!

        $model = model(MvcUserModel::class);
        $model->save($data);
        // header('location: '.URL.'user');

        return JavaScript::redirect('../user');
    }

    public function edit($id)
    {
        // $this->view->title = 'Edit User';
        // $this->view->user = $this->model->userSingleList($id);

        // $this->view->render('header');
        // $this->view->render('user/edit');
        // $this->view->render('footer');


        $model = model(MvcUserModel::class);

        return view('mvc/header', ['title' => 'Edit User'])
            . view('mvc/user/edit', ['user' => $model->find($id)])
            . view('mvc/footer');
    }

    public function editSave($userid)
    {
        $request = new CRequest();
        $data = $request->getPost(['login', 'password', 'role']);

        // $data = [];
        // $data['id'] = $userid;
        // $data['login'] = $_POST['login'];
        // $data['password'] = $_POST['password'];
        // $data['role'] = $_POST['role'];

        // @TODO: Do your checking!

        $model = model(MvcUserModel::class);

        $model->update($userid, $data);

        return JavaScript::redirect('../');

        // $this->model->editSave($data);
        // header('location: '.URL.'user');
    }

    public function delete($userid)
    {
        $model = model(MvcUserModel::class);

        $model->delete($userid);
        return JavaScript::redirect('../');


        // $this->model->delete($userid);
        // header('location: '.URL.'user');
    }



}



// class User_Model extends Model
// {
//     public function __construct()
//     {
//         parent::__construct();
//     }

//     public function userList()
//     {
//         return $this->db->select('SELECT userid, login, role FROM mvc_user');
//     }

//     public function userSingleList($userid)
//     {
//         return $this->db->select('SELECT userid, login, role FROM mvc_user WHERE userid = :userid', [':userid' => $userid]);
//     }

//     public function create($data)
//     {
//         $this->db->insert('mvc_user', [
//             'login' => $data['login'],
//             'password' => Hash::create('md5', $data['password'], HASH_PASSWORD_KEY),
//             'role' => $data['role'],
//         ]);
//     }

//     public function editSave($data)
//     {
//         $postData = [
//             'login' => $data['login'],
//             'password' => Hash::create('md5', $data['password'], HASH_PASSWORD_KEY),
//             'role' => $data['role'],
//         ];

//         $this->db->update('mvc_user', $postData, "`userid` = {$data['userid']}");
//     }

//     public function delete($userid)
//     {
//         $result = $this->db->select('SELECT role FROM mvc_user WHERE userid = :userid', [':userid' => $userid]);

//         if ($result[0]['role'] == 'owner') {
//             return false;
//         }

//         $this->db->delete('mvc_user', "userid = '$userid'");
//     }
// }
