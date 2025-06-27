<?php

namespace App\Controllers;

use App\Models\TutorialModel;
use App\System\PageNotFoundException;
use App\System\CRequest;
use App\System\Validator;
use App\System\JavaScript;

class TutorialAdmin
{
    public function index()
    {
        return JavaScript::redirectTo('admin/login');
    }

    public function login($submit = null)
    {
        if ($submit == null) {
            return view('tutorial/header')
                . view('tutorial/admin/login')
                . view('tutorial/footer');
        }
        
        $request = new CRequest();
        $data = $request->getPost(['email', 'password']);
        
        $model = model(TutorialModel::class);
        $result = $model->login('admin', $data['email'], $data['password']);
        
        if ($result) {
            $session = session();
            $session->set('user_id', 1);
            $session->set('is_admin', 1);

            // redirect(site_url('admin/home'));
            return JavaScript::redirectTo('../home');
        } else {
            // redirect(site_url('admin/login'));
            return JavaScript::redirectTo('admin/login');
        }
    }

    // ------------------------------------------------------------------------

    public function home()
    {
        $model = model(TutorialModel::class);

        $data = [
            'users' => $model->findAll()
        ];

        return view('tutorial/header')
            . view('tutorial/admin/home', $data)
            . view('tutorial/footer');
    }

    // ------------------------------------------------------------------------

    public function logout()
    {
        $session = session();
        $session->destroy();
        return JavaScript::redirectTo('login');
    }
    
    // ------------------------------------------------------------------------

    public function create_user()
    {
        $request = new CRequest();
        $data = $request->getPost(['email', 'password']);

        $model = model(TutorialModel::class);

        $model->create($data['email'], $data['password']);
    }

    // ------------------------------------------------------------------------
    
    public function delete_user($user_id)
    {
        $model = model(TutorialModel::class);
        echo $model->delete($user_id);
    }

}
