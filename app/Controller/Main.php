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

class Main
{
    public function index()
    {
        $data = [];
        $model = new DummyTableModel;
        $data['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
        $data['perPage'] = 15;
        $data['total'] = $model->countAll();
        $data['data'] = $model->paginate($data['perPage']);
        $data['pager'] = $model->pager;

        return view('layouts/home', $data);
    }

}
