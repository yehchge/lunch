<h2><?= esc($title) ?></h2>
<!-- ?= session()->getFlashdata('errors') ?-->
<?= validation_list_errors() ?>

<form action="<?= base_url('/news/create') ?>" method="post">
    <?= csrf_field() ?>

    <label for="title">Title</label>
    <input type="input" name="title" value="<?= set_value('title') ?>" >
    <br>
    (Ex: Tutorial Completed)<br>

    <label for="body">Text</label>
    <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>
    <br>
    (Ex: A developer in Spuuzzum reported that he successfully completed the CodeIgniter tutorial!)<br>

    <input type="submit" name="submit" value="Create news item">
</form>
