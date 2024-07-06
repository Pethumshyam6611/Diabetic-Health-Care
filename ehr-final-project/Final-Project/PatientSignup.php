<?php
  session_start();
	require_once ('../data/conn.php');
	require_once('../data/methods.php');

  try{
    $conn = conn::getConnection();
  } catch (Exception $e){
    echo 'Error connecting to database: ' . $e->getMessage();
  }
  function phnExist($phn, $connection){
    $queryCheck = $connection->prepare("SELECT `patient_id` FROM `patient` WHERE `phn` = :phn");
    $queryCheck->execute([':phn'=> $phn]);
    $p_id = $queryCheck->fetch(PDO::FETCH_ASSOC);
    return $p_id ? true : false;
  }

  function loggedUserExist($phn, $connection){
    $queryCheck = $connection->prepare("SELECT `user_id` FROM `patient` WHERE `phn` = :phn AND `user_id` IS NOT NULL");
    $queryCheck->execute([':phn'=> $phn]);
    $userId = $queryCheck->fetch(PDO::FETCH_ASSOC);
    return $userId ? true : false;
}

  function usernameExist($username, $connection){
    $queryCheck = $connection->prepare("SELECT `username` FROM `user` WHERE `username` = :username");
    $queryCheck->execute([':username' => $username]);
    $result = $queryCheck->fetch(PDO::FETCH_ASSOC);
    return $result ? true : false;
  }

  function getPatientId($phn, $connection){
    $queryCheck = $connection->prepare("SELECT `patient_id` FROM `patient` WHERE `phn` = :phn");
    $queryCheck->execute([':phn'=> $phn]);
    $patient_id = $queryCheck->fetch(PDO::FETCH_ASSOC);
    return $patient_id;
  }
      
  
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
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
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
            <img src="../Images/images/reshot-illustration-doctor-review-V3K9GLAREF-removebg-preview.png" alt="Patient Login Image" class="d-none d-sm-block" style="width:60%; height:fit-content">
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
                  <h3>Sign Up</h3>
                  <h6>Have an account? <a href='PatientLogin.php'>login</a></h6>
                  <div id="message" class="alert"></div>
                  
                  <p>Register using your Patient Identification Number!</p>
                  
                </div>
              </div>
            </div>

            <form action="#!" method="post">
              <div class="row gy-3 overflow-hidden">
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="phn" id="email"  required>
                    <label for="email" class="form-label">Patient Health Number (PHN)</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" id="password" value="" placeholder="Password" required>
                    <label for="password" class="form-label">Username</label>
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
                    <button class="btn btn-primary btn-lg" name="btnSignUp" type="submit"><B>SIGNUP</B></button>
                  </div>
                </div>
              </div>
            </form>

            <?php
              if(isset($_POST['btnSignUp'])){
                $PHN = $_POST["phn"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                
                try{
                  $conn = conn::getConnection();

                  if(loggedUserExist($PHN, $conn)){
                    $message = "PHN already registered as a user. Please <a href='PatientLogin.php'>login</a>.";
                  } elseif(!phnExist($PHN, $conn)){
                    $message = "PHN not found. Please register at your diabetic clinic's reception.";
                  } elseif(usernameExist($username, $conn)){
                    $message = "Username already exists. Please choose a different username.";
                  } else { 
                    $_SESSION['phn'] = $PHN;
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    header("Location: AuthPage.php");
                    exit;
                  }

                } catch (Exception $e){
                  echo 'Error connecting to database: ' . $e->getMessage();
                }
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>    
<script>
        // Display message from PHP variable
        var message = "<?php echo $message; ?>";
        if(message !== "") {
            var messageDiv = document.getElementById("message");
            messageDiv.innerHTML = message;
            messageDiv.classList.add("alert-info"); 
            messageDiv.style.display = "block";
        }
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>