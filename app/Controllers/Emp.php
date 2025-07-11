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
    // protected $modelName = 'App\Models\EmployeeModel';
    /**
     * Present a view of resource objects.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = model(EmployeeModel::class);
        return view('employee/index', ['employee' => $model->findAll()]);
    }

    /**
     * Present a view to present a new single resource object.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('employee/create');
    }

    /**
     * Present a view to edit the properties of a specific resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        return view('employee/edit');
    }

}
