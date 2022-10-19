

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cusotmer and Order Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <h1>Cusotmer and Order Information</h1>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Product ID</th>
      <th>Quantity</th>
      <th>Supplier ID</th>
      <th>Product Name</th>
    </tr>
  </thead>
  <tbody>
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
$iid = $_GET['id'];
//echo $iid;
$sql = "select o.order_id, p.product_id, o.quantity, p.supplier_id, p.pname from Customer c join Orders o on c.customer_id = o.customer_id join Product p on o.product_id = p.product_id where c.customer_id=?";
//echo $sql;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $iid);
    $stmt->execute();
    $result = $stmt->get_result();

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
?>
  <tr>
    <td><?=$row["order_id"]?></td>
    <td><?=$row["product_id"]?></td>
    <td><?=$row["quantity"]?></td>
    <td><?=$row["supplier_id"]?></td>
    <td><?=$row["pname"]?></td>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>
