<?php

use App\System\JavaScript;

class AuthMvcUser
{
    public function handle()
    {
        $session = session();

        $logged = $session->get('loggedIn');
        if ($logged == false) {
            $session->destroy();
            return JavaScript::redirect(base_url().'mvc/login');
        }
    }
}
