
<?php

use App\System\JavaScript;

class AuthMvcOwner
{
    public function handle()
    {
        $session = session();

        $logged = $session->get('loggedIn');
        if ($logged == false) {
            $session->destroy();
            return JavaScript::redirectTo(base_url().'mvc/login');
        }


        $role = $session->get('role');
        if ($role != 'owner') {
            return JavaScript::redirectTo(base_url().'mvc/dashboard');
        }

    }
}
