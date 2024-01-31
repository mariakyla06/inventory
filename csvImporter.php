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
      <h2>EMPLOYEE CSV IMPORTER</h2>
      <p>Please select a CSV file and click Upload:</p>

      <form method="post" enctype="multipart/form-data">
        <input type="file" id="csvFile" name="csvFile" accept=".csv">
        <br><br>
        <input type="submit" value="Upload CSV" name="submit">
      </form>
    </div><br>
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

  function downloadFailedInsertsCSV(failedInserts) {
    console.log('failedInserts', failedInserts)
      var headers = ["employee_id", "name", "contact", "error"];

      var csvContent = "data:text/csv;charset=utf-8,";

      csvContent += headers.join(",") + "\r\n";

      failedInserts.forEach(function(rowArray) {
          csvContent += rowArray.join(",") + "\r\n";
      });

      var encodedUri = encodeURI(csvContent);
      var link = document.createElement("a");
      link.setAttribute("href", encodedUri);
      link.setAttribute("download", `failed_inserts_${new Date().toLocaleDateString()}.csv`);
      document.body.appendChild(link); // Required for Firefox

      link.click(); 
  }

 </script>


</body>
</html>

<?php

function generatePassword() {
  $length = 8;
  $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  $password = "";
  for ($i = 0; $i < $length; $i++) {
      $random_picked = mt_rand(0, strlen($charset) - 1);
      $password .= $charset[$random_picked];
  }
  return $password;
}

  if (isset($_POST['submit']) && $_POST['submit'] == 'Upload CSV') {

    spl_autoload_register(function ($class) {
        include 'models/' . $class . '.php';
    });
  
      // Connect to the database
      include("send_email.php");
      $instance = new Client;

      $today = date('Y-m-d H:i:s');

      // Check if file was uploaded
      if (isset($_FILES['csvFile'])) {
          $file = $_FILES['csvFile']['tmp_name'];

          // Open the CSV file
          if (($handle = fopen($file, "r")) !== FALSE) {
              // Skip the first row (header)
              fgetcsv($handle);

              // Array for failed inserts
              $failedInserts = array();

              // Read each line of the CSV
              while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                  $employeeId = $data[0];
                  $password = generatePassword();
                  $name = $data[1];
                  $contact = $data[2];
                  try {
                    $instance->setQuery("INSERT INTO clients (`employee_id`, `password`, `name`, `contact`, `created_at`, `updated_at`) VALUES ('$employeeId', '$password', '$name', '$contact', '$today', '$today')");
                    sendEmployeeEmail($contact, $password, $name);

                  } catch (PDOException $e) {
                    $errorCode = (string) $e->getCode();
                      switch($errorCode) {
                          case '23000':
                              $error = 'A duplicate entry error occurred (Employee ID).';
                              break;
                          case '42000':
                              $error = 'A syntax error occurred in SQL statement.';
                              break;
                              // Add more cases as needed
                          default:
                              $error =  'An error occurred. Please try again later.';
                      }
                      $failedInserts[] = array($employeeId, $name, $contact, "SQL ERROR CODE[$errorCode] $error");

                  }


              }


              // Close the CSV file
              fclose($handle);
              
              if(count($failedInserts) > 0){
                echo "<script>";
                  echo "alert('Some accounts failed to create!') \n";
                  echo "downloadFailedInsertsCSV(". json_encode($failedInserts) .");";
                echo "</script>";
              }else{
                echo "<script>";
                  echo "alert('All New Accounts has been Created!')";
                echo "</script>";
              }
          }
      }

  }
?>
