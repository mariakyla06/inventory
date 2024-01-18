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
        <span class="dashboard">Report</span>
      </div>
    </nav>

    <div class="report-content">
      <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">Import Product
            <div class="sales-details">
              <div class=></div>
              <div class="button">
                <a href="reports/pdf-in.php">PDF</a>
              </div>
            </div>
          </div>
          
        </div>
        <br>
        <div class="recent-sales box">
          <div class="title">Release Product
            <div class="sales-details">
              <div class=></div>
              <div class="button">
                <a href="reports/pdf-out.php">PDF</a>
              </div>
            </div>
          </div>
        </div>
        
       
      </div>
      
    </div>
    <!-- <div class="month">
           <div class="monthly-range-picker">
          <label for="startMonth">Start Month:</label>
          <input type="month" id="startMonth" name="startMonth">
          <br>
          <label for="endMonth">End Month:</label>
          <input type="month" id="endMonth" name="endMonth">
          <br>
          <button onclick="getSelectedRange()">Get Range</button>
      </div> 
        </div> -->
  </section>

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
/* Monthly Report button*/
function getSelectedRange() {
    const startMonth = document.getElementById('startMonth').value;
    const endMonth = document.getElementById('endMonth').value;

    alert(`Selected Range: ${startMonth} to ${endMonth}`);
}

 </script>

</body>
</html>