<?php

namespace App\Filters;

use App\System\JavaScript;

class AuthMvcUser
{
    public function handle()
    {
        $session = session();

        $logged = $session->get('loggedIn');
        if ($logged == false) {
            $session->destroy();
            return JavaScript::redirectTo(base_url().'mvc/login');
        }
    }
}
