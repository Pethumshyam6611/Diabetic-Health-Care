<?php
session_start();
require_once('../data/conn.php');
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
    <title>Pharmacist Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../Css/Modalpopup.css">
    <link rel="stylesheet" href="../Css/PharamacyHome.css">
    <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>
<body id="body-pd"> 
    <?php
            // Check if user is logged in
        if (isset($_SESSION['logged_username'])) {
            $username = $_SESSION['logged_username'];
            $user_id = $_SESSION['logged_id'];
            try{
                $conn = conn::getConnection();
                $sql1 = "SELECT `name`,`staff_id` FROM `pharmacist` WHERE `user_id` = :user_id";
                $query1 = $conn->prepare($sql1);
                $query1->execute([':user_id' => $user_id]);
                $user= $query1->fetch(PDO::FETCH_ASSOC);
    
                if($user){
                    $staff_id = $user['staff_id'];
                    $name = $user['name'];
                    $_SESSION['logged_name'] = $name;
                }
                else {
                    echo 'no entry found';
                }
            }catch(Exception $e){
                echo 'Error' . $e->getMessage();
                exit;
            }

            try {
                $conn = conn::getConnection();
                
                $sql = "SELECT prescription.prescription_id, prescription.prescribed_date, patient.first_name, patient.last_name, patient.contact 
                        FROM prescription 
                        INNER JOIN patient ON prescription.patient_id = patient.patient_id";
                $query = $conn->query($sql);
                $prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                echo 'Error connecting to database: ' . $e->getMessage();
                exit;
            }
        } else {
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
                <div class="nav_list"> 
                    <a href="PharamacyHome.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a> 
                    <a href="PharamacyInventory.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Inventory</span> </a> 
                    <a href="PharamcyAddDrug.php" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Add Drugs</span> </a> 
                </div>
            </div> <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Sign Out</span> </a>
        </nav>
    </div>
    <div class="height-100 bg-light">
        <br><br><br>
            <div class="row mt-5">
                <div class="col-md-5 mx-auto">
                    <form method="post">
                            <div class="input-group">
                                <input class="form-control border-end-0 border" type="search" name="patientIDInput" placeholder="Search Patient" id="example-search-input">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5" type="submit" name="btnSearch">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                
                <?php
                    // Search functionality
                    if (isset($_POST['btnSearch'])) {
                        $searchTerm = $_POST['patientIDInput'];
                        $sql1 = "SELECT  `patient_id` ,`phn`, `first_name`, `last_name`, `contact` FROM `patient` WHERE `phn` LIKE :searchTerm OR `first_name` LIKE :searchTerm OR `last_name` LIKE :searchTerm";
                        $query1 = $conn->prepare($sql1);
                        $query1->execute([':searchTerm' => "%$searchTerm%"]);
                        $patients = $query1->fetchAll(PDO::FETCH_ASSOC);

                        $sql = "SELECT prescription.prescription_id, prescription.prescribed_date, patient.patient_id, patient.phn, patient.first_name, patient.last_name, patient.contact 
                                FROM prescription 
                                INNER JOIN patient ON prescription.patient_id = patient.patient_id 
                                WHERE prescription.p_status = 'Pending' 
                                AND (patient.phn LIKE :searchTerm OR patient.first_name LIKE :searchTerm OR patient.last_name LIKE :searchTerm OR patient.patient_id = :searchID)";
                        $query = $conn->prepare($sql);
                        $query->execute([':searchTerm' => "%$searchTerm%", ':searchID' => $searchTerm]);
                        $prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);
                    } else{
                        $sql = "SELECT prescription.prescription_id, prescription.prescribed_date, prescription.patient_id, patient.phn, patient.first_name, patient.last_name, patient.contact 
                                FROM prescription 
                                INNER JOIN patient ON prescription.patient_id = patient.patient_id
                                WHERE prescription.p_status = 'Pending'";
                        $query = $conn->prepare($sql);
                        $query->execute();
                        $prescriptions = $query->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?>
                <br>
                <br>
                <br>

                <div class="container">
                    <div class="row">
                    <div class="col-md-12">
                        <h4>Patient List</h4>
                        <div class="table-responsive">
                            <table id="mytable" class="table table-bordered table-striped">
                                <thead>
                                    <th>PHN</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Prescription</th>
                                </thead>
                                <tbody>
                                    <form action="" method="get">
                                    <?php foreach ($prescriptions as $prescription) : ?>
                                        <?php
                                         
                                        ?>
                                        <tr>
                                            <td><?php echo $prescription['phn']; ?></td>
                                            <td><?php echo $prescription['first_name'] . " " . $prescription['last_name']; ?></td>
                                            <td><?php echo $prescription['prescribed_date']; ?></td>
                                            <td>
                                            <button type="button" name="btnView" class="btn btn-primary btn-sm" onclick="viewPrescription('<?php echo $prescription['prescription_id']; ?>')">View</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </form>
                                </tbody>
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

                    <img src="../Images/images/pharacist.png" class="Profilepicture" srcset="">
                    <br>
                    <br>
                    <h5 class="details"><B>Staff ID:</B><span> <?php echo $staff_id; ?> </span></h5>
                    <h5 class="details"><B>Name:</B> <span> <?php echo $name; ?> </span></h5>
                    <h5 class="details"><B>Username:</B> <span> <?php echo $username; ?> </span></h5>
                    
                </div>
            </div>
    <!--Modal end-->

    
    <script>
        function viewPrescription(prescriptionId) {
            window.location.href = 'PharamacyPrescription.php?prescriptionId=' + prescriptionId;
        }
    </script>
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    </div> 
</body>
</html>
