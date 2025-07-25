<?php

session_start();

use App\Config\Services;
use App\Security\CsrfFilter;
use App\System\Session;
use App\System\Redirect;

function redirect(): Redirect
{
    return new Redirect();
}

function session($name = '')
{
    if ($name) {
        $session = Session::getInstance();
        return $session->get($name) ?? '';
    }
    return Session::getInstance();
}

// 全局輔助函數
function model($class)
{
    global $container; // 假設容器是全局單例
    return $container->make($class);
}

function service(string $name)
{
    if (!class_exists('Services')) {
        include_once PATH_ROOT.'/app/Config/Services.php';
    }

    if(method_exists("App\\Config\\Services", $name)) {
        return Services::$name();
    }

    throw new \Exception("Service '$name' not found.");
}

function base_url($relativePath = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = rtrim(dirname($scriptName), '/');

    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST'].$basePath;

    return "$actual_link/".ltrim($relativePath, '/');
}

function site_url($relativePath = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = rtrim(dirname($scriptName), '/');

    // $requestUri = $_SERVER['REQUEST_URI'] ?? '';

    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST'].$basePath;

    return "$actual_link/".ltrim($relativePath, '/');
}


/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string
 * as the word separator.
 *
 * @param string $str       Input string
 * @param string $separator Word separator (usually '-' or '_')
 * @param bool   $lowercase Whether to transform the output string to lowercase
 */
function url_title(string $str, string $separator = '-', bool $lowercase = false): string
{
    $qSeparator = preg_quote($separator, '#');

    $trans = [
        '&.+?;'                  => '',
        '[^\w\d\pL\pM _-]'       => '',
        '\s+'                    => $separator,
        '(' . $qSeparator . ')+' => $separator,
    ];

    $str = strip_tags($str);

    foreach ($trans as $key => $val) {
        $str = preg_replace('#' . $key . '#iu', $val, $str);
    }

    if ($lowercase) {
        $str = mb_strtolower($str);
    }

    return trim(trim($str, $separator));
}

/**
 * Form Declaration - Multipart type
 *
 * Creates the opening portion of the form, but with "multipart/form-data".
 *
 * @param string       $action     The URI segments of the form destination
 * @param array|string $attributes A key/value pair of attributes, or the same as a string
 * @param array        $hidden     A key/value pair hidden data
 */
function form_open_multipart(string $action = '', $attributes = [], array $hidden = []): string
{
    if (is_string($attributes)) {
        $attributes .= ' enctype="' . esc('multipart/form-data') . '"';
    } else {
        $attributes['enctype'] = 'multipart/form-data';
    }

    return form_open($action, $attributes, $hidden);
}

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @param string       $action     the URI segments of the form destination
 * @param array|string $attributes a key/value pair of attributes, or string representation
 * @param array        $hidden     a key/value pair hidden data
 */
function form_open(string $action = '', $attributes = [], array $hidden = []): string
{
    // If no action is provided then set to the current url
    if ($action === '') {
        // $action = (string) current_url(true);
    } // If an action is not a full URL then turn it into one
    elseif (! str_contains($action, '://')) {
        // If an action has {locale}
        if (str_contains($action, '{locale}')) {
            $action = str_replace('{locale}', service('request')->getLocale(), $action);
        }

        $action = site_url($action);
    }

    if (is_array($attributes) && array_key_exists('csrf_id', $attributes)) {
        $csrfId = $attributes['csrf_id'];
        unset($attributes['csrf_id']);
    }

    $attributes = stringify_attributes($attributes);

    if (! str_contains(strtolower($attributes), 'method=')) {
        $attributes .= ' method="post"';
    }
    if (! str_contains(strtolower($attributes), 'accept-charset=')) {
        // $config = config(App::class);
        $attributes .= ' accept-charset="' . strtolower('utf-8') . '"';
    }

    if ($action) {
        $form = '<form action="' . $action . '"' . $attributes . ">\n";
    } else {
        $form = '<form ' . $attributes . ">\n";       
    }

    // Add CSRF field if enabled, but leave it out for GET requests and requests to external websites
    // $before = service('filters')->getFilters()['before'];

    $before = [];

    if ((in_array('csrf', $before, true) || array_key_exists('csrf', $before)) && str_contains($action, base_url()) && ! str_contains(strtolower($form), strtolower('method="get"'))) {
        $form .= csrf_field($csrfId ?? null);
    }

    foreach ($hidden as $name => $value) {
        $form .= form_hidden($name, $value);
    }

    return $form;
}

