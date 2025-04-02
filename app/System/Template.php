<?php

/**
 * How to use ??
 */

// `views/example.tpl`

// {extends "layout.tpl"}

// {block "title"}{$title}{/block}

// {block "content"}
//     <p>{$message|htmlspecialchars}</p>
//     {if $isLoggedIn}
//         <p>歡迎回來，{$username}！</p>
//     {else}
//         <p>請登入</p>
//     {/if}

//     <ul>
//     {foreach $items as $item}
//         <li>{$item|strtoupper}</li>
//     {/foreach}
//     </ul>
// {/block}


// `views/layout.tpl`

// <html>
// <head>
//     <title>{block "title"}預設標題{/block}</title>
// </head>
// <body>
//     {block "content"}預設內容{/block}
// </body>
// </html>


// `view.php`

// $template = new Template('views');
// $template->assign('title', '我的網站');
// $template->assign('message', '這是一條訊息');
// $template->assign('isLoggedIn', true);
// $template->assign('username', 'Alice');
// $template->assign('items', ['蘋果', '香蕉', '櫻桃']);

// echo $template->render('example.tpl');

class Template {
    protected string $viewPath;
    protected array $vars = [];
    protected array $filters = [];
    
    public function __construct(string $viewPath) {
        $this->viewPath = rtrim($viewPath, '/') . '/';
        
        // 預設過濾器
        $this->filters = [
            'htmlspecialchars' => fn($v) => htmlspecialchars($v, ENT_QUOTES, 'UTF-8'),
            'strtoupper' => 'strtoupper',
            'nl2br' => 'nl2br',
        ];
    }

    public function assign(string $key, mixed $value): void {
        $this->vars[$key] = $value;
    }

    public function addFilter(string $name, callable $callback): void {
        $this->filters[$name] = $callback;
    }

    public function render(string $template, array $vars = []): string {
        $this->vars = array_merge($this->vars, $vars);
        return $this->compile(file_get_contents($this->viewPath . $template));
    }

    public function display(string $template, array $vars = []): void {
        echo $this->render($template, $vars);
        exit;
    }    

    protected function compile(string $content): string {
        // 變數替換 (支援過濾器 {$var|filter})
        $content = preg_replace_callback('/\{\$([\w]+)(\|[\w]+)?\}/', function ($matches) {
            $varName = $matches[1];
            $filter = $matches[2] ?? '|htmlspecialchars';
            $filter = ltrim($filter, '|');

            $value = $this->vars[$varName] ?? '';
            return $this->applyFilter($value, $filter);
        }, $content);

        // if 條件處理
        $content = preg_replace('/\{if (.+?)\}/', '<?php if ($1): ?>', $content);
        $content = preg_replace('/\{else\}/', '<?php else: ?>', $content);
        $content = preg_replace('/\{\/if\}/', '<?php endif; ?>', $content);

        // foreach 迴圈
        $content = preg_replace('/\{foreach (\$[\w]+) as (\$[\w]+)\}/', '<?php foreach ($1 as $2): ?>', $content);
        $content = preg_replace('/\{\/foreach\}/', '<?php endforeach; ?>', $content);

        // include 模板
        $content = preg_replace_callback('/\{include "(.+?)"\}/', function ($matches) {
            return $this->render($matches[1]);
        }, $content);

        // extends + block 處理
        if (preg_match('/\{extends "(.+?)"\}/', $content, $match)) {
            $layout = file_get_contents($this->viewPath . $match[1]);
            $content = preg_replace('/\{extends "(.+?)"\}/', '', $content);
            
            preg_match_all('/\{block "(.+?)"\}(.*?)\{\/block\}/s', $content, $blocks, PREG_SET_ORDER);
            foreach ($blocks as $block) {
                $layout = preg_replace("/\{block \"{$block[1]}\"\}(.*?)\{\/block\}/s", $block[2], $layout);
            }
            $content = $layout;
        }

        // 解析 PHP 代碼
        /*
        ob_start();
        eval('?>' . $content);
        return ob_get_clean();
        */

        // 解析 PHP 代碼
        $vars = $this->vars; // 傳遞變數
        return (function () use ($vars, $content) {
            extract($vars);
            ob_start();
            eval('?>' . $content);
            return ob_get_clean();
        })();
    }

    protected function applyFilter(mixed $value, string $filter): string {
        return isset($this->filters[$filter]) ? ($this->filters[$filter])($value) : $value;
    }
}