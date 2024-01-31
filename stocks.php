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
        <span class="dashboard">Stocks</span>
      </div>
      
    </nav>
    <div class="container">
      <div class="form-container left">
        <h2>Update Stocks </h2>
        <form action="updateProduct.php" method="post" onsubmit="return confirmSubmit()">

            <label for="barcodeId">Barcode:</label>
            <input type="text" name="barcodeId" id="barcodeId" required>

            <label for="qty">Quantity:</label>
            <input type="number" id="qty" name="qty" min="1" required>
            <input type="submit" value="Update Stocks">
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

    </div>
    <?php


// Create connection
include("connection.php");

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
?>


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