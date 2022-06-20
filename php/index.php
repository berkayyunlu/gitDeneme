<?php
include 'autoload.php';

$users = userAllData($conn);
?>




<html>

<head>
  <meta charset="UTF-8">
  <title>PHP Code to Retrieve Data from MySQL Database and Display in html Table</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>


<body>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
          <h2>Fetch Data From Database in PHP and Display in HTML Table</h2>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Full Name</th>
              <th scope="col">Email</th>
              <th scope="col">Age</th>
              <th scope="col">Telephone Number</th>
              <th scope="col">Address</th>
              <th scope="col">Work Type</th>
              <th scope="col" width="100" <td align="center">Update</td>
              <td align="center"><a href="insert.php"><button>Create </button></td></a>

              </th>
          </thead>

          <tbody>
            <?php
            foreach ($users as $key => $user) {
            ?>
              <tr>
                <th scope="row"><?php echo $user['id'] ?></th>
                <td><?php echo $user['full_name'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td><?php echo $user['age'] ?></td>
                <td><?php echo $user['phone'] ?></td>
                <td><?php echo $user['address'] ?></td>

                <td><?php echo $user['type_name'] ?></td>
                <td align="center"><a href="edit.php?id=<?php echo $user['id'] ?>"><button>Edit </button></td></a>
                <td align="center"><a href="dataModel.php?id=<?php echo $user['id'] ?>&deleteinf=ok" "><button>Delete </button></td></a> 
             

            </tr>
         <?php
            }
            // selectGetTable($conn,'userInf');
          ?>
          </tbody>
        </table>
      </div>
      <div class=" col-md-12">
                    <select name="user_type_id" required>
                      <?php
                      foreach ($users as $key => $user) {
                      ?>
                        <option value='<?php echo $user['id'] ?>'><?php echo $user['full_name'] ?></option>
                      <?php
                      }
                      ?>
                    </select>
      </div>
    </div>
  </div>
</body>

</html>