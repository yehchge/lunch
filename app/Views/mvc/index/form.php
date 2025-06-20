<form method="post" action="?run">
    <?= csrf_field() ?>
    Name <input type="text" name="name" />
    Age <input type="text" name="age" />
    Gender <select name="gender">
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select>
    <input type="submit" />
</form>