function form_hidden($name, $value) {
    return "<input type='hidden' name='$name' id='$name' value='$value'>";
}


/**
 * Stringify attributes for use in HTML tags.
 *
 * Helper function used to convert a string, array, or object
 * of attributes to a string.
 *
 * @param array|object|string $attributes string, array, object that can be cast to array
 */
function stringify_attributes($attributes, bool $js = false): string
{
    $atts = '';

    if ($attributes === '' || $attributes === [] || $attributes === null) {
        return $atts;
    }

    if (is_string($attributes)) {
        return ' ' . $attributes;
    }

    $attributes = (array) $attributes;

    foreach ($attributes as $key => $val) {
        $atts .= ($js) ? $key . '=' . esc($val, 'js') . ',' : ' ' . $key . '="' . esc($val) . '"';
    }

    return rtrim($atts, ',');
}

// 產生 CSRF 隱藏輸入欄位
function csrf_field()
{
    $request = service('request');
    $CsrfFilter = new CsrfFilter();
    $token_name = $CsrfFilter->getTokenName();

    $token = $CsrfFilter->generateCsrfToken($request);

    return '<input type="hidden" name="'.$token_name.'" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

// 驗證 CSRF token
function verifyCsrfToken($token, $max_age = 3600)
{
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time'])) {
        return false;
    }
    
    // 檢查 token 是否匹配
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        return false;
    }
    
    // 檢查 token 是否過期
    if ((time() - $_SESSION['csrf_token_time']) > $max_age) {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return false;
    }
    
    return true;
}

/**
 * Returns the CSRF token name.
 * Can be used in Views when building hidden inputs manually,
 * or used in javascript vars when using APIs.
 */
function csrf_token(): string
{
    $CsrfFilter = new CsrfFilter();
    return $CsrfFilter->getTokenName();
    // return service('security')->getTokenName();
}

/**
 * Returns the current hash value for the CSRF protection.
 * Can be used in Views when building hidden inputs manually,
 * or used in javascript vars for API usage.
 */
function csrf_hash(): string
{
    $request = service('request');
    $CsrfFilter = new CsrfFilter();
    $token = $CsrfFilter->generateCsrfToken($request);

    return htmlspecialchars($token, ENT_QUOTES, 'UTF-8');
    // return service('security')->getHash();
}

/**
 * Returns the CSRF Token.
 */
function getHash(): ?string
{
    return bin2hex(random_bytes(16));
}

/**
 * Randomize hash to avoid BREACH attacks.
 *
 * @params string $hash CSRF hash
 *
 * @return string CSRF token
 */
function randomize(string $hash): string
{
    $keyBinary  = random_bytes(16);
    $hashBinary = hex2bin($hash);

    if ($hashBinary === false) {
        throw new LogicException('$hash is invalid: ' . $hash);
    }

    return bin2hex(($hashBinary ^ $keyBinary) . $keyBinary);
}

function anchor($uri = '', string $title = ''): string
{
    $siteUrl = is_array($uri) ? site_url($uri) : (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri));
    // eliminate trailing slash
    $siteUrl = rtrim($siteUrl, '/');

    if ($title === '') {
        $title = $siteUrl;
    }

    return '<a href="' . $siteUrl . '"' . '>' . $title . '</a>';
}

function validation_list_errors()
{
    $errors = session()->getFlashdata('errors');

    $data = explode('<br>', $errors);

    $result = '<ul>';

    foreach ($data as $val) {
        if(!$val) continue;
        $result .= "<li>$val</li>";
    }

    $result .= '</ul>';
    echo $result;
}

/**
 * Form Value
 *
 * Grabs a value from the POST array for the specified field so you can
 * re-populate an input field or textarea
 *
 * @param string              $field      Field name
 * @param list<string>|string $default    Default value
 * @param bool                $htmlEscape Whether to escape HTML special characters or not
 *
 * @return list<string>|string
 */
function set_value(string $field, $default = '', bool $htmlEscape = true)
{
    $request = service('request');

    // Try any old input data we may have first
    $value = $request->getOldInput($field);

    if ($value === null) {
        $value = $request->getPost($field) ?? $default;
    }

    return ($htmlEscape) ? esc($value) : $value;
}
