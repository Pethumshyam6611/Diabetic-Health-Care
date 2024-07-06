<?php
    session_start();
    require_once ('../data/conn.php');
	require_once('../data/methods.php');

    if(!isset($_SESSION['logged_username'])) {
        header("Location: logout.php");
        exit; 
       }
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home</title>

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
<link rel="stylesheet" href="../Css/ReciptionHome.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>

<body id="body-pd"> 

<?php

    if (isset($_SESSION['logged_username'])) {
        $username = $_SESSION['logged_username'];
        $user_id = $_SESSION['logged_id'];

        try{
            $conn = conn::getConnection();
            $sql = "SELECT `name`,`staff_id` FROM `doctor` WHERE `user_id` = :user_id";
            $query = $conn->prepare($sql);
            $query->execute([':user_id' => $user_id]);
            $user= $query->fetch(PDO::FETCH_ASSOC);

            if($user){
                $staff_id = $user['staff_id'];
                $name = $user['name'];
                $_SESSION['logged_name'] = $name;
            }
            else {
                echo 'no entry found';
            }
            
        } catch (Exception $e){
            echo 'Error connecting to database: ' . $e->getMessage();
            exit;
        }
    } 
    else{
        echo '<p>You are not logged in.</p>';
    }
?>
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <a href="#"  id="open-modal">
    <div class="header_img"> <img src="https://assets-global.website-files.com/65c34b372e0d029b28e1caee/65c38deedb3d098d178e7053_Human-centric%20approach-p-500.png" alt=""> </div>
    </a>
</header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list"> <a href="#" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a><a href="#" class="nav_link"></div>
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
                    <input class="form-control border-end-0 border" name="patientIDInput" type="search" placeholder="Search Patient" id="example-search-input">
                    <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5" type="submit" name="btnSearch">
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
        
        // Search
        if (isset($_POST['btnSearch'])) {
            $searchTerm = $_POST['patientIDInput'];
            $sql = "SELECT patient.patient_id,patient.phn, patient.user_id, patient.first_name, patient.last_name, patient.category_id,
                    diagnosis.diabetes_type
                    FROM patient 
                    INNER JOIN diagnosis ON patient.patient_id = diagnosis.patient_id 
                    WHERE patient.phn LIKE :searchTerm OR patient.first_name LIKE :searchTerm OR patient.last_name LIKE :searchTerm";
            $query = $conn->prepare($sql);
            $query->execute([':searchTerm' => "%$searchTerm%"]);
            $patients = $query->fetchAll(PDO::FETCH_ASSOC);

        } else {
            $sql = "SELECT patient.patient_id,patient.phn, patient.user_id, patient.first_name, patient.last_name, patient.category_id,
                    diagnosis.diabetes_type
                    FROM patient 
                    INNER JOIN diagnosis ON patient.patient_id = diagnosis.patient_id";
            $query = $conn->prepare($sql);
            $query->execute();
            $patients = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        

        
    } catch (Exception $e) {
        echo 'Error connecting to database: ' . $e->getMessage();
        exit;
    }
?>

        <form action="" method="get">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Patient List</h4>
                            <div class="table-responsive">
                                <table id="mytable" class="table table-bordred table-striped">
                               
                                    <thead>
                                    <th>PHN</th>
                                    <th>Name</th>
                                    <th>Diabetes Mellitus </th>
                                    <th>Action</th>
                                    </thead>
                
                                    <tbody>
                
                                    <?php if (empty($patients)) : ?>
                                        <tr>
                                            <td colspan="4">No results found.</td>
                                        </tr>
                                    <?php else : ?>
                                        <?php foreach ($patients as $patient) : ?>
                                            <tr style="background-color: <?php echo ($patient['category_id'] == 1) ? '#ffbbbb' :
                                             (($patient['category_id'] == 2) ? '#ffe0af' :(($patient['category_id'] == 3) ? '#e6ffea' : '')); ?>">
                                                <td><?php echo $patient['phn']; ?></td>
                                                <td><?php echo $patient['first_name'] . " " . $patient['last_name']; ?></td>
                                                <td><?php echo $patient['diabetes_type']; ?></td>
                                                <td>
                                                    <input type="hidden" name="category" <?php echo $patient['category_id']; ?>>
                                                    <button type="button" name="btnView" class="btn btn-primary btn-sm" onclick="viewPatient('<?php echo $patient['patient_id']; ?>')">View</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                      
                                    </tbody>
                     
                                </table>

                            
                            </div>
                        
                    </div>
                </div>
            </div>
            </form> 
        </div>












    <!--Modal start-->    
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title">Account Details</h1>

                    <img src="../Images/images/pngwing.com.png" class="Profilepicture" srcset="">
                    <br>
                    <br>
                    <h5 class="details"><B>Staff ID:</B><span> <?php echo $staff_id; ?> </span></h5>
                    <h5 class="details"><B>Name:</B> <span> <?php echo $name; ?> </span></h5>
                    <h5 class="details"><B>Username:</B> <span> <?php echo $username; ?> </span></h5>
                </div>
            </div>
    <!--Modal end-->
    


    <!--Container Main end-->
    <script>
        function viewPatient(patientId) {
            window.location.href = 'DoctorPatientView.php?patientId=' + patientId;
        }
    </script>
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 

    

    </div> 
</body>
</html>