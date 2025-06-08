<?php

namespace App\System;

// 基底命令類，定義必要屬性和方法
abstract class BaseCommand {
    public $group;
    public $name;
    public $description;

    abstract public function run(array $params);

    // 可選：提供通用方法，例如參數解析
    protected function getParam(array $params, int $index, string $default = ''): string
    {
        return $params[$index] ?? $default;
    }
}
