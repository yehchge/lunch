<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>RESTful API 測試 Codeigniter 4 : Add New Employee</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <form method="post" id="employee_add" name="employee_add">
      <div class="form-group">
        <label>Name</label>
        <input class="form-control" type="text" name="employee-name" id="employee-name">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input class="form-control" type="email" name="employee-email" id="employee-email">
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-block" onclick="createEmployee()">Store</button>
      </div>
    </form>
  </div>

<script>
const API_URL = '<?= site_url('/employee') ?>'; // 替換為你的 API 基礎 URL

async function createEmployee() {
  try {
      const id = 0;
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
      window.location.href = './';

  } catch (error) {
      alert('錯誤: ' + error.message);
  }
}

</script>
</body>
</html>
