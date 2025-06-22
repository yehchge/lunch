<!doctype html>
<html>
<head>
	<title>My Site</title>
</head>
<body>

<?php if (session('user_id') == false):?>

	<h1>Welcome Home</h1>

	<nav>
		<a href="<?=base_url().'tutorial/dashboard/login'?>">Login</a>
	</nav>

<?php elseif (session('is_admin') == true):?>

	<h1>Admin Panel</h1>

	<nav>
		Manage Users | <a href="<?=base_url().'tutorial/admin/logout'?>">Logout</a>
	</nav>

<?php else:?>

	<h1>User Dashboard</h1>

	<nav>
		<a href="<?=base_url().'tutorial/dashboard/home'?>">Dashboard</a> |
		<a href="<?=base_url().'tutorial/dashboard/account'?>">My Account</a> |
		<a href="<?=base_url().'tutorial/dashboard/logout'?>">Logout</a>
	</nav>

<?php endif;?>