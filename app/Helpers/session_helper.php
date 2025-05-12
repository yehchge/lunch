<?php

function session()
{
    require_once PATH_ROOT."/app/System/Session.php";
    return Session::getInstance();
}
