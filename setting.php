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
        <span class="dashboard">Setting</span>
      </div>
      
    </nav>

    <div class="home-content">
      <div class="form-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
          <label for="username">Username</label>
          <input placeholder="username" type="text" id="username" name="username" required/>

          <label for="email">Email</label>
          <input placeholder="email" type="mail" id="email" name="email" required/>
      
          <label for="password">Password</label>
          <input placeholder="password" type="password" id="password" name="password" required/>

          <label for="cpassword">Confirm Password</label>
          <input placeholder="confirm password" type="password" id="cpassword" name="cpassword" required/>
      
          <input type="submit" value="Register">
        </form>
    </div><br>

    <div class="form-container">
        <h2>Change Password</h2>
        <form action="change_password.php" method="post">
            

            <input type="hidden" name="user_id" value="<?=$_SESSION['user_data']['id'] ?>">

            <label for="username">Username:</label>
            <input disabled type="text" name="username" required value="<?=$_SESSION['user_data']['username'] ?>"><br>

            <label for="email">Email:</label>
            <input disabled type="email" name="email" required value="<?=$_SESSION['user_data']['email'] ?>"><br>

            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" required><br>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required><br>

            <label for="confirm_new_password">Confirm New Password:</label>
            <input type="password" name="confirm_new_password" required><br>

            <input type="submit" value="Change Password">
        </form>
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