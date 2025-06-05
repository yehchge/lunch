<?php

class News
{
    public function index()
    {
        // $model = model(NewsModel::class);
        $model = new NewsModel();

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
        // $model = model(NewsModel::class);
        $model = new NewsModel();

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
        // 使用範例
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $posted_token = $_POST['csrf_token'] ?? '';
        //     if (verifyCsrfToken($posted_token)) {
        //         // echo "CSRF token 驗證成功，可以處理表單數據";
        //     } else {
        //         http_response_code(403);
        //         echo "CSRF token 驗證失敗";
        //         exit;
        //     }
        // }

        // helper('form');

        // $data = $this->request->getPost(['title', 'body']);

        $request = new CRequest();
        $data  = $request->getPost();

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
