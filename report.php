<?php
    include('includes/header.php');
 
    if ( isset($_SESSION['user_data']) && isset($_SESSION['user_data']->client_login)  ){
      header('Location: orders.php');
  }
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 
 
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
      <p>Start Date: <input type="text" id="startdate"></p>
      <p>End Date: <input type="text" id="enddate"></p>
 
        <div class="recent-sales box">
          <div class="title">Import Product
            <div class="sales-details">
              <div class=></div>
              <div class="button" onclick="pdfGenerate('IN')">
                <a >GENERATE</a>
              </div>
            </div>
          </div>
 
        </div>
        <br>
        <div class="recent-sales box">
          <div class="title">Release Product
            <div class="sales-details">
              <div class=></div>
              <div class="button" onclick="pdfGenerate('OUT')">
              <a >GENERATE</a>
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
 
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(function() {
        $("#startdate").datepicker({
            numberOfMonths: 1,
            onSelect: function(selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() + 1);
                $("#enddate").datepicker("option", "minDate", dt);
                console.log('startdate',dt)
 
            }
        });
        $("#enddate").datepicker({
            numberOfMonths: 1,
            onSelect: function(selected) {
                var dt = new Date(selected);
                dt.setDate(dt.getDate() - 1);
                $("#startdate").datepicker("option", "maxDate", dt);
                console.log('enddate',dt)
            }
        });
    });
    </script>
    <script>
      function pdfGenerate( value ){
 
 
        if( !document.getElementById('startdate').value || !document.getElementById('enddate').value ){
          alert('Please Complete all date fields');
          return;
        }
 
        var startDate = new Date(document.getElementById('startdate').value);
        var endDate = new Date(document.getElementById('enddate').value);
 
 
        if( value == 'IN' ){
 
          let a = document.createElement('a');
          a.target = '_blank';
          a.href = `reports/pdf-in.php?start=${formatDate(startDate)}&end=${formatDate(endDate)}`; // replace with your URL
          a.click();
        }else if ( value == 'OUT' ){
          let a = document.createElement('a');
          a.target = '_blank';
          a.href = `reports/pdf-out.php?start=${formatDate(startDate)}&end=${formatDate(endDate)}`; // replace with your URL
          a.click();
        }
      }
 
      function formatDate(dateString) {
          var date = new Date(dateString);
          var year = date.getFullYear();
          var month = (1 + date.getMonth()).toString().padStart(2, '0');
          var day = date.getDate().toString().padStart(2, '0');
 
          return year + '-' + month + '-' + day;
      }
 
    </script>
 
</body>
</html>