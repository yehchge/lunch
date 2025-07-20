<?php

/**
 * 建立 employee restful api 的網頁界面測試
 *
 * @ref
 *     使用網頁顯示測試 restful API
 *     https://wpwebinfotech.com/blog/dynamic-web-app-with-crud-api-builder-in-codeigniter/
 * @cli
 *     php spark make:controller emp --restful presenter
 */
namespace App\Controllers;

use App\Models\EmployeeModel;

class Emp
{
    public function index()
    {
        $model = model(EmployeeModel::class);
        return view('employee/index', ['employee' => $model->findAll()]);
    }

    public function new()
    {
        return view('employee/create');
    }

    public function edit()
    {
        return view('employee/edit');
    }
}
