<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RESTful API 測試 Codeigniter 4 CRUD Tutorial</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .form-group { margin-bottom: 10px; }
    #item-list { margin-top: 20px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>

<body>
<div class="container mt-4">
    <div class="d-flex justify-content-end">
        <a href="<?php echo site_url('/emp/new') ?>" class="btn btn-success mb-2">Add Employee</a>
    </div>
    <?php
     if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
      }
     ?>
  <div class="mt-3">
     <table class="table table-bordered">
       <thead>
          <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th></th>
          </tr>
       </thead>
       <tbody id="dataList"></tbody>
     </table>
  </div>
</div>
<script>

const API_URL = '<?= site_url('/employee') ?>'; // 替換為你的 API 基礎 URL

// 取得所有項目
async function fetchItems() {
  try {
    const response = await fetch(API_URL);
    if (!response.ok) throw new Error('無法取得員工資料');
    const result = await response.json();
    const items = result.employee;

    // console.log(items);

    const dataList = document.getElementById('dataList');
    const itemList = document.getElementById('item-list');
    // itemList.innerHTML = '<h3>員工列表</h3>';
    if (!Array.isArray(items)) {
      throw new Error('API 回應的 employee 不是陣列');
    }
    if (items.length === 0) {
      itemList.innerHTML += '<p>無員工資料</p>';
      return;
    }

    let dataHtml = '';
    let table = '<table><tr><th>ID</th><th>名稱</th><th>信箱</th><th>操作</th></tr>';
    items.forEach(item => {
        dataHtml += `
          <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.email}</td>
            <td>
              <a href="<?= base_url('emp/edit/') ?>${item.id}" class="btn btn-primary btn-sm">Edit</a>
              <a href="javascript:deleteEmployee(${item.id});" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>`;

        table += `
          <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.email}</td>
            <td>
              <button onclick="editEmployee(${item.id}, '${item.name}', '${item.email}')">編輯</button>
              <button onclick="deleteEmployee(${item.id})">刪除</button>
            </td>
          </tr>`;
    });
    table += '</table>';
    // itemList.innerHTML += table;
    dataList.innerHTML = dataHtml;
  } catch (error) {
    alert('錯誤: ' + error.message);
  }
}

// 新增或更新項目
async function createOrUpdateEmployee() {
  try {
    const id = document.getElementById('employee-id').value;
    const name = document.getElementById('employee-name').value;
    const email = document.getElementById('employee-email').value;
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/${id}` : API_URL;

    const response = await fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: name, email: email })
    });

    if (!response.ok) throw new Error('操作失敗');

    document.getElementById('employee-id').value = '';
    document.getElementById('employee-name').value = '';
    document.getElementById('employee-email').value = '';
    fetchItems();
  } catch (error) {
    alert('錯誤: ' + error.message);
  }
}

// 編輯項目
function editEmployee(id, name, email) {
  document.getElementById('employee-id').value = id;
  document.getElementById('employee-name').value = name;
  document.getElementById('employee-email').value = email;
}

// 刪除項目
async function deleteEmployee(id) {
  try {
    let result = confirm('Are you sure?');
    if (result) {
      const response = await fetch(`${API_URL}/${id}`, { method: 'DELETE', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      if (!response.ok) throw new Error('刪除失敗');
      fetchItems();
    }
  } catch (error) {
    alert('錯誤: ' + error.message);
  }
}

// 頁面載入時取得項目
fetchItems();

</script>

</body>
</html>
