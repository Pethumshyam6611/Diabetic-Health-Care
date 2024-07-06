<?php
  session_start();
  require_once ('../data/conn.php');
  require_once('../data/methods.php');
  ob_start();

  if(isset($_GET['med_id'])) {
    $med_id = $_GET['med_id'];
  } else {
    echo "Medicine ID not provided!";
    header("Location: PharamacyHome.php");
      
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
    <title>Edit Drug</title>

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
<link rel="stylesheet" href="../Css/PharamacyEditDrug.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>

<body id="body-pd"> 
<?php
    try{
        $conn = conn::getConnection();
        $sql = $conn->prepare("SELECT `med_id`, `med_name`, `type`, `status`, `supplier_name`, `manu_date`, `exp_date` 
                            FROM `medicine` WHERE `med_id` = :med_id");
        $sql->execute([':med_id' => $med_id]);
        $med = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($med)) {
            $med = $med[0];
        } else {
            echo "Medicine not found!";
        }

    } catch (Exception $e){
        echo "Error: ".$e->getMessage();
    }
?>
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
    <div class="height-100 bg-light">
    <h4><center>Edit Drug</center></h4>

    <br>
        <form method="post">
            <div class="add-drug-container">
                <div class="div-1">
                    <br><br>
                        <label>Name</label>
                        <h4><?php echo $med['med_name']; ?></h4>
                    <br>
                        <label>Status</label>
                        <select id=""  name="availibilty">
                            <?php  
                                if (($med['status']) == "Available"){
                                    echo '<option value="Available" selected>Available</option>
                                    <option value="Unavailable">Unavailable</option>';
                                } else{
                                    echo '<option value="Available" >Available</option>
                                    <option value="Unavailable" selected>Unavailable</option>';
                                }
                             ?>

                        </select>

                    <br><br>
                        <label>Manufacter Date</label>
                        <input type="date" value="<?php echo $med['manu_date']; ?>" name="mfd" id="datepicker">

                </div>
                <div class="div-1">
                    <br><br>
                        <label>Type</label>
                        <h4><?php echo $med['type']; ?></h4>
                    <br>
                        <label>Supplier</label>
                        <input type="text" value="<?php echo $med['supplier_name']; ?>" name="supplier" placeholder="Name" id="" required> 
                        
                    <br><br>
                        <label>Expiry Date</label>
                        <input type="date" value="<?php echo $med['exp_date']; ?>" name="exp" id="datepicker" required>
                </div>
                    
            </div>
            <button type="submit" name="btnUpdate">Update</button>
        </form>
    </div>


    <?php
        if(isset($_POST['btnUpdate'])){
            $medStatus= $_POST["availibilty"];
            $medManuDate = $_POST["mfd"];

            $medSupplier = $_POST["supplier"];
            $medExp = $_POST["exp"];

            try{
                $sql1 = $conn->prepare("UPDATE `medicine` SET
                                        `status`= :medStatus,`supplier_name`= :medSupplier,
                                        `manu_date`= :medManu,`exp_date`=:medExp WHERE `med_id` = :med_id");
                $sql1->execute([
                    ':medStatus' => $medStatus,
                    ':medSupplier' => $medSupplier,
                    ':medManu' => $medManuDate,
                    ':medExp' => $medExp,
                    ':med_id' => $med_id
                ]);

                $_SESSION['prescription_confirmed_success'] = true;
                log_audit_trail("Drug Inventory Manage", "Updated Drug with ID: " .$med_id, $logged_username,$role);
                echo '<div class="alert alert-success" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 999;" role="alert">Drug successfully updated!</div>';
                header("Refresh: 2; URL=PharamacyInventory.php");
                ob_end_flush();
                
            } catch (Exception $e){
                echo "Error: ".$e->getMessage();
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
                    <h5 class="details"><B>Name:</B> <span>Pethum</span></h5>
                    <h5 class="details"><B>Username:</B> <span>Pethum</span></h5>
                    <h5 class="details"><B>ID:</B><span>Pethum</span></h5>

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