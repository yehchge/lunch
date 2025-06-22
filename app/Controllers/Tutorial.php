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
        // $model = model(NewsModel::class);

        // $data = [
        //     'news_list' => $model->getNews(),
        //     'title'     => 'News archive',
        // ];

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
        return JavaScript::redirect('./login');
    }
    
    // ------------------------------------------------------------------------

    public function home()
    {
        return view('tutorial/header')
            . view('tutorial/dashboard/home')
            - view('tutorial/footer');
    }

    // ------------------------------------------------------------------------
    
    public function account()
    {
        return view('tutorial/header')
            . view('tutorial/dashboard/account')
            - view('tutorial/footer');
    }
    
    // ------------------------------------------------------------------------

    
    public function login($submit = null)
    {
        // echo sha1('admin' . HASH_KEY);
        // echo sha1('test' . HASH_KEY);
        if ($submit == null) {
            return view('tutorial/header')
                . view('tutorial/dashboard/login')
                - view('tutorial/footer');
        }
        
        // $email = $this->input->post('email');
        // $password = $this->input->post('password');

        $request = new CRequest();
        $data = $request->getPost(['email', 'password']);

        $model = model(TutorialModel::class);
        $result = $model->login('user', $data['email'], $data['password']);
        
        // $this->load->model('user_model');
        // $result = $this->user_model->login('user', $email, $password);
// echo "<pre>";print_r($result);echo "</pre>";
// exit;



       if ($result) {
            // $this->session->set_userdata('user_id', 1);
            $session = session();
            $session->set('user_id', 1);
// echo "login ok";exit;


            // redirect(site_url('dashboard/home'));
            return JavaScript::redirect('../home');
        } else {
            echo "error Login";exit;
            // redirect(site_url('dashboard/login'));
            return JavaScript::redirect('./dashboard/login');
        }
    }






















    public function show(?string $slug = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($slug);

        if ($data['news'] === null) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view', $data)
            . view('templates/footer');
    }

    public function new()
    {
        // helper('form');
        return view('templates/header', ['title' => 'Create a news item'])
            . view('tutorial/dashboard/create', ['title' => 'Create a news item'])
            . view('templates/footer');
    }



    /**
     * 根據提交的資料建立新聞項目。將在這裡做三件事：
     *
     * - 檢查提交的資料是否通過驗證規則。
     * - 將新聞項目儲存到資料庫。
     * - 返回成功頁面。
     */
    public function create()
    {
        // helper('form');

        $request = new CRequest();
        $data = $request->getPost(['title', 'body']);

        $validator = new Validator($data, [
            'title' => 'required|max:255|min:3',
            'body'  => 'required|max:5000|min:10',
        ]);

        if ($validator->validate()) {
            // echo "Validation passed!\n";
        } else {
            $message = '';
            // 輸出錯誤訊息
            foreach ($validator->getErrors() as $field => $errors) {
                foreach ($errors as $error) {
                    $message .= $error."<br>";
                }
            }

            session()->setFlashdata('errors', $message);
            // return $this->new();
            return JavaScript::redirect('./new');
        }

        // // Checks whether the submitted data passed the validation rules.
        // if (! $this->validateData($data, [
        //     'title' => 'required|max_length[255]|min_length[3]',
        //     'body'  => 'required|max_length[5000]|min_length[10]',
        // ])) {
        //     // The validation fails, so returns the form.
        //     return $this->new();
        // }

        // Gets the validated data.
        // $post = $this->validator->getValidated();

        // $model = model(NewsModel::class);

        $post = $data;

        $model = new NewsModel();

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }

}




// class Dashboard extends MY_Controller {

//     // ------------------------------------------------------------------------

//     public function __construct() 
//     {
//         parent::__construct();

//         // Get the last segment in the URI, and only redirect out of the
//         // protected area if it is NOT the login form
//         $section = $this->uri->segment_array();
//         array_shift($section);

//         $tmp = $this->uri->segment_array();
//         $section = end($tmp);
//         if ($section != 'login' && $section != 'submit'
//                 && $this->session->userdata('user_id') == false
//                 ) {
//             redirect(site_url('dashboard/login'));
//         }
//     }
    
//     // ------------------------------------------------------------------------
    
//     public function index()
//     {
//         redirect(site_url('dashboard/login'));
//     }
    
//     // ------------------------------------------------------------------------
    
//     public function login($submit = null)
//     {
//         // echo sha1('admin' . HASH_KEY);
//         // echo sha1('test' . HASH_KEY);
//         if ($submit == null) {
//             $this->load->view('dashboard/login', $this->data);
//             return true;
//         }
        
//         $email = $this->input->post('email');
//         $password = $this->input->post('password');
        
//         $this->load->model('user_model');
//         $result = $this->user_model->login('user', $email, $password);
        
//         if ($result == true) {
//             $this->session->set_userdata('user_id', 1);
//             redirect(site_url('dashboard/home'));
//         } else {
//             redirect(site_url('dashboard/login'));
//         }
//     }
    
//     // ------------------------------------------------------------------------
    

        
//     // ------------------------------------------------------------------------
    
//     public function account()
//     {
//         $this->load->view('dashboard/account', $this->data);
//     }
    
//     // ------------------------------------------------------------------------
    
//     public function logout()
//     {
//         $this->session->sess_destroy();
//         redirect(site_url('dashboard/login'));
//     }
    
//     // ------------------------------------------------------------------------
    
// }

