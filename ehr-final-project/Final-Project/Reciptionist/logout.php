<?php
session_start();
require_once('../data/conn.php');
require_once ('../data/methods.php');

$logged_username = $_SESSION['logged_username'];
$role = $_SESSION['logged_role'];

log_audit_trail("User Logout", " - " ,$logged_username,$role); 
session_unset(); 
session_destroy(); 

header("Location: ../ReceptionistLogin.php");
exit;
?>