<?php
  session_start();
  require_once ('../data/conn.php');
  require_once('../data/methods.php');
  ob_start();
  if(isset($_GET['prescriptionId'])) {
    $p_id = $_GET['prescriptionId'];
  } else {
    echo "Prescription ID not provided!";
  }

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Prescription</title>

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
<link rel="stylesheet" href="../Css/PharamacyPrescription.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>

<body id="body-pd"> 
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <a href="#"  id="open-modal">
        
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
    <!--Container Main start-->
    <div class="height-100 bg-light" id="main-div">
    
    <br>
    <br>

    <?php


        try{
            $conn = conn::getConnection();
            $query1 = $conn->prepare("SELECT prescription.prescription_id,prescription.patient_id, prescription.p_status,prescribed_medicine.frequency,
                                    prescribed_medicine.duration, prescribed_medicine.dosage,medicine.med_name	 
                                    FROM prescription 
                                    INNER JOIN prescription_prescribed_med ON prescription.prescription_id = prescription_prescribed_med.precription_id
                                    INNER JOIN prescribed_medicine ON prescription_prescribed_med.pmed_id = prescribed_medicine.pmed_id
                                    INNER JOIN medicine ON  prescribed_medicine.med_id = medicine.med_id
                                    WHERE prescription.prescription_id = :prescriptionId");
            $query1->bindParam(':prescriptionId', $p_id);
            $query1->execute();
            $prescription_data = $query1->fetchAll(PDO::FETCH_ASSOC);

        }catch (Exception $e){
            echo "Error: ".$e->getMessage();
        }
    ?>
    

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>Prescription</h4>
                    <div class="table-responsive">
                    <form action="" method="post">    
                    <table id="mytable"  class="table table-bordred table-striped">                            
                            <thead>
                                <th></th>
                                <th>Drug</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                            </thead>
                            <tbody>
                            
                                <?php foreach ($prescription_data as $prescription) : ?>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><?php echo $prescription['med_name']; ?></td>
                                    <td><?php echo $prescription['dosage']; ?></td>
                                    <td><?php echo $prescription['frequency']; ?></td>
                                    <td><?php echo $prescription['duration']; ?> </td>
                                </tr>   
                                <?php endforeach; ?>    
                            </tbody>
                    
                        </table>
                        <button type="submit" name="btnConfirm">Confirm</button>
                    </form>
                    </div>
                        
            </div>
        </div>
        
    </div>
    </div>

    <?php
    if(isset($_POST["btnConfirm"])){
        $precriptionId = $p_id;
        $query = $conn->prepare("UPDATE `prescription` SET `p_status`= :p_status WHERE `prescription_id` = :precriptionId");
        $query->execute([':p_status'=> "Confirm", ':precriptionId' => $precriptionId]);
    
        $_SESSION['prescription_confirmed_success'] = true;
        log_audit_trail("Prescription Manage", "Confirmed Prescription with DI: " .$p_id, $logged_username,$role);
        echo '<div class="alert alert-success" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 999;" role="alert">Prescription successfully confirmed!</div>';
        header("Refresh: 2; URL=PharamacyHome.php");
        ob_end_flush();
    }
?>

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
            }
        }
    ?>










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
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 

    

    </div> 
</body>
</html>