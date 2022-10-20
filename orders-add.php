<?php
 
$servername = "localhost";
$username = "davyddov_davyddova";
$password = "dasha12345!";
$dbname = "davyddov_HW3";
$conn = new mysqli($servername, $username, $password, $dbname);
     
    // mysqli_connect("servername","username","password","database_name")
  
    // Get all the categories from category table
    $sql = "SELECT * FROM `Customer`";
    $all_categories = mysqli_query($con,$sql);
  
    // The following code checks if the submit button is clicked
    // and inserts the data in the database accordingly
    if(isset($_POST['submit']))
    {
        // Store the Product name in a "name" variable
        $name = mysqli_real_escape_string($con,$_POST['fname']);
        
        // Store the Category ID in a "id" variable
        $id = mysqli_real_escape_string($con,$_POST['customer_id']);
      
        $quantity = mysqli_real_escape_string($con,$_POST['quantity']);
        $pid = mysqli_real_escape_string($con,$_POST['product_id']);
        
        // Creating an insert query using SQL syntax and
        // storing it in a variable.
        $sql_insert =
        "INSERT INTO `orders`(`customer_id`, `product_id`, 'quantity', )
            VALUES ('$name','$id', '$quantity', '$pid')";
          
          // The following code attempts to execute the SQL query
          // if the query executes with no errors
          // a javascript alert message is displayed
          // which says the data is inserted successfully
          if(mysqli_query($con,$sql_insert))
        {
            echo '<script>alert("Order added successfully")</script>';
        }
    }
?>
