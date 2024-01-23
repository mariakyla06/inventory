<?php
    include('includes/header.php');

    $adminLogin = isset($_SESSION['user_data']) && !isset($_SESSION['user_data']->client_login);
    $id = $adminLogin ? $_SESSION['user_data']['id'] : $_SESSION['user_data']->id;
    $intance = new Order;
    $orders = $intance->getApprovedOrders()
?>

<body>

<?php include('includes/sidebar.php'); ?>

<section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add Clients</span>
      </div>
    </nav>

<div class="container">
        <table border="1">
            <tr>
                <th>Product</th>
                <th>Ordered Quantity</th>
                <th>Office</th>
                <th>Ordered By</th>
                <th>Remarks</th>
                <th>Status</th>
                <?php
                    if ( $adminLogin ){
                ?>
                <th>Action</th>
                <?php
                    }
                ?>

            </tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= ucwords($order['product_name']) ?></td>
                <td><?= $order['quantity']; ?></td>
                <td><?= $order['office']; ?></td>
                <td><?= ucwords($order['ordered_by_name']) ?></td>
                <td><?= $order['remarks']; ?></td>
                <td><?= ucfirst(strtolower($order['status']));?></td>


                <?php
                    if ( $adminLogin ){
                ?>
                    <td>
                        <?php 
                            if( $order['status'] == 'APPROVED' ){
                        ?>
                            <form action="queries/update_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <input type="hidden" name="product_id" value="<?= $order['product_id']; ?>">
                                <input type="hidden" name="ordered_quantity" value="<?= $order['quantity']; ?>">
                                <input type="hidden" name="status" value="CLAIMED">
                                <input style="background-color: #0197CB;" type="submit" value="CLAIMED">
                            </form>
                        <?php
                            }
                        ?>
                    </td>
                <?php
                    }
                ?>  
            </tr>
            <?php endforeach; ?>
        </table>

</div>
</section>




</body>
</html>