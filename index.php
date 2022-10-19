
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
      $sqlAdd = "insert into Customer (fname) value (?)";
      $stmtAdd = $conn->prepare($sqlAdd);
      $stmtAdd->bind_param("s", $_POST['iName']);
      $stmtAdd->execute();
      echo '<div class="alert alert-success" role="alert">New customer added.</div>';
      break;
    case 'Edit':
      $sqlEdit = "update Customer set fname=? where customer_id=?";
      $stmtEdit = $conn->prepare($sqlEdit);
      $stmtEdit->bind_param("si", $_POST['iName'], $_POST['iid']);
      $stmtEdit->execute();
      echo '<div class="alert alert-success" role="alert">Customer edited.</div>';
      break;
    case 'Delete':
      $sqlDelete = "delete from Customer where customer_id=?";
      $stmtDelete = $conn->prepare($sqlDelete);
      $stmtDelete->bind_param("i", $_POST['iid']);
      $stmtDelete->execute();
      echo '<div class="alert alert-success" role="alert">Customer deleted.</div>';
      break;
  }
}
?>
    
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          
<?php
$sql = "SELECT customer_id, fname from Customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
          
          <tr>
            <td><?=$row["customer_id"]?></td>
            <td><a href="customer-orders.php?id=<?=$row["customer_id"]?>"><?=$row["fname"]?></a></td>
            <td>
              <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editCustomer<?=$row["customer_id"]?>">
                Edit
              </button>
              <div class="modal fade" id="editCustomer<?=$row["customer_id"]?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCustomer<?=$row["customer_id"]?>Label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="editCustomer<?=$row["customer_id"]?>Label">Edit Customer</h1>
                        <select class="form-select" aria-label="Select Customer" id="customerslist" name="iid">
                  <?php
                   $customerSql = "select * from Customer order by fname";
                   $customerResult = $conn->query($customerSql);
                   while($customerRow = $customerResult->fetch_assoc()) {
                   if ($customerRow['customer_id'] == $row['customer_id']) {
                   $selText = " selected";
                   } else {
                   $selText = "";
                   }
                   ?> 
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="">
                        <div class="mb-3">
                          <label for="editCustomer<?=$row["customer_id"]?>Name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="editCustomer<?=$row["customer_id"]?>Name" aria-describedby="editCustomer<?=$row["customer_id"]?>Help" name="iName" value="<?=$row['fname']?>">
                          <div id="editCustomer<?=$row["customer_id"]?>Help" class="form-text">Enter the customer's first name.</div>
                        </div>
                        <input type="hidden" name="iid" value="<?=$row['customer_id']?>">
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
                <input type="hidden" name="iid" value="<?=$row["customer_id"]?>" />
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
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomer">
        Add New
      </button>

      <!-- Modal -->
      <div class="modal fade" id="addCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="addCustomerLabel">Add Customer</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="">
                <div class="mb-3">
                  <label for="customername" class="form-label">Name</label>
                  <input type="text" class="form-control" id="customerName" aria-describedby="nameHelp" name="iName">
                  <div id="nameHelp" class="form-text">Enter the customer's name.</div>
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
