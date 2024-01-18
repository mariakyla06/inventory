<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISBS Login - Supply Inventory System using Barcode Scanner</title>
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>
<body>
    <!-- <div class="container">
       
        
        <div class="loginBody">
            <form action="login.php" method="post">
                <div class="loginInputsContainer">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                
                    <div class="loginButton"> 
                    <input type="submit" value="Login">
                    </div>
                </div>
            </form>
        </div>
    </div> -->

    <div class="parent clearfix">
        <div class="bg-illustration">
          <img src="https://upload.wikimedia.org/wikipedia/en/d/d2/Cavite_State_University_%28CvSU%29.png" alt="logo">
    
          <div class="burger-btn">
            <span></span>
            <span></span>
            <span></span>
          </div>
    
        </div>
        
        <!-- <div class="login">
          <div class="container">
            <h1>LOGIN FORM</h1>
        
            <div class="login-form">
              <form action="login.php" method="post">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>   
    
                <div class="remember-form">
                  <input type="checkbox">
                  <span>Remember me</span>
                </div>
                <div class="forget-pass">
                  <a href="#">Forgot Password ?</a>
                </div>
    
                <button type="submit">LOG-IN</button>
    
              </form>
            </div>
        
          </div>
        </div> -->

        <div class="login">
          <div class="container">

              <div class="tab">
                  <button class="tablinks" onclick="openForm(event, 'Form1')">Form 1</button>
                  <button class="tablinks" onclick="openForm(event, 'Form2')">Form 2</button>
              </div>

              <div id="Form1" class="tabcontent">
                  <h2>Admin Login </h2>
                  <div class="login-form">
                    <form action="login.php" method="post">
                      <input type="text" id="username" name="username" placeholder="Username" required>
                      <input type="password" id="password" name="password" placeholder="Password" required>   
          
                      <div class="remember-form">
                        <input type="checkbox">
                        <span>Remember me</span>
                      </div>
                      <div class="forget-pass">
                        <a href="#">Forgot Password ?</a>
                      </div>
          
                      <button type="submit">LOG-IN</button>
          
                    </form>
                  </div>
              </div>

              <div id="Form2" class="tabcontent">
                  <h2>Client Login </h2>
                  <div class="login-form">
                    <form action="queries/client-login.php" method="post">
                      <input type="text" id="employee_id" name="employee_id" placeholder="Employee ID" required>
                      <input type="password" id="password" name="password" placeholder="Password" required>   
          
                      <div class="remember-form">
                        <input type="checkbox">
                        <span>Remember me</span>
                      </div>
                      <div class="forget-pass">
                        <a href="#">Forgot Password ?</a>
                      </div>
          
                      <button type="submit">LOG-IN</button>
          
                    </form>
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

      </div>
</body>
</html>
