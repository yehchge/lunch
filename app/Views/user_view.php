<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Codeigniter 4 Pagination Example - positronx.io</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

  <style type="text/css">
  a {
     padding-left: 5px;
     padding-right: 5px;
     margin-left: 5px;
     margin-right: 5px;
  }
  .pagination li.active{
    background: deepskyblue;
      color: white;
  }
  .pagination li.active a{
    color: white;
    text-decoration: none;
  }
  </style>

</head>
<body>
  <div class="container mt-5">
    <div class="mt-3">

      <table class="table table-bordered" id="users-list">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>City</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($users as $user){
            echo "<tr>";
            echo "<td>".$user['id']."</td>";
            echo "<td>".$user['name']."</td>";
            echo "<td>".$user['email']."</td>";
            echo "<td>".$user['city']."</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-end">
          <?= $pager->links() ?>
      </div>

    </div>
  </div>
</body>
</html>
