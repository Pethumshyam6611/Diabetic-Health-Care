<?php
session_start();
require_once ('data/conn.php');
require_once('data/methods.php');


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
        && $user['role'] === 'admin') {
            $_SESSION['logged_id'] = $user['user_id'];
            $_SESSION['logged_username'] = $username;
            $_SESSION['logged_role'] = $user['role']; 
            $role = $_SESSION['logged_role'];
            $logged_username = $_SESSION['logged_username'];

            if (isset($_SESSION['logged_username'])) {
                if (!isset($_SESSION['online_users_count'])) {
                    $_SESSION['online_users_count'] = 0;
                }
                $_SESSION['online_users_count']++;
            }
            log_audit_trail("User Login", " - ", $logged_username,$role); 
            header("Location: Admin/Admin .php");
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    } catch (Exception $e) {
        echo 'Error connecting to database: ' . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/Adminlogin.css">
    <link rel="icon" type="imag/jpg" href="Images/Icons/Dieabatecare.png">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 fw-light fs-5"> <B>Admin Login</B></h5>
                        <form method="post">
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Enter your username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Enter your password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <?php if(isset($error)) { ?>
                                <div class="text-danger"><?php echo $error; ?></div>
                            <?php } ?>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-login text-uppercase fw-bold" name="btnLogin" type="submit">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="Java Script/Admin.Js"></script>
</body>
</html>
