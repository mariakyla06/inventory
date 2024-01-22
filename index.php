<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISBS Login - Supply Inventory System using Barcode Scanner</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <style>
        body,
        html {
          margin: 0;
          padding: 0;
          height: 100%;
          background: #F1C93B !important;
        }
        .user_card {
          height: 400px;
          width: 350px;
          margin-top: auto;
          margin-bottom: auto;
          background: green;
          position: relative;
          display: flex;
          justify-content: center;
          flex-direction: column;
          padding: 10px;
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
          border-radius: 5px;

        }
        .brand_logo_container {
          position: absolute;
          height: 170px;
          width: 170px;
          top: -75px;
          border-radius: 50%;
          background: #F1C93B;
          padding: 10px;
          text-align: center;
        }
        .brand_logo {
          height: 150px;
          width: 150px;
          border-radius: 50%;
          border: 2px solid white;
        }
        .form_container {
          margin-top: 100px;
        }
        .login_btn {
          width: 100%;
          background: #F1C93B !important;
          color: white !important;
        }
        .login_btn:focus {
          box-shadow: none !important;
          outline: 0px !important;
        }
        .login_container {
          padding: 0 2rem;
        }
        .input-group-text {
          background: #F1C93B !important;
          color: white !important;
          border: 0 !important;
          border-radius: 0.25rem 0 0 0.25rem !important;
        }
        .input_user,
        .input_pass:focus {
          box-shadow: none !important;
          outline: 0px !important;
        }
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
          background-color: #F1C93B !important;
        }
    </style>
</head>
<body>
    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        
        <div class="user_card tabcontent active" id="Form1" style="display: block;"> 
          <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
              <img src="cvsu.png" class="brand_logo" alt="Logo">
            </div>
          </div>
          <div class="d-flex justify-content-center form_container">
            <form action="login.php" method="post">
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="username" name="username" placeholder="Username" required>
              </div>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" id="password" name="password" placeholder="Password" required>   
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customControlInline">
                </div>
              </div>
                <div class="d-flex justify-content-center mt-3 login_container">
            <button type="submit" name="button" class="btn login_btn">Admin Login</button>
            </div>
            </form>
          </div>
      
          <div class="mt-4">
            <div class="tab d-flex justify-content-center mt-3 login_container">
              <button class="tablinks btn btn-sm mx-1" onclick="openForm(event, 'Form1')" style="background-color: #508D69 !important; color: white !important;">Admin</button>
              <button class="tablinks btn btn-sm mx-1" onclick="openForm(event, 'Form2')" style="background-color: #508D69 !important; color: white !important;">Client</button>
            </div>
          </div>
        </div>
        
        <div class="user_card tabcontent " id="Form2" style="display: none;">
          <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
              <img src="cvsu.png" class="brand_logo" alt="Logo">
            </div>
          </div>
          <div class="d-flex justify-content-center form_container">
            <form action="queries/client-login.php" method="post">
            
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" id="employee_id" name="employee_id" placeholder="Employee ID" required>
              </div>
              
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" id="password" name="password" placeholder="Password" required>   
              </div>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customControlInline">
                </div>
              </div>
                <div class="d-flex justify-content-center mt-3 login_container">
            <button type="submit" name="button" class="btn login_btn">Client Login</button>
            </div>
            </form>
          </div>
      
          <div class="mt-4">
            <div class="tab d-flex justify-content-center mt-3 login_container">
              <button class="tablinks btn btn-sm mx-1" onclick="openForm(event, 'Form1')" style="background-color: #508D69 !important; color: white !important;">Admin</button>
              <button class="tablinks btn btn-sm mx-1" onclick="openForm(event, 'Form2')" style="background-color: #508D69 !important; color: white !important;">Client</button>
            </div>
          </div>
        </div>

      </div>


	  </div>


  <script>
        function openForm(evt, formName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(formName).style.display = "block";
            evt.currentTarget.className += " active";
        }
      </script>
</body>
</html>