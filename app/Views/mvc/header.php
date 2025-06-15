<!doctype html>
<html>
<head>
	<title><?=(isset($this->title)) ? $this->title : 'MVC'; ?></title>
	<link rel="stylesheet" href="<?= base_url() ?>assets/public/css/default.css" />
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>assets/public/js/custom.js"></script>
	<?php
	if (isset($this->js)) 
	{
		foreach ($this->js as $js)
		{
			echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
		}
	}
	?>
</head>
<body>

<!-- ?php Session::init(); ? -->

<div id="header">	

	

	<?php if (Session::get('loggedIn') == false ): ?>
		<a href="<?php echo URL; ?>index">Index</a>
		<a href="<?php echo URL; ?>help">Help</a>
	<?php endif; ?>	
	<?php if (Session::get('loggedIn') == true ): ?>
		<a href="<?php echo URL; ?>dashboard">Dashborad</a>
		<a href="<?php echo URL; ?>note">Notes</a>
		
		<?php if (Session::get('role') == 'owner' ): ?>
		<a href="<?php echo URL; ?>user">Users</a>
		<?php endif; ?>
		
		<a href="<?php echo URL; ?>dashboard/logout">Logout</a>
	<?php else: ?>	
		<a href="<?php echo URL; ?>login">Login</a>
	<?php endif; ?>	
</div>

<div id="content">