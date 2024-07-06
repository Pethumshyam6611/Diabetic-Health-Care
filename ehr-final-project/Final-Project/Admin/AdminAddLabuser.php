<?php
  session_start();
  require_once('../data/conn.php');
  require_once ('../data/methods.php');
  if(!isset($_SESSION['logged_username'])) {
    header("Location: logout.php");
    exit; 
   } 
  $logged_username = $_SESSION['logged_username'];
	$role = $_SESSION['logged_role']; 

?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lab Technician</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="../Css/AddUser.Css">
        <link rel="stylesheet" href="../Css/Adduserform.css">
		<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>

<body>
  <div class="wrapper">
    <div class="row">
      <div class="col-6 button-column">
        <a href="AdminManageUserLab.php" class="btn btn-danger active" style="background-color: red; color: white" role="button" aria-pressed="true">Back</a>
      </div>
    </div>

    <form method="post" class="form">
	  <h2>Add Lab Technician</h2>
	  <div class="form-group">
		  <label for="email">Name:</label>
		  <div class="relative">
			  <input class="form-control" id="name" name="name" type="text" pattern="[a-zA-Z\s]+"  autofocus="" title="Username should only contain letters. e.g. Piyush Gupta" autocomplete="" placeholder="Type your name here..." required>
			  <i class="fa fa-user"></i>
		  </div>
	  </div>
	  <div class="form-group">
	  	<label for="email">Staff ID:</label>
	  	<div class="relative">
		  	<input class="form-control" type="text" name="staffid" maxlength="8"  placeholder="Type your email address..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
		  	<i class="fa fa-envelope"></i>
	  	</div>
	  </div>
	  <div class="form-group">
	  	<label for="email">Phone Number:</label>
	  	<div class="relative">
	  		<input class="form-control" name="number" type="text" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Type your Mobile Number..." required>
	  		<i class="fa fa-phone"></i>
	  	</div>
	  </div>

	  <div class="form-group">
	  	<label for="email">Username:</label>
	  	<div class="relative">
	  		<input class="form-control" name="username" type="text"  placeholder="Enter Your Username" required>
	  		<i class="fa fa-building"></i>
	  	</div>
	  </div>
	  <div class="form-group">
	  	<label for="email">Password:</label>
	  	<div class="relative">
	  		<input class="form-control" name="password" type="Password"  placeholder="Enter Your Password" required>
	  		<i class="fa fa-building"></i>
	  	</div>
	  </div>
  	
	  <div class="tright">
	  	<a href=""><button class="movebtn movebtnre" name="btnReset" type="Reset"><i class="fa fa-fw fa-refresh"></i> Reset </button></a>
	  	<a href=""><button class="movebtn movebtnsu" name="btnSubmit"  type="Submit">Submit <i class="fa fa-fw fa-paper-plane"></i></button></a>
	  </div>
	</form>

	<div class="thanks" style="display: none;">
		<h4>Thank you!</h4>
		<p><small>Your message has been successfully sent.</small></p>
	</div>

	<?php

		if (isset($_POST["btnSubmit"])){
			$name = $_POST["name"];
			$staffid = $_POST["staffid"];
			$number = $_POST["number"];
			$username = $_POST["username"];
			$password = $_POST["password"];

			$salt = random_bytes(22);
			$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

			try{
				$conn = conn::getConnection();
				if (!isUniqueStaffIDLab($conn, $staffid)) {
					echo "<script>alert('Staff ID already exists. Please choose a different one.');</script>";
					header("Refresh: 1");
					exit;
				}
				
				if (!isUniqueUsername($conn, $username)) {
					echo "<script>alert('Username already exists. Please choose a different one.');</script>";
					header("Refresh: 1");
					exit;
				}

				$query = $conn->prepare("INSERT INTO `user`
						(`username`, `password`, `role`) 
						VALUES 
						(:username, :password, :role)");
				$query->execute([':username' => $username, ':password' => $hashed_password, ':role' => "lab technician"]);
				
				$user_id = $conn->lastInsertId();  
				$query1 = $conn->prepare("INSERT INTO `lab_technician`
						(`staff_id`, `name`, `contact`, `user_id`) 
						VALUES 
						(:staffid,:name,:contact,:userid)");
				$query1->execute([':staffid' => $staffid, ':name' => $name, ':contact' => $number, ':userid' => $user_id]);
				log_audit_trail("Add Account", "Created Lab User with ID: " .$user_id, $logged_username,$role);
				header("Location: AdminManageUserLab.php");


			} catch(Exception $e){
				echo 'Erro: ' .$e->getMessage();
			}
		}



	?>



  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="../Java Script/Admin.Js"></script>
        <script src="../Java Script/Adduserform.js"></script>
    
</body>


</html>