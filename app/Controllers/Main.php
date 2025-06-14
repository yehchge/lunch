<?php

/**
 * Pagination Tutorial
 * @ref https://www.sourcecodester.com/tutorial/php/15412/codeigniter-4-pagination-tutorial
 * @cli php spark db:create dummy_db
 *      php spark make:migration DummyTable
 *      php spark migrate
 *      php spark make:model DummyTableModel
 *      php spark make:seeder DummyTableModelSeeder
 *      php spark db:seed DummyTableModelSeeder
 */

namespace App\Controllers;

use App\Models\DummyTableModel;
use App\System\CRequest;

class Main
{
    public function index()
    {
        $data = [];
        $model = new DummyTableModel;

        // 取得 perPage（預設 10）
        $request = new CRequest();
        $perPage = (int) $request->getGet('perPage') ?? 15;
        $perPage = in_array($perPage, [5, 10, 15, 25, 50, 100]) ? $perPage : 15;

        $sort = $request->getGet('sort') ?? 'id';
        $order = strtolower($request->getGet('order')) === 'desc' ? 'desc' : 'asc';

        // 驗證 sort 欄位是否允許排序
        $allowedSortFields = ['id', 'name', 'contact', 'email', 'address'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // 排序資料
        $users = $model->orderBy($sort, $order)->paginate($perPage);

        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['perPage'] = $perPage;
        $data['total'] = $model->countAll();
        $data['data'] = $users;
        $data['pager'] = $model->pager;

        return view('layouts/home', $data);
    }

}
