<?php
    include('includes/header.php');
    if ( isset($_SESSION['user_data']) && isset($_SESSION['user_data']->client_login)  ){
        header('Location: orders.php');
    }
    $intance = new Client;
    $clients = $intance->allWithOutTrash();
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
    <div class="form-container left">
          <h2>Add Client Info </h2>
          <form action="queries/create_client.php" method="post">

            <label for="employee_id">Employee ID:</label>
            <input type="text" name="employee_id" id="employee_id" required>

            <label for="employee_name">Employee Name:</label>
            <input type="text" name="employee_name" id="employee_name" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" name="confirm-password" id="confirm-password" required>

            <label for="contact">Contact No:</label>
            <input type="text" name="contact" id="contact" required>

            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="product-container">
        <table border="1">
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $client['employee_id']; ?></td>
                <td><?= $client['name']; ?></td>
                <td><?= $client['contact']; ?></td>
                <td><?= $client['created_at']; ?></td>
                <td><?= $client['updated_at']; ?></td>
                <td>
                    <form action="queries/delete_client.php" method="post">
                        <input type="hidden" name="employee_id" value="<?= $client['id']; ?>">
                        <input style="background-color: red;" type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</section>





</body>
</html>