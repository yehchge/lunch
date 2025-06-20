
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
            return JavaScript::redirect(base_url().'mvc/login');
        }


        $role = $session->get('role');
        if ($role != 'owner') {
            return JavaScript::redirect(base_url().'mvc/dashboard');
        }

    }
}
