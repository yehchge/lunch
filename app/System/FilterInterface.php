<?php

// 檔案：src/Core/FilterInterface.php
// 定義過濾器介面
namespace App\System;

interface FilterInterface
{
    public function before(CRequest $request, CResponse $response);
    public function after(CRequest $request, CResponse $response);
}
