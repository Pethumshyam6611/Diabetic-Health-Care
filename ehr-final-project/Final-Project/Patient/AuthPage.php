<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');
    if(!isset($_SESSION['phn'], $_SESSION['username'], $_SESSION['password'])) {      
        header("Location: PatientSignup.php");
        exit;
    }
    $phn = $_SESSION['phn'];
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
 
    try {
        $conn = conn::getConnection();
        $query = $conn->prepare("SELECT email FROM patient WHERE phn = :phn");
        $query->execute([':phn' => $phn]);
        $result = $query->fetch(PDO::FETCH_ASSOC);


        if($result) {
            $email = $result['email'];
        } else {
            $email = "Email not found";
        }
    } catch (Exception $e) {
        echo 'Error retrieving email from database: ' . $e->getMessage();
    }
    
    $verificationCode = mt_rand(100000, 999999);
    $_SESSION['verificationCode'] = $verificationCode;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Verification Code</title>
    
	<script src="https://smtpjs.com/v3/smtp.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Link jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Link Bootstrap JS (including Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Link Boxicons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--=============== BOXICONS ===============-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
<!--=============== CSS ===============-->
<link rel="stylesheet" href="../Css/Modalpopup.css">


</head>
<body id="body-pd" style="background-color:rgb(35,110,219); "> 
    <header class="header" id="header" style="background-color: rgba(240, 241, 243, 0); ">
        <a href="PatientSignup.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="white" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
            </svg>
        </a>
    </header>
    <div class="container"> 
    <div class="row align-items-center justify-content-center">
            <div class="col-md-6 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
            <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Send Verification Code</B></H5>
                <br>
            <div>
            <br>
            <br>
            <label for="">Registerd Email: </label>
             <input type="email" id="email" value="<?php echo $email; ?>" readonly>	
    
		<div class="otpverify" style="width: 100%;gap: 20px; margin-top:5px; display: block;">
			<input type="text" id="otp_inp" placeholder="Enter the OTP sent to your Email...">
			<button class="btn btn-primary" id="otp-btn">Verify</button>
		</div>
        <br>
        <br>
        <br>
		<button class="btn btn-primary" onclick="sendOTP()">Send OTP</button>
	</div>
    </div>
            </div>
    </div>
    </div>
    <script src="emailotp.js"></script>




    <style>

        .table-wrapper {
    overflow-y: auto;
    }  
    .container {
    margin-left: 1rem;
    margin-right: 1rem;}

    #latestlabre{
        width: auto;
        height: 15px;
    }
    @media (max-width: 767px) { 
    .col-md-6{  
      flex-direction: column; 
    }
    .col-md-5 {
    margin-left: 0px;  
    }
    .col-md-5 {
    margin-left: 0px; 
    margin-right: 0px; 
    }
    .container {
    margin-left: 4px;
    }
   
    }


    #functions {
    transition: transform 190ms ease-out;

    }

    #functions:hover {
    transform: translate(0px, 0px) scale(1.1, 1.2);
    }
</style>
</body>
</html>