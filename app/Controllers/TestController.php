<?php

// cli: php spark make:controller Test --restful --suffix

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class TestController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //顯示資料列表
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //顯示單筆詳細資料
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //顯示新增表單
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //新增表單送出
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //顯示編輯表單
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //編輯表單送出
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //刪除單筆資料
    }
}
