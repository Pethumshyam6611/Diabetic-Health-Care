<?php
    session_start();
    require_once ('../data/conn.php');
	require_once('../data/methods.php');


    if(isset($_SESSION['patient_added_success']) && $_SESSION['patient_added_success'] == true) {
        echo '<div class="alert alert-success" role="alert">Patient successfully added!</div>';
        unset($_SESSION['patient_added_success']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reciption Home</title>

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
            $sql = "SELECT `name`,`staff_id` FROM `receptionist` WHERE `user_id` = :user_id";
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
                <div class="nav_list"> 
                    <a href="ReciptionHome.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a> 
                    <a href="PReg1.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Register</span> </a> 

                </div>
            </div> <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light" >
       
    <br>
    <br>
    <br>
   
        <div class="row mt-5">
        <div class="col-md-5 mx-auto">
            <form method="post">
                <div class="input-group">
                    <input class="form-control border-end-0 border" name="patientIDInput" type="search" placeholder="Search Patient" id="example-search-input">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5" 
                                name="btnSearch" type="submit">
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

            if (isset($_SESSION['logged_username'])) {
                try{
                    if(isset($_POST['btnSearch'])){
                        $searchTerm = $_POST['patientIDInput'];
                        $sql1 = "SELECT  `patient_id` ,`phn`,`nic`, `first_name`, `last_name`, `contact` FROM `patient` 
                                WHERE `phn` LIKE :searchTerm OR `nic` LIKE :searchTerm OR `first_name` LIKE :searchTerm OR `last_name` LIKE :searchTerm";
                        $query1 = $conn->prepare($sql1);
                        
                        $query1->execute([':searchTerm' => "%$searchTerm%"]);
                        $patients = $query1->fetchAll(PDO::FETCH_ASSOC);
                    
                    } else {
                        $sql1 = "SELECT `patient_id`, `phn`,`nic`, `first_name`, `last_name`, `contact` FROM `patient`";
                        $query1 = $conn->prepare($sql1);
                        $query1->execute();
                        $patients = $query1->fetchAll(PDO::FETCH_ASSOC);
                    }

                    if($patients){



        ?>
        <div class="container" >
                <div class="row">
                    <div class="col-md-12">
                    <h4>Patient List</h4>
                    <div class="table-responsive">  
                          <table id="mytable" class="table table-bordred table-striped">
                               <thead>
                                    <th>PHN</th>
                                    <th>NIC</th>
                                    <th>Name</th>
                                    <th>Contact Number</th>
                                    <th>Action</th>
                               </thead>
                               
                                <tbody>
                                    <?php foreach ($patients as $patient) : ?>
                                    <tr>
                                        <td>
                                            <?php echo $patient['phn']; ?>
                                        </td>
                                        <td>
                                            <?php echo $patient['nic']; ?>
                                        </td>
                                        <td>
                                            <?php echo $patient['first_name'] . " " . $patient['last_name']; ?>
                                        </td>
                                        <td>
                                            <?php echo $patient['contact']; ?>
                                        </td>
                                        <td><button type="button" name="btnView" class="btn btn-primary btn-sm" onclick="viewPatient('<?php echo $patient['patient_id']; ?>')">View</button></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                    
                            </table>   
                        </div>
                        
                    </div>
                </div>
            </div>
    </div>

    <?php
            } else {
                        echo "No patients found";
                    }
                } catch(Exception $e){
                    echo "ERROR: ".$e->getMessage();
                }

            } else {
                echo '<p>You are not logged in.</p>';
            }


        ?>


    <script>
        function viewPatient(patientID) {
        window.location.href = 'RecipPatientDetailsView.php?patientID=' + patientID;
    }
    </script>







    <!--Modal start-->    
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title">Account Details</h1>

                    <img src="../Images/images/Lovepik_com-450074748-reception desk vector in modern style.png" class="Profilepicture" srcset="">
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