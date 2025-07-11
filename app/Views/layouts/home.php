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

<form method="get" class="mb-3 row">
    <div class="col-auto">
        <input class="form-control" type="text" name="address" value="<?= esc($address) ?>" placeholder="請輸入地址關鍵字">
    </div>    
    <div class="col-auto">
        <label class="col-form-label">狀態：</label>
    </div>
    <div class="col-auto">
        <select class="form-select" name="status[]" size=3 multiple>
            <?php
            $statusOptions = [
                'active' => '啟用',
                'inactive' => '停用',
                'pending' => '待審'
            ];
            foreach ($statusOptions as $key => $label):
                $selected = (is_array($status) && in_array($key, $status)) ? 'selected' : '';
            ?>
                <option value="<?= $key ?>" <?= $selected ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div> 
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">搜尋</button>
    </div>
</form>


<h1 class="fw-bold">CodeIgniter 4 Pagination</h1>
<hr>
<div class="card rounded-0">
    <div class="card-body">
        <div class="container-fluid">
            <form class="mb-3 row" method="get" action="">
                <div class="col-auto">
                    <label class="col-form-label">每頁顯示：</label>
                </div>
                <div class="col-auto">
                    <select class="col-auto form-select" name="perPage" onchange="this.form.submit()">
                        <?php foreach ([5, 10, 15, 25, 50, 100] as $num): ?>
                            <option value="<?= $num ?>" <?= ($perPage == $num ? 'selected' : '') ?>><?= $num ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
                <div class="col-auto">
                    <label class="col-form-label">筆</label>
                </div>
            </form>
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr class="bg-gradient bg-primary text-light">
                        <th class="p-1 text-center"><?= sort_link('#', 'id', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Name', 'name', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Contact #', 'contact', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Email', 'email', $currentSort, $currentOrder, $perPage) ?></th>
                        <th class="p-1 text-center"><?= sort_link('Address', 'address', $currentSort, $currentOrder, $perPage) ?></th>
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
            <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
