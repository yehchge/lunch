<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\System\PageNotFoundException;
use App\System\CRequest;
use App\System\Validator;
use App\System\JavaScript;

class News
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news_list' => $model->getNews(),
            'title'     => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index', $data)
            . view('templates/footer');
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
            . view('news/create', ['title' => 'Create a news item'])
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
        $post = $request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        $validator = new Validator(
            $post, [
            'title' => 'required|max:255|min:3',
            'body'  => 'required|max:5000|min:10',
            ]
        );

        if ($validator->validate()) {
            // echo "Validation passed!\n";
        } else {
            // $message = '';
            // // 輸出錯誤訊息
            // foreach ($validator->getErrors() as $field => $errors) {
            //     foreach ($errors as $error) {
            //         $message .= $error."<br>";
            //     }
            // }

            // session()->setFlashdata('errors', $message);
            // // return $this->new();
            return redirect()->to('news/new');
        }

        // Gets the validated data.
        // $post = $this->validator->getValidated();

        $model = new NewsModel();

        $model->save(
            [
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
            ]
        );

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }

}
