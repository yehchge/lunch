<!DOCTYPE html>
<html>
<head>
  <title>Codeigniter 4 : Update Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <form method="post" id="employee_update" name="employee_update">
        <input type="hidden" name="employee-id" id="employee-id">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="employee-name" id="employee-name">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="employee-email" id="employee-email">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-block" onclick="updateEmployee()">Update</button>
        </div>
    </form>
  </div>
<script>

const API_URL = '<?= site_url('/employee') ?>'; // 替換為你的 API 基礎 URL

function getParam() {
    const url = window.location.pathname; // 取得路徑部分: /ci460/emp/edit/10
    const segments = url.split('/'); // 分割成陣列: ["", "ci460", "emp", "edit", "10"]
    const id = segments[segments.length - 1]; // 取得最後一個元素: "10"
    console.log(id);
    return id;
}

async function fetchData() {
    try {
        const id = getParam();
        const response = await fetch(API_URL + '/' + id);
        if (!response.ok) throw new Error('無法取得員工資料');
        const result = await response.json();
        // const items = result.employee;
        console.log(result);
        console.log(result.id);
        console.log(result.name);
        console.log(result.email);
        document.getElementById('employee-id').value = result.id;
        document.getElementById('employee-name').value = result.name;
        document.getElementById('employee-email').value = result.email;
    } catch (error) {
        alert('錯誤: ' + error.message);
    }
}

async function updateEmployee() {
    try {
        const id = document.getElementById('employee-id').value;
        const name = document.getElementById('employee-name').value;
        const email = document.getElementById('employee-email').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_URL}/${id}` : API_URL;

        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ name: name, email: email })
        });

        if (!response.ok) throw new Error('操作失敗');

        window.location.href = '../';

    } catch (error) {
        alert('錯誤: ' + error.message);
    }
}



// 頁面載入時取得項目
fetchData();

</script>
</body>
</html>
