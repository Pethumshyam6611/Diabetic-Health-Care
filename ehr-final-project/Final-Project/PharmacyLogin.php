<?php
  session_start();
	require_once ('data/conn.php');
	require_once('data/methods.php');
  $_SESSION = array();
  session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-3/assets/css/login-3.css">
<link rel="stylesheet" href="Css/Reciption.Css"> 
<link rel="icon" type="imag/jpg" href="Images/Icons/Dieabatecare.png">       
<title>Pharmacy Login</title>
</head>
<body>
    <!-- Login 3 - Bootstrap Brain Component -->
<section class="p-3 p-md-4 p-xl-5 ">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-6 bsb-tpl-bg-platinum">
        <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
          <h1 class="m-0 text-center"><B>Pharmacy</B></h1>
          <img class="Doctorimg mx-auto " loading="lazy" src="Images/images/8663120_3966816-removebg-preview.png" width="80%" height="auto"  alt="Reciption Logo">
        </div>
      </div>
      <div class="col-12 col-md-6 bsb-tpl-bg-lotion">
        <div class="p-3 p-md-4 p-xl-5">
          <div class="row">
            <div class="col-12">
              <div class="mb-5">
                <h3><b>Log in</b></h3>
                <p>Enter Your Credentials </p>
              </div>
            </div>
          </div>
          <form action="" method="post">
            <div class="row gy-3 gy-md-4 overflow-hidden">
              <div class="col-12">
                <label for="email" class="form-label">Username<span class="text-danger">*</span></label>
                <input type="text" class="form-control light-blue-outline" name="username" id="email" required>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control light-blue-outline" name="password" id="password" value="" required>
              </div>
            
              <div class="col-12">
                <div class="d-grid">
                  <button class="btn bsb-btn-xl btn-primary" name="btnLogin" type="submit"><B>LOGIN</B></button>
                </div>
              </div>
            </div>
          </form>
          <?php
            if(isset($_POST["btnLogin"])){
              $username = $_POST["username"];
              $password = $_POST["password"];

              try {
                $conn = conn::getConnection();
                $sql = "SELECT `user_id`, `username`, `password`, `role` FROM `user` WHERE `username` = :username";
                $query = $conn->prepare($sql);
        
                $query->execute([':username' => $username]);

                $user = $query->fetch(PDO::FETCH_ASSOC);

                if ((($user && password_verify($password, $user['password'])) || ($user && $password === $user['password'])) 
                && $user['role'] === 'pharamcist') {
                    session_start();
                    $_SESSION['logged_id'] = $user['user_id'];
                    $_SESSION['logged_username'] = $username;
                    $_SESSION['logged_role'] = $user['role']; 
                    $role = $_SESSION['logged_role'];
                    $logged_username = $_SESSION['logged_username'];
                    
                    log_audit_trail("User Login", " - ", $logged_username,$role); 

                    header("Location: Pharmacy/PharamacyHome.php");
                    exit;
                  } else{
                    echo 'Invalid username or password';
                  }
                } catch (Exception $e) {
                  echo 'Error connecting to database: ' . $e->getMessage();
                  exit;
              }

            }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>