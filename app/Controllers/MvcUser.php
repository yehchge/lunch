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
        $model = model(MvcUserModel::class);
        
        return view('mvc/header', ['title' => 'Users'])
            . view('mvc/user/index', ['userList' => $model->findAll()])
            . view('mvc/footer');
    }


    public function create()
    {
        $request = new CRequest();
        $data = $request->getPost(['login', 'password', 'role']);

        // @TODO: Do your error checking!

        $model = model(MvcUserModel::class);
        $model->save($data);
        // header('location: '.URL.'user');

        return JavaScript::redirect('../user');
    }

    public function edit($id)
    {
        $model = model(MvcUserModel::class);

        return view('mvc/header', ['title' => 'Edit User'])
            . view('mvc/user/edit', ['user' => $model->find($id)])
            . view('mvc/footer');
    }

    public function editSave($userid)
    {
        $request = new CRequest();
        $data = $request->getPost(['login', 'password', 'role']);

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
