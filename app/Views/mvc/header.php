<!doctype html>
<html>
<head>
    <title><?=(isset($title)) ? esc($title) : 'MVC'; ?></title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/public/css/default.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/public/js/custom.js"></script>
    <?php
    if (isset($js))
    {
        foreach ($js as $myJs)
        {
            echo '<script type="text/javascript" src="'.base_url().$myJs.'"></script>';
        }
    }
    ?>
</head>
<body>

<!-- ?php Session::init(); ? -->

<div id="header">

    <?php if (session('loggedIn') == false ): ?>
        <a href="<?= base_url() ?>mvc/index">Index</a>
        <a href="<?= base_url() ?>mvc/help">Help</a>
    <?php endif; ?>
    <?php if (session('loggedIn') == true ): ?>
        <a href="<?= base_url() ?>mvc/dashboard">Dashborad</a>
        <a href="<?= base_url() ?>mvc/note">Notes</a>

        <?php if (session('role') == 'owner' ): ?>
        <a href="<?= base_url() ?>mvc/user">Users</a>
        <?php endif; ?>

        <a href="<?= base_url() ?>mvc/dashboard/logout">Logout</a>
    <?php else: ?>
        <a href="<?= base_url() ?>mvc/login">Login</a>
    <?php endif; ?>
</div>

<div id="content">
