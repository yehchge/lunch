
<h1>Login</h1>

<p>Hint: admin@admin.com / admin</p>

<form action="<?=base_url().'tutorial/admin/login/submit' ?>" method="post">
	<?= csrf_field() ?>
	Email: <input type="email" name="email">
	Password: <input type="password" name="password">
	<input type="submit">
</form>
