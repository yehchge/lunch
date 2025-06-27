<?php

namespace App\Controllers;

use App\Models\TutorialModel;
use App\System\PageNotFoundException;
use App\System\CRequest;
use App\System\Validator;
use App\System\JavaScript;

class Tutorial
{
    public function index()
    {
        return view('tutorial/header')
            . view('tutorial/index/home')
            . view('tutorial/footer');
    }

    // ------------------------------------------------------------------------
    
    public function dashboard()
    {
        // redirect(site_url('dashboard/login'));

        $session = session();
        $session->destroy();
        return JavaScript::redirectTo('./login');
    }
    
    // ------------------------------------------------------------------------

    public function home()
    {
        return view('tutorial/header')
            . view('tutorial/dashboard/home')
            . view('tutorial/footer');
    }

    // ------------------------------------------------------------------------
    
    public function account()
    {
        return view('tutorial/header')
            . view('tutorial/dashboard/account')
            . view('tutorial/footer');
    }
    
    // ------------------------------------------------------------------------

    
    public function login($submit = null)
    {
        // echo sha1('admin' . HASH_KEY);
        // echo sha1('test' . HASH_KEY);
        if ($submit == null) {
            return view('tutorial/header')
                . view('tutorial/dashboard/login')
                . view('tutorial/footer');
        }
        
        $request = new CRequest();
        $data = $request->getPost(['email', 'password']);

        $model = model(TutorialModel::class);
        $result = $model->login('user', $data['email'], $data['password']);

        if ($result) {
            $session = session();
            $session->set('user_id', 1);

            // redirect(site_url('dashboard/home'));
            return JavaScript::redirectTo('../home');
        } else {
            echo "error Login";exit;
            // redirect(site_url('dashboard/login'));
            return JavaScript::redirectTo('./dashboard/login');
        }
    }
}
