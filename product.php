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
                <span class="dashboard">Product History</span>
            </div>
        </nav>

        <div class="product-content"> 
                <div class="input-box">
                <form action="#" method="post">
                    <i class="uil uil-search"></i>
                        <input type="text" id="search" name="search" placeholder="BARCODE ID SCAN..." />
                        <button type="submit" class="button">Search</button>
                        </form>
                </div>
            
                
            </div>
                        <?php

                        // $conn = new mysqli("localhost", "root", "admin", "inventory"); //localDatabase
                        $conn = new mysqli("localhost", "u542620504_supplyimsAdmin", "Supplyinformationsystem@2024", "u542620504_supplyims"); //devsiteDatabase

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Search functionality
                        // Search functionality
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT barcodeId, productName, productGroup, qty, created_at, updated_at FROM product WHERE barcodeId = $search ORDER BY created_at DESC";
} else {
    $sql = "SELECT barcodeId, productName, productGroup, qty, created_at, updated_at FROM product ORDER BY created_at DESC";
}

$result = $conn->query($sql);

                        // Check if there are results
                        if ($result->num_rows > 0) {
                            // Fetch data and store in an associative array
                            while ($row = $result->fetch_assoc()) {
                                $updateProduct[] = $row;
                            }
                            ?>
                            <!-- HTML and PHP for displaying the products -->
                            <table>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Product Group</th>
                                    <th>Quantity</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                </tr>
                                <?php foreach ($updateProduct as $update) : ?>
                                    <tr>
                                        <td><?= $update['barcodeId']; ?></td>
                                        <td><?= ucwords($update['productName']); ?></td>
                                        <td><?= ucwords($update['productGroup']); ?></td>
                                        <td><?= $update['qty']; ?></td>
                                        <td><?= $update['created_at']; ?></td>
                                        <td><?= $update['updated_at']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php } else { ?>
                            <p>No product list available.</p>
                        <?php } ?>
                    

    
                
            </div>
        </div>
    </section>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function() {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else
                sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
    </script>
</body>

</html>