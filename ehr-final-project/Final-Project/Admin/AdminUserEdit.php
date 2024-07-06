<?php
	session_start();
	require_once ('../data/conn.php');
	require_once('../data/methods.php');

	$userType = $_GET['type'];
	$id = $_GET['id'];

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
    <title>Edit User</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="../Css/AddUser.Css">
        <link rel="stylesheet" href="../Css/Adduserform.css">
		<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>

<body>


<?php
	try{
		$conn = conn::getConnection();
		switch ($userType) {
			case 'pharamacist':
				$sql = "SELECT pharmacist.pharmacist_Id, pharmacist.staff_id, pharmacist.name, pharmacist.contact, pharmacist.user_id,user.username, user.password 
				FROM pharmacist 
				INNER JOIN user ON pharmacist.user_id = user.user_id
				WHERE pharmacist.pharmacist_Id = :id";
				$title = "Pharamacist";
				break;
			case 'receptionist':
				$sql = "SELECT receptionist.receptionist_id, receptionist.staff_id, receptionist.name, receptionist.contact, receptionist.user_id,user.username, user.password 
				FROM receptionist 
				INNER JOIN user ON receptionist.user_id = user.user_id
				WHERE receptionist.receptionist_id = :id";
				$title = "Receptionist";
				break;
			case 'lab':
				$sql = "SELECT lab_technician.lab_tech_id, lab_technician.staff_id, lab_technician.name, lab_technician.contact, lab_technician.user_id, user.username, user.password 
				FROM lab_technician 
				INNER JOIN user ON lab_technician.user_id = user.user_id
				WHERE lab_technician.lab_tech_id = :id";
				$title = "Lab Technician";
				break;

			default:
				header("Location: Admin .php");
				exit;
			}
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

	}catch(Exception $e){
		echo "ERROR: ".$e->getMessage();
	}
		

?>
  <div class="wrapper">
    <div class="row">
      <div class="col-6 button-column">

        <?php
			switch ($userType){
				case 'pharamacist':
					echo '<a href="AdminManageUserPharmecy.php" class="btn btn-danger active" style="background-color: red; color: white" role="button" aria-pressed="true">Back</a>';
					break;
				case 'receptionist':
					echo '<a href="AdminManageUserRec.php" class="btn btn-danger active" style="background-color: red; color: white" role="button" aria-pressed="true">Back</a>';
					break;
				case 'lab':
					echo '<a href="AdminManageUserLab.php" class="btn btn-danger active" style="background-color: red; color: white" role="button" aria-pressed="true">Back</a>';
					break;
				default:
					header("Location: Admin.php");
					exit;
			}
		?>
      </div>
    </div>

    <form method="post" class="form">
	  <h2>Edit <?php echo $title;?></h2>
	  <div class="form-group">
		  <label for="email">Name:</label>
		  <div class="relative">
			  <input class="form-control" id="name" value="<?php echo $result['name']?>" name="name" type="text" pattern="[a-zA-Z\s]+" required="" autofocus="" title="Username should only contain letters. e.g. Piyush Gupta" autocomplete="" placeholder="Type your name here...">
			  <i class="fa fa-user"></i>
		  </div>
	  </div>
	  <div class="form-group">
	  	<label for="email">Staff ID:</label>
	  	<div class="relative">
		  	<input class="form-control" type="text"  value="<?php echo $result['staff_id']?>" name="staffid" required="" placeholder="Type your email address..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" readonly>
		  	<i class="fa fa-envelope"></i>
	  	</div>
	  </div>
	  <div class="form-group">
	  	<label for="email">Phone Number:</label>
	  	<div class="relative">
	  		<input class="form-control" name="number"  value="<?php echo $result['contact']?>" type="text" maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required="" placeholder="Type your Mobile Number...">
	  		<i class="fa fa-phone"></i>
	  	</div>
	  </div>
<br>

	  <div class="form-group">
	  <label><B>Update Password</B></label>
	  	<label for="email"></label>
	  	<div class="relative">
		  
	  		<input class="form-control" name="username"  value="<?php echo $result['username']?>" type="text" required="" placeholder="Enter New Username" readonly>
	  		<i class="fa fa-building"></i>
	  	</div>
	  </div>
	  <div class="form-group">
	  	<div class="relative">
	  		<input class="form-control" name="password" value="" type="Password"  placeholder="Enter New Password">
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
			$userId= $result["user_id"];
			$name = $_POST["name"];
			$number = $_POST["number"];
			$password = $_POST["password"];

			


			try{
				$conn = conn::getConnection();

				if (!empty($password)) {
					$salt = random_bytes(22);
					$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
					$query = $conn->prepare("UPDATE user
					SET password = :password
					WHERE user_id = :user_id");
					$query->execute([':password' => $hashed_password, ':user_id' => $userId]);

				}
				
						

				switch ($userType) {
					case 'pharamacist':
						$query1 = $conn->prepare("UPDATE pharmacist
							SET name = :name, contact = :contact
							WHERE user_id = :user_id");
							$query1->execute([':name' => $name, ':contact' => $number, ':user_id' => $userId]);
							header("Location: AdminManageUserPharmecy.php");
						break;

					case 'receptionist':
						$query1 = $conn->prepare("UPDATE receptionist
							SET name = :name, contact = :contact
							WHERE user_id = :user_id");
							$query1->execute([':name' => $name, ':contact' => $number, ':user_id' => $userId]);
							header("Location: AdminManageUserRec.php");
						break;

					case 'lab':
						$query1 = $conn->prepare("UPDATE lab_technician
							SET name = :name, contact = :contact
							WHERE user_id = :user_id");
							$query1->execute([':name' => $name, ':contact' => $number, ':user_id' => $userId]);
							header("Location: AdminManageUserLab.php");
							break;
					default:
						header("Location: Admin .php");
						exit;
				}
				
				
				
				



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