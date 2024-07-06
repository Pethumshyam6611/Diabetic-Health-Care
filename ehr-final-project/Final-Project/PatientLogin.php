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
    <title>DiabetesCare+</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/logins/login-9/assets/css/login-9.css">
<link rel="icon" type="imag/jpg" href="Images/Icons/Dieabatecare.png">
</head>



<body>
<!-- Login -->
<section class="bg-primary py-3 py-md-5 py-xl-8">
  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-12 col-md-6 col-xl-7">
        <div class="d-flex justify-content-center text-bg-primary">
          <div class="col-12 col-xl-9 l">
          <h1 class="h1 mb-4">Empower Your<br>Health Journey</h1>
            <hr class="border-primary-subtle mb-4">
            <p class="lead mb-5">An Innovative Digital Solution That Will Redefining Your Patient Experience.</p>
            <div class="text-endx" >
            <img src="Images/images/reshot-illustration-doctor-review-V3K9GLAREF-removebg-preview.png" alt="Patient Login Image" class="d-none d-sm-block" style="width:60%; height:fit-content">
          </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-5">
        <div class="card border-0 rounded-4">
          <div class="card-body p-3 p-md-4 p-xl-5">
            <div class="row">
              <div class="col-12">
                <div class="mb-4">
                  <h3>Login</h3>
                  <p>Don't have an account? <a href="PatientSignup.php">Sign up</a></p>
                </div>
              </div>
            </div>
            <form action="" method="post">
              <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="email" placeholder="Username" required>
                    <label for="email" class="form-label">Username</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Password</label>
                  </div>
                </div>

                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn btn-primary btn-lg" name="btnLogin" type="submit"><B>LOGIN</B></button>
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
                $sql = "SELECT user_id, username, password, role FROM user WHERE username = :username";
                $query = $conn->prepare($sql);
        
                $query->execute([':username' => $username]);

                $user = $query->fetch(PDO::FETCH_ASSOC);

                if ((($user && password_verify($password, $user['password'])) || ($user && $password === $user['password'])) 
                && $user['role'] === 'patient') {
                    session_start();
                    $_SESSION['logged_id'] = $user['user_id'];
                    $_SESSION['logged_username'] = $username;
                    $_SESSION['logged_role'] = $user['role']; 

                    

                    header("Location: Patient/PatientHome.php");
                    exit;
                  } else{
                    echo '<div style="color:red;"> Invalid username or password </div>';
                  }
                } catch (Exception $e) {
                  echo 'Error connecting to database: ' . $e->getMessage();
                  exit;
              }

            }
            ?>
            <div class="row">
              <div class="col-12">
                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                  <!-- <a href="#!">Forgot password</a> -->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>    

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>