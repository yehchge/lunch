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
