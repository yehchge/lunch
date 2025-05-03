<?php

// Author: Yogesh singh
// Author URL: https://makitweb.com/
// Author Email: makitweb@gmail.com
// Tutorial Link: https://makitweb.com/make-pagination-with-search-filter-in-codeigniter-4/

// ######
// 1. Set your database configuration on .env file.
// 2. Update app.baseURL value in .env file.
// 3. Run "php spark migrate" to create the "users" table.
// 4. Insert some data in the "users" table.
// 5. To run the project execute "php spark serve".

// use App\Models\PaginationModel;

function view(string $viewName, array $data = []): void
{
    // 設定 views 的資料夾路徑
    $viewPath = PATH_ROOT . '/app/Views/' . $viewName . '.php';

    if (!file_exists($viewPath)) {
        http_response_code(404);
        echo "View '{$viewName}' not found.";
        return;
    }

    // 將 data 陣列的 key 轉成變數
    extract($data);

    // 載入 view 檔案
    include $viewPath;
}

class PaginationController
{
    public function index()
    {
        $response = new CResponse();
        return $response->redirect('./loadRecord');
        // return redirect()->route('loadRecord'); 
    }

    public function loadRecord()
    {
        // $request = service('request');

        $request = new CRequest();
        $searchData  = $request->getGet();

        $search = '';
        if (isset($searchData) && isset($searchData['search'])) {
            $search = $searchData['search'];
        }

        // Get data
        $users = new PaginationModel();

        if ($search == '') {
            $paginateData = $users->paginate(5);
        } else {
            $paginateData = $users->select('*')
                ->orLike('name', $search)
                ->orLike('email', $search)
                ->orLike('city', $search)
                ->paginate(5);
        }

        $data = [
            'users' => $paginateData,
            'pager' => $users->pager,
            'search' => $search
        ];

        return view('pagination', $data);
    }
}