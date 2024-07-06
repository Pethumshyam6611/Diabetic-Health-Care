<?php
session_start();
require_once ('../data/conn.php');
require_once('../data/methods.php');
ob_start();
    if (isset($_SESSION['logged_username'])) {
        $username = $_SESSION['logged_username'];
        $user_id = $_SESSION['logged_id'];
        try {
            $conn = conn::getConnection();
    
            // Get the lab technician's information
            $sql = "SELECT `name`, `staff_id` FROM `lab_technician` WHERE `user_id` = :user_id";
            $query = $conn->prepare($sql);
            $query->execute([':user_id' => $user_id]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                $staff_id = $user['staff_id'];
                $name = $user['name'];
                $_SESSION['logged_name'] = $name;
            } else {
                echo 'No entry found for the lab technician.';
                exit; 
            }

        }catch (Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();

        }
}
else{
    echo "NOO";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Lab Tests</title>

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

<!--=============== CSS ===============-->
<link rel="stylesheet" href="../Css/Modalpopup.css">
<link rel="stylesheet" href="../Css/LabPastTests.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">


</head>

<body id="body-pd"> 
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <a href="#"  id="open-modal">
        <div class="header_img"> <img src="https://assets-global.website-files.com/65c34b372e0d029b28e1caee/65c38deedb3d098d178e7053_Human-centric%20approach-p-500.png" alt=""> </div>
    </a>
</header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list"> 
                <a href="LabHome.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a> 
                    <a href="LabPastTests.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Past Lab Tests</span> </a> 
                </div>
            </div> <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
       
    <br>

   
        <div class="row mt-5">
        <div class="col-md-5 mx-auto">
        <form method="post">
            <div class="input-group">
                <input class="form-control border-end-0 border" type="search" placeholder="Search Lab Test"  name="searchInput" id="example-search-input">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5" name="btnSearch" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
            </form>
        </div>
        <br>
        <br>
        <br>
        <br>
        
        <?php
            try {
                $conn = conn::getConnection();
                $sql = "SELECT patient.patient_id,patient.phn, patient.first_name, patient.last_name, 
                                test_request.request_id ,test_request.request_date, test_request.status, 
                                test_result.result_id,  test_result.date, test_result.result_value, test_result.note, test_result.result_attachment, 
                                lab_test.test_name
                FROM patient 
                INNER JOIN test_request ON patient.patient_id = test_request.patient_id
                INNER JOIN test_result ON test_request.request_id = test_result.request_id
                INNER JOIN lab_test ON test_request.test_id = lab_test.test_id
                WHERE test_request.status = :status";
                
                $queryParams = [':status' => "Confirm"];

                if (isset($_POST['btnSearch'])) {
                    $searchTerm = '%' . $_POST["searchInput"] . '%'; 
                    $sql .= " AND (patient.phn LIKE :searchTerm OR patient.first_name LIKE :searchTerm OR patient.last_name LIKE :searchTerm OR lab_test.test_name LIKE :searchTerm)";
                    $queryParams[':searchTerm'] = $searchTerm;
                }
                
                $query = $conn->prepare($sql);
                $query->execute($queryParams);
                $tests = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }

        ?>
        <div class="container">
                <div class="row">
                    
                    
                    <div class="col-md-12">
                    <h4>Lab Tests List</h4>
                    <div class="table-responsive">
                        <table id="mytable" class="table table-bordred table-striped">
                            <thead>
                                <th>PHN</th>
                                <th>Name</th>
                                <th>Requested Date</th>
                                <th>Test Date</th>
                                <th>Test Type</th>
                                <th>Result Value</th>
                                <th>Note</th>
                                <th>Attachment</th>
                            </thead>
                            <form action="" method="post"> <!-- Move the form outside the loop -->
    <tbody>
        <?php foreach ($tests as $test): ?>
            <tr>
                <td><?php echo $test['phn']; ?></td>
                <td><?php echo $test['first_name'] . " " . $test['last_name']; ?></td>
                <td><?php echo $test['request_date']; ?></td>
                <td><?php echo $test['date']; ?></td>
                <td><?php echo $test['test_name']; ?></td>
                <td><?php echo $test['result_value']; ?></td>
                <td><?php echo $test['note']; ?></td>
                <td>
                    <a href="view_attachement.php?result_id=<?php echo $test['result_id']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                </svg>View
                </a>
                </td>
            </tr>
        <?php endforeach; ?>   
    </tbody>
</form>
                    
                        </table>
                    </div>
                        
                    </div>
                </div>
            </div>
    </div>

    <!--Modal start-->    
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title">Account Details</h1>

                    <img src="../Images/images/Group-329.png" class="Profilepicture" srcset="">
                    <br>
                    <br>
                    <h5 class="details"><B>Staff ID:</B><span> <?php echo $staff_id; ?> </span></h5>
                    <h5 class="details"><B>Name:</B> <span> <?php echo $name; ?> </span></h5>
                    <h5 class="details"><B>Username:</B> <span> <?php echo $username; ?> </span></h5>

                </div>
            </div>
    <!--Modal end-->
    


    <!--Container Main end-->
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 

    

    </div> 
</body>
</html>