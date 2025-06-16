<h1>Login</h1>

<form action="<?= base_url() ?>mvc/login/run" method="post">
    <?= csrf_field() ?>
    <label>Login</label><input type="text" name="login" /><br />
    <label>Password</label><input type="password" name="password" /><br />
    <label><input type="checkbox" name="remember" />Remember Me</label><br />
    <label></label>Hint: demo / demo
    <label></label><input type="submit" />
</form>
