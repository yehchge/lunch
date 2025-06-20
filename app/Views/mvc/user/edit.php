<h1>User: Edit</h1>

<?php
print_r($user);

?>


<form method="post" action="<?= base_url() ?>mvc/user/editSave/<?php echo $user['userid']; ?>">
    <?= csrf_field() ?>
    <label>Login</label><input type="text" name="login" value="<?php echo $user['login']; ?>" /><br />
    <label>Password</label><input type="text" name="password" /><br />
    <label>Role</label>
        <select name="role">
            <option value="default" <?php if ($user['role'] == 'default') {
    echo 'selected';
} ?>>Default</option>
            <option value="admin" <?php if ($user['role'] == 'admin') {
    echo 'selected';
} ?>>Admin</option>
            <option value="owner" <?php if ($user['role'] == 'owner') {
    echo 'selected';
} ?>>Owner</option>
        </select><br />
    <label>&nbsp;</label><input type="submit" />
</form>
