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

// Display

// <html>
// <head>
//     <title>我的網站</title>
// </head>
// <body>
//     <p>這是一條訊息</p>
//     <p>歡迎回來，Alice！</p>
//     <ul>
//         <li>蘋果</li>
//         <li>香蕉</li>
//         <li>櫻桃</li>
//     </ul>
// </body>
// </html>

// How to add filter ?

// $template->addFilter('custom', function ($value) {
//     return '★' . $value . '★';
// });

// {$var|custom} -> ★$var★

// How to change {}

// $template->setDelimiters('[[', ']]');

// $template->assign('content', '<b>Hello</b>');
// <p>{$content|raw}</p>      <!-- 直接輸出 <b>Hello</b> -->


class Template
{
    protected array $vars = [];
    protected array $filters = [];
    protected string $leftDelimiter = '\{';
    protected string $rightDelimiter = '\}';
    protected string $templateDir = './';
    protected array $blocks = [];
    protected array $blockStack = [];

    public function __construct(string $templateDir = './') {
        $this->templateDir = rtrim($templateDir, '/') . '/';

        // 預設過濾器
        $this->filters['htmlspecialchars'] = fn($v) => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        $this->filters['strtoupper'] = fn($v) => strtoupper($v);
        $this->filters['nl2br'] = fn($v) => nl2br($v);
    }

    public function assign(string $key, mixed $value): void {
        $this->vars[$key] = $value;
    }

    public function setDelimiters(string $left, string $right): void {
        $this->leftDelimiter = preg_quote($left, '/');
        $this->rightDelimiter = preg_quote($right, '/');
    }

    public function addFilter(string $name, callable $func): void {
        $this->filters[$name] = $func;
    }

    public function display(string $tpl): void {
        echo $this->render($tpl);
    }

    public function render(string $tpl): string {
        $tplFile = $this->templateDir . $tpl;
        if (!file_exists($tplFile)) {
            throw new Exception("Template file not found: $tplFile");
        }

        $content = file_get_contents($tplFile);
        $content = $this->handleExtends($content);
        $content = $this->parseTemplate($content);

        extract($this->vars);
        ob_start();
        eval('?>' . $content);
        return ob_get_clean();
    }

    protected function handleExtends(string $content): string {
        $ld = $this->leftDelimiter;
        $rd = $this->rightDelimiter;

        if (preg_match("/{$ld}extends\s+\"([^\"]+)\"{$rd}/", $content, $match)) {

            $parentTpl = file_get_contents($this->templateDir . $match[1]);

            // 擷取所有 block
            preg_match_all("/{$ld}block\s+\"([^\"]+)\"{$rd}(.*?){$ld}\/block{$rd}/s", $content, $blocks, PREG_SET_ORDER);

            foreach ($blocks as $b) {
                $this->blocks[$b[1]] = $b[2];
            }

            // 替換父模板內的 block
            $parentTpl = preg_replace_callback("/{$ld}block\s+\"([^\"]+)\"{$rd}(.*?){$ld}\/block{$rd}/s", function ($m) {
                $blockName = $m[1];
                $defaultContent = $m[2];
                return $this->blocks[$blockName] ?? $defaultContent;
            }, $parentTpl);

            return $parentTpl;
        }

        return $content;
    }

    protected function parseTemplate(string $content): string {
        $ld = $this->leftDelimiter;
        $rd = $this->rightDelimiter;

        // include
        $content = preg_replace_callback("/{$ld}include\s+\"([^\"]+)\"{$rd}/", function ($m) {
            $incFile = $this->templateDir . $m[1];
            return file_exists($incFile) ? file_get_contents($incFile) : '';
        }, $content);

        // if / else / endif
        $content = preg_replace("/{$ld}if\s+(.*?){$rd}/", "<?php if ($1): ?>", $content);
        $content = preg_replace("/{$ld}elseif\s+(.*?){$rd}/", "<?php elseif ($1): ?>", $content);
        $content = preg_replace("/{$ld}else{$rd}/", "<?php else: ?>", $content);
        $content = preg_replace("/{$ld}\/if{$rd}/", "<?php endif; ?>", $content);

        // foreach
        $content = preg_replace("/{$ld}foreach\s+(.*?)\s+as\s+(.*?){$rd}/", "<?php foreach ($1 as $2): ?>", $content);
        $content = preg_replace("/{$ld}\/foreach{$rd}/", "<?php endforeach; ?>", $content);

        // block（在 extends 時處理）
        $content = preg_replace("/{$ld}block\s+\"([^\"]+)\"{$rd}/", '', $content);
        $content = preg_replace("/{$ld}\/block{$rd}/", '', $content);

        // 變數與過濾器
        $content = preg_replace_callback("/{$ld}\s*(\\$[\w][\w\.\->\[\]']*)(\|\w+)?\s*{$rd}/", function ($m) {
            $expr = $m[1]; // 變數本體
            $filter = ltrim($m[2] ?? '|htmlspecialchars', '|');

            // 轉換點記法：$obj.prop1.prop2 -> $obj['prop1']['prop2']
            if (strpos($expr, '.') !== false && strpos($expr, '->') === false) {
                $expr = preg_replace_callback('/(\\$[\w]+)((?:\.[\w]+)+)/', function ($mm) {
                    $base = $mm[1];
                    $props = explode('.', trim($mm[2], '.'));
                    foreach ($props as $p) {
                        $base .= "['$p']";
                    }
                    return $base;
                }, $expr);
            }

            // 若是 $obj->title，則保持不變

            if (!isset($this->filters[$filter])) {
                return "<?= $expr ?>";
            }

            if ($filter === 'raw') {
                return "<?= $expr ?>";  // 直接輸出，不套用 htmlspecialchars
            }

            return "<?php echo call_user_func(\$this->filters['$filter'], $expr); ?>";
        }, $content);

        return $content;
    }
}
