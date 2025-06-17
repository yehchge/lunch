<h1>Note: Edit</h1>

<form method="post" action="<?= base_url() ?>mvc/note/editSave/<?= esc($note['noteid']) ?>">
    <?= csrf_field() ?>
    <label>Title</label><input type="text" name="title" value="<?= set_value('title', $note['title']) ?>" /><br />
    <label>Content</label><textarea name="content"><?= set_value('content', $note['content']) ?></textarea><br />
    <label>&nbsp;</label><input type="submit" />
</form>
