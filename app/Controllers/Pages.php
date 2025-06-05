<?php

class Pages
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view(string $page = 'home')
    {
        $controllerFile = PATH_ROOT."/app/Views/pages/{$page}.php";
        if (!file_exists($controllerFile)){
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }

}
