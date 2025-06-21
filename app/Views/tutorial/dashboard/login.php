
Login

<form action="<?=base_url().'tutorial/dashboard/login/submit' ?>" method="post">
	<?=csrf_field()?>
	Email: <input type="text" name="email" />
	Password: <input type="password" name="password" />
	<input type="submit" />
</form>

