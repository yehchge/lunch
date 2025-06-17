Dashboard... Logged in only..

<br />

<form id="randomInsert" action="<?= base_url() ?>mvc/xhrInsert" method="post">
    <input type="hidden" id="csrf_code" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
    <input type="text" name="text" />
    <input type="submit" />
</form>

<br />

<div id="listInserts">

</div>
