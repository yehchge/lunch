<?php

// 全局輔助函數
function model($class) {
    global $container; // 假設容器是全局單例
    return $container->make($class);
}

function service(string $name)
{
    if (!class_exists('Services')) {
        require_once PATH_ROOT.'/app/Config/Services.php';
    }

    if(method_exists('Services', $name)) {
        return Services::$name();
    }

    throw new Exception("Service '$name' not found.");
}

function base_url($relativePath = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = rtrim(dirname($scriptName), '/');

    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($requestUri, PHP_URL_PATH);

    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST'].$basePath;

    return "$actual_link/".ltrim($relativePath, '/');
    // return $currentURI->baseUrl($relativePath);
}

function site_url($relativePath = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $basePath = rtrim(dirname($scriptName), '/');

    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($requestUri, PHP_URL_PATH);

    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://".$_SERVER['HTTP_HOST'].$basePath;

    return "$actual_link/".ltrim($relativePath, '/');
    // return $currentURI->baseUrl($relativePath);
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
        $action = (string) current_url(true);
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

    $form = '<form action="' . $action . '"' . $attributes . ">\n";

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


/**
 * Generates a hidden input field for use within manually generated forms.
 *
 * @param non-empty-string|null $id
 */
function csrf_field(?string $id = null): string
{
    return '<input type="hidden"' . ($id !== null ? ' id="' . esc($id, 'attr') . '"' : '') . ' name="' . csrf_token() . '" value="' . csrf_hash() . '">';
}

/**
 * Returns the CSRF token name.
 * Can be used in Views when building hidden inputs manually,
 * or used in javascript vars when using APIs.
 */
function csrf_token(): string
{
    return 'csrf_test_name';
    // return service('security')->getTokenName();
}

/**
 * Returns the current hash value for the CSRF protection.
 * Can be used in Views when building hidden inputs manually,
 * or used in javascript vars for API usage.
 */
function csrf_hash(): string
{
    return getHash();
    // return service('security')->getHash();
}


/**
 * Returns the CSRF Token.
 */
function getHash(): ?string
{
    // restoreHash();
    // generateHash();

    return bin2hex(random_bytes(16));
    // return $this->config->tokenRandomize ? randomize($this->hash) : $this->hash;
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

/**
     * Restore hash from Session or Cookie
 */
function restoreHash(): void
{
    if ($this->isCSRFCookie()) {
        if ($this->isHashInCookie()) {
            $this->hash = $this->hashInCookie;
        }
    } elseif ($this->session->has($this->config->tokenName)) {
        // Session based CSRF protection
        $this->hash = $this->session->get($this->config->tokenName);
    }
}

/**
 * Generates (Regenerates) the CSRF Hash.
 */
function generateHash(): string
{
    $this->hash = bin2hex(random_bytes(16));

    if ($this->isCSRFCookie()) {
        $this->saveHashInCookie();
    } else {
        // Session based CSRF protection
        $this->saveHashInSession();
    }

    return $this->hash;
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
