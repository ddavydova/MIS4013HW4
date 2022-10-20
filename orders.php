
<!doctype html>
<html lang="en">
 <?php include("header.php");?>
  <body>
  <?php include("links.php");?>
    <div class="container">
      
<?php
$servername = "localhost";
$username = "davyddov_davyddova";
$password = "dasha12345!";
$dbname = "davyddov_HW3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  switch ($_POST['saveType']) {
    case 'Add':
      $sqlAdd = "insert into Orders (quantity) value (?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("s", $_POST['iName']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New quantity added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update Orders set quantity=? where order_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("si", $_POST['iName'], $_POST['iid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Order edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from Orders where order_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['iid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Order deleted.</div>';
      break;
  }
}
     ?>
    
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Quantity</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT order_id, quantity from Orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["order_id"]?></td>
            <td><?=$row["quantity"]?></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editOrders<?=$row["order_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editOrders<?=$row["order_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editOrders<?=$row["order_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editOrders<?=$row["order_id"]?>Label">Edit Order</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="order-edit.php">
                        <div class="mb-3">
                          <label for="editOrders<?=$row["order_id"]?>Name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="editOrders<?=$row["order_id"]?>Name" aria-describedby="editOrders<?=$row["order_id"]?>Help" name="iName" value="<?=$row['quantity']?>">
                          <div id="editOrders<?=$row["order_id"]?>Help" class="form-text">Enter the quantity.</div>
                        </div>
                        <input type="hidden" name="iid" value="<?=$row['order_id']?>">
                        <input type="hidden" name="saveType" value="Edit">
                        <input type="submit" class="btn btn-primary" value="Submit">
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
             <form method="post" action="">
                <input type="hidden" name="iid" value="<?=$row["order_id"]?>" />
                <input type="hidden" name="saveType" value="Delete">
                <input type="submit" class="btn" onclick="return confirm('Are you sure?')" value="Delete">
              </form>
            </td>
          </tr>
          
<?php
  }
} else {
  echo "0 results";
}
$conn->close();
?>
          
        </tbody>
      </table>
      <br />
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrders">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addOrders" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addOrdersLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addOrdersLabel">Add Order</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <form method="post" action="">
                <div class="mb-3">
                  <label for="ordersname" class="form-label">Order</label>
                  <input type="text" class="form-control" id="ordersname" aria-describedby="nameHelp" name="iName">
                  <div id="nameHelp" class="form-text">Enter the order's quantity.</div>
                </div>
                <input type="hidden" name="saveType" value="Add">
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <?php include("footer.php");?>
  </body>
</html>
