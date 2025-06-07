<?php

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
        
        // $message = session()->get('error');
        // session()->remove('error');
        // echo $message;

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
                    // echo "$error\n";
                    $message .= $error."<br>";
                }
            }

            // session()->set('error', $message);
            // echo $message;    
            session()->setFlashdata('error', $message);
            return $this->new();
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
