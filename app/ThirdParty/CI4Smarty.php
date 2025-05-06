<?php

/**
 * CodeIgniter 4 Smarty
 * @created 2022/12/15
 */

declare(strict_types=1); // 嚴格類型

// namespace App\ThirdParty;

class CI4Smarty extends \Smarty
{
    protected $TemplateDir    = APPPATH . 'Views' . DIRECTORY_SEPARATOR . 'tpl';
    protected $CompileDir     = WRITEPATH . 'smarty' . DIRECTORY_SEPARATOR . 'tpl_c';
    protected $LeftDelimiter  = "<{";
    protected $RightDelimiter = "}>";
    protected $CacheDir       = WRITEPATH . 'smarty' . DIRECTORY_SEPARATOR . 'cache';
    protected $ConfigDir      = WRITEPATH . 'smarty' . DIRECTORY_SEPARATOR . 'configs';
    
    public function __construct()
    {
        // 注意: 需要安裝 Smarty 套件
        parent::__construct();

        $this->setTemplateDir( $_ENV['CI4Smarty.TemplateDir']    ?? $this->TemplateDir )
            ->setCompileDir  ( $_ENV['CI4Smarty.CompileDir']     ?? $this->CompileDir )
            ->setCacheDir    ( $_ENV['CI4Smarty.CacheDir']       ?? $this->CacheDir )
            ->setConfigDir   ( $_ENV['CI4Smarty.ConfigDir']      ?? $this->ConfigDir )
            ->setDebugging   ( boolval($_ENV['CI4Smarty.Debug']  ?? false) );

        $this->setLeftDelimiter ( $_ENV['CI4Smarty.LeftDelimiter']  ??  $this->LeftDelimiter );
        $this->setRightDelimiter(  $_ENV['CI4Smarty.RightDelimiter'] ?? $this->RightDelimiter );


        // if (!file_exists($this->TemplateDir)) {
        //     exit("Directory not exists! Please create directory: ".$this->TemplateDir);
        // }

        // if (!file_exists($this->CompileDir)) {
        //     exit("Directory not exists! Please create directory: ".$this->CompileDir);
        // }

        // if (!is_writable($this->CompileDir)) {
        //     exit("Directory not write! Please open can write: ".$this->CompileDir);
        // }

        $this->registerPlugin("modifier", "in_array", "in_array");
        $this->registerPlugin("modifier", "count", "count");
        $this->registerPlugin("modifier", "trim", "trim");
        $this->registerPlugin("modifier", "array_key_exists", "array_key_exists");
        $this->registerPlugin("modifier", "number_format", "number_format");
    }
}
