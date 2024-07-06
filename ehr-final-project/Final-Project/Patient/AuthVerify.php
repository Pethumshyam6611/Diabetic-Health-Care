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

    $salt = random_bytes(22);
	$hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    try{
        $conn = conn::getConnection();
        $query = $conn->prepare("INSERT INTO `user`
				(`username`, `password`, `role`) 
				VALUES 
				(:username, :password, :role)");
        $query->execute([':username' => $username, ':password' => $hashed_password, ':role' => "patient"]);
		$user_id = $conn->lastInsertId();  

        $updateQuery = $conn->prepare("UPDATE `patient` SET `user_id`= :user_id WHERE `phn` = :phn");
        $updateQuery->execute([':user_id' => $user_id, ':phn' => $phn]);
		
        $_SESSION['logged_id'] = $user_id;
        $_SESSION['logged_username'] = $username;
        $_SESSION['logged_role'] = $user['role']; 
		header("Location: PatientHome.php");
        exit;

    } catch (Exception $e){
        echo 'Error connecting to database: ' . $e->getMessage();
    }
 

    
?>