<?php
    include('includes/header.php');
    if ( isset($_SESSION['user_data']) && isset($_SESSION['user_data']->client_login)  ){
      header('Location: orders.php');
  }
?>

<body>

<?php include('includes/sidebar.php'); ?>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add Product</span>
      </div>
      
    </nav>
    <div class="container">
      <div class="form-container left">
          <h2>Add Supply </h2>
          <form action="addProduct.php" method="post"  onsubmit="return confirmSubmit()">
            <label for="barcodeId">Barcode:</label>
            <input type="text" name="barcodeId" id="barcodeId" required>

            <label for="productName">Product Name:</label>
            <input type="text" name="productName" id="productName" required>

            <label for="productGroup">Product Group:</label>
            <input type="text" name="productGroup" id="productGroup" required>

            <label for="qty">Quantity:</label>
            <input type="number" name="qty" id="qty" required>

            <input type="submit" value="Add Product">
        </form>
      </div>

      <script>
      function confirmSubmit() {
          var r = confirm("Are you sure you want to submit?");
          if (r == true) {
              return true;
          } else {
              return false;
          }
    }
    </script>


      <div class="product-container">
        <h2>Product Information</h2>
<?php

// Create connection
    // $conn = new mysqli("localhost", "root", "admin", "inventory"); //localDatabase
    $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
// Fetch update history
$sql = "SELECT barcodeId, productName, productGroup, qty ,created_at FROM product ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch data and store in an associative array
    while ($row = $result->fetch_assoc()) {
        $updateProduct[] = $row;
    }
}
?><?php if (!empty($updateProduct)): ?>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Group</th>
                <th>Quantity</th>
                <th>Date Created</th>
            </tr>
            <?php foreach ($updateProduct as $update): ?>
                <tr>
                    <td><?php echo $update['barcodeId']; ?></td>
                    <td><?php echo $update['productName']; ?></td>
                    <td><?php echo $update['productGroup']; ?></td>
                    <td><?php echo $update['qty']; ?></td>
                    <td><?php echo $update['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No product list available.</p>
    <?php endif; ?>
    
        <br>
    
    </div> 
     
  </div>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}

 </script>

</body>
</html>