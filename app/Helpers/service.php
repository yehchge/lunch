<?php

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
