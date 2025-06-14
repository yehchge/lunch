<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
// 取得目前排序欄位與方向
$currentSort = service('request')->getGet('sort') ?? 'id';
$currentOrder = service('request')->getGet('order') ?? 'asc';

// 切換升冪/降冪
function sort_link($label, $field, $currentSort, $currentOrder, $perPage)
{
    $newOrder = ($currentSort === $field && $currentOrder === 'asc') ? 'desc' : 'asc';
    $arrow = '';
    if ($currentSort === $field) {
        $arrow = $currentOrder === 'asc' ? ' ▲' : ' ▼';
    }
    return '<a href="?sort=' . $field . '&order=' . $newOrder . '&perPage=' . $perPage . '">' . $label . $arrow . '</a>';
}
?>


<h1 class="fw-bold">CodeIgniter 4 Pagination</h1>
<hr>
<div class="card rounded-0">
    <div class="card-body">
        <div class="container-fluid">
            <form method="get" action="">
                每頁顯示：
                <select name="perPage" onchange="this.form.submit()">
                    <?php foreach ([5, 10, 15, 25, 50, 100] as $num): ?>
                        <option value="<?= $num ?>" <?= ($perPage == $num ? 'selected' : '') ?>><?= $num ?></option>
                    <?php endforeach; ?>
                </select> 筆
            </form>
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr class="bg-gradient bg-primary text-light">
                        <th class="p-1 text-center"><?= sort_link('#', 'id', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Name', 'name', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Contact #', 'contact', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Email', 'email', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Address', 'address', $currentSort, $currentOrder, $perPage) ?></th>
<!--                         <th class="p-1 text-center">#</th>
                        <th class="p-1 text-center">Name</th>
                        <th class="p-1 text-center">Contact #</th>
                        <th class="p-1 text-center">Email</th>
                        <th class="p-1 text-center">Address</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $row): ?>
                        <tr>
                            <td class="px-2 py-1 text-center align-middle"><?= $row['id'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['contact'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['email'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['address'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->makeLinks($page, $perPage, $total, 'custom_view', 0) ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
