<link rel="stylesheet" href="assets/css/popup_style.css"> </style>
<?php
   
  include('./constant/layout/head.php');
  include('./constant/connect.php');
  session_start();

if(isset($_SESSION['userId'])) {
 //header('location:'.$store_url.'login.php');   
}

$errors = array();

if(isset($_POST["login"])) 
  {
  $username = $_POST['username'];
  $password = $_POST['password'];
  // $pass = md5($password);
  //echo $password;exit;
  
  if(empty($username) || empty($password)) 
    {
    if($username == "") 
      {
       $errors[] = "Username is required";
      } 

    if($password == "")
      {
       $errors[] = "Password is required";
      } 
  } else {
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $connect->query($sql);

    if($result->num_rows == 1) 
    {
      $password = md5($password);
     
      $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
      $mainResult = $connect->query($mainSql);

      if($mainResult->num_rows == 1) 
      {
        $value = $mainResult->fetch_assoc();
        $user_id = $value['user_id'];

        // set session
        $_SESSION['userId'] = $user_id;?>

      
      <div class="popup popup--icon -success js_success-popup popup--visible">
      <div class="popup__background"></div>
      <div class="popup__content">
      <h3 class="popup__content__title">
          Success....
      </h1>
      <p>Login Successfully</p>
      <p>     
      <?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?>
      </p>
      </div>
      </div>
     <?php  }  
    
    else{ 
    ?>
 
    <div class="popup popup--icon -error js_error-popup popup--visible">
      <div class="popup__background"></div>
      <div class="popup__content">
      <h3 class="popup__content__title">
       Error 
      </h1>
      <p>Incorrect username or password combination</p>
      <p>
      <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
    </p>
    </div>
    </div>
       
    <?php } // /else
    } 

    else 
    { ?> 
    <div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
    <h3 class="popup__content__title">
      Error 
    </h1>
    <p>Username doesnot exists</p>
    <p>
      <a href="login.php"><button class="button button--error" data-for="js_error-popup">Close</button></a>
    </p>
    </div>
    </div>  
         
    <?php } // /else
  } // /else not empty username // password  
} // /if $_POST
?>

<div id="main-wrapper">
  <div class="unix-login">
    <div class="accountbg"></div>
      <div class="container-fluid" style="background-color: #068aef;">
        <div class="row ">
          <div class="col-md-4 mx-auto">
            <div class="login-content ">
              <div class="login-form">
                <center><img src="./assets/uploadImage/Logo/logo.png" style="width: 50%;"></center><br>
                                
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm" class="row">
                
                <div class="form-group col-md-12">
                  <label for="username">User Name</label>
                  <input type="text" name="username" id="username" class="form-control" placeholder="Username" required="">
                </div>

                <div class="form-group col-md-12">
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                                
                <div class="col-md-6 form-check">
                  <input type="checkbox" class="pl-3">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
     
                <div class="forgot-phone col-md-6 text-right">
                  <a href="https://www.youtube.com/" class="text-right f-w-600 text-red"> Forgot Password?</a>
                </div>
              
                <div class="col-md-12">
                <div class="g-recaptcha col-md-6" data-sitekey="6LdJC4AeAAAAAE638ShRfVSMBDSDjbQmkxD-lh_p"></div>
                </div>

                <div class="col-md-12"> 
                  <button type="submit" name="login" class=" f-w-600 btn btn-danger  m-t-30">Sign in</button>
                </div>

              </form>

              <br><br>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <center>            
        <footer></footer>
    </center>
</div>
    
    
  <script src="./assets/js/lib/jquery/jquery.min.js"></script>
  <script src="./assets/js/lib/bootstrap/js/popper.min.js"></script>
  <script src="./assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/jquery.slimscroll.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
  <script src="./assets/js/custom.min.js"></script>

  <script>
    function onReady(callback) 
    {
    var intervalID = window.setInterval(checkReady, 1000);
    function checkReady()
    {
        if (document.getElementsByTagName('body')[0] !== undefined)
        {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
    }

    function show(id, value) 
    {
      document.getElementById(id).style.display = value ? 'block' : 'none';
    }

    onReady(function () 
    {
    show('page', true);
    show('loading', false);
    });  

  </script>

</body>
</html>
