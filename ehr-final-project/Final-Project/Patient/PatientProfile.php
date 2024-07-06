<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');

    if (isset($_SESSION['logged_username'])) {
        $username = $_SESSION['logged_username'];
        $user_id = $_SESSION['logged_id'];

        try {
            $conn = conn::getConnection();
            $sql = "SELECT `first_name`, `last_name`, `patient_id` FROM `patient` WHERE `user_id` = :user_id";
            $query = $conn->prepare($sql);
            $query->execute([':user_id' => $user_id]);
            $userInfo = $query->fetch(PDO::FETCH_ASSOC);

            if ($userInfo) {
                $patient_id = $userInfo['patient_id'];
                $name = $userInfo['first_name'] . ' ' . $userInfo['last_name'];
                $_SESSION['logged_name'] = $name;
                $_SESSION['logged_patientId'] = $patient_id;
            } else {
                echo 'No entry found';
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

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
  <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
<!--=============== CSS ===============-->
<link rel="stylesheet" href="../Css/Modalpopup.css">
<link rel="stylesheet" href="../Css/ReciptionHome.css">

</head>

<body id="body-pd" style="background-image:url(../Images/images/bg23.jpg); background-size: 100% auto; "> 

<header class="header" id="header" style="background-color: rgba(240, 241, 243, 0); ">
        <a href="../Patient/PatientHome.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="purple" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
            </svg>
        </a>  



</header>

    <!--Container Main start-->
   
        
    <div class="container" style="max-width: fit-content;">
    <div class="row" style="margin-left: 11px;">
        <H2 style="-webkit-text-stroke: 1px black; color:black; margin-bottom: 30px;">Patient Profile</H2>
    </div>
    <?php
        try{
            $conn = conn::getConnection();
            $sql = "SELECT `phn`, `nic`, `first_name`, `last_name`, `name_with_intials`, `dob`, `house_no`, `street`, `city`, `gender`, 
                    `contact`, `email`, `picture`, `emergency_contact_id`, `category_id`  FROM `patient` WHERE `patient_id` = :pId";
            $query = $conn->prepare($sql);
            $query->execute([':pId' => $patient_id]);
            $patientInfo = $query->fetch(PDO::FETCH_ASSOC);


        } catch (Exception $e){
            echo 'Error connecting to database: ' . $e->getMessage();
        }
                
    ?>
    <!-- first row-->
    <div class="row">
            <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            
            <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Personal Details</B></H5>
                <br>
                <br>
                <div class="d-flex flex-wrap">
                <div class="row d-flex " style="text-align: left;">
                    <div class="col-6 mx-4 " id="personald">

                    <?php
                           if (!empty($patientInfo['picture'])) {
                            $pictureData = base64_encode($patientInfo['picture']);
                            $finfo = finfo_open();
                            $mimeType = finfo_buffer($finfo, base64_decode($pictureData), FILEINFO_MIME_TYPE);
                            finfo_close($finfo);
                        
                            $validTypes = ['image/jpeg', 'image/png']; 
                        
                            if (in_array($mimeType, $validTypes)) {
                              $pictureSrc = "data:$mimeType;base64,$pictureData";
                              echo "<img src='$pictureSrc' alt='Patient Picture' style='border-radius: 50%; margin-top:15px'>";
                            } else {
                              echo "<p>Invalid image type</p>";
                            }
                          } else {
                            echo "<p>No picture available</p>";
                          }
                        ?>



                    </div>
                    <div class="col-5" style="text-align: left; margin-left:-30px" id="personald">
                    <div class="row">
                        <h6 style="color: black;"><B>PHN:</B></h6>
                        <h6><?php echo $patientInfo['phn'] ?></h6>
                    </div>
                    <div class="row">
                    <h6 style="color: black;"><B>NIC:</B></h6>
                    <h6><?php echo $patientInfo['nic'] ?></h6>
                    </div>
                    <div class="row">
                    <h6 style="color: black;"><B>Name:</B></h6>
                    <h6><?php echo $patientInfo['first_name'] ?></h6>
                    <h6><?php echo $patientInfo['last_name'] ?></h6>
                    <h6><?php echo $patientInfo['name_with_intials'] ?></h6>
                    </div>
                    <div class="row">
                    <h6 style="color: black;"><B>Date Of Birthday:</B></h6>
                    <h6><?php echo $patientInfo['dob'] ?></h6>
                    </div>
                    </div>
                </div>
            </div>
            </div>
                
            </div>
            <br>
            <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Contact Details</B></H5>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Address-->    
                        <H6 style="color: black;"><b>Address:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $patientInfo['house_no'] ?></H6></span>
                            <span><H6 style="margin-left: 20px;"><?php echo $patientInfo['street'] ?></H6></span>
                            <span><H6 style="margin-left: 20px;"><?php echo $patientInfo['city'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Phone number-->
                        <H6 style="color: black;"><b>Phone Number:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $patientInfo['contact'] ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Email-->
                        <H6 style="color: black;"><b>Email Address:
                        <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $patientInfo['email'] ?></H6></span>
                        </b></H6>
                        </div>
                        </div>
                    </div>
                </div>
               
                    
                </div>
            <!-- second row-->
            <?php
                $emergency_id = $patientInfo['emergency_contact_id'];
                try{
                    $conn = conn::getConnection();
                    $sql = "SELECT `name`, `relationship`, `contact` FROM `emergency_contact` WHERE `contact_id` = :eId";
                    $query = $conn->prepare($sql);
                    $query->execute([':eId' => $emergency_id]);
                    $contactInfo = $query->fetch(PDO::FETCH_ASSOC);


                } catch (Exception $e){
                    echo 'Error connecting to database: ' . $e->getMessage();
                }
                        
            ?>
                <div class="row " style="margin-top: 10px;">
                <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Emergency Contact Details</B></H5>
                    <br>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Name-->    
                        <H6 style="color: black;"><b>Name:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $contactInfo['name'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--relationship-->
                        <H6 style="color: black;"><b>Relationship:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $contactInfo['relationship'] ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Phonenumber-->
                        <H6 style="color: black;"><b>Phonenumber:
                        <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $contactInfo['contact'] ?></H6></span>
                        </b></H6>
                        </div>                                             
                        </div>
                    </div>
                </div>
            <br>

            <?php
                try{
                    $conn = conn::getConnection();
                    $sql = "SELECT `diagnosis_id`,`diabetes_type`, `date` FROM `diagnosis` WHERE `patient_id`= :pId";
                    $query = $conn->prepare($sql);
                    $query->execute([':pId' => $patient_id]);
                    $diagnosisInfo = $query->fetch(PDO::FETCH_ASSOC);

                    $diagnosisId = $diagnosisInfo['diagnosis_id'];

                } catch (Exception $e){
                    echo 'Error connecting to database: ' . $e->getMessage();
                }
                        
            ?>
            <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Diagnosis</B></H5>
                    <br>
                    
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Diabetes Type-->    
                        <H6 style="color: black;"><b>Diabetes Type:<span><H6 style="margin-left: 20px;"><?php echo $diagnosisInfo['diabetes_type'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Phone number-->
                        <H6 style="color: black;"><b>Diagnosis Date:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $diagnosisInfo['date'] ?></H6></span>
                        </b></H6>
                        <br>
                        </div>                                             
                        </div>
                    </div>
                </div>
               
                    
                </div>



                <!-- third row-->
                <?php
                    try{
                        $conn = conn::getConnection();
                        $sql = "SELECT  `history_id`,`reffered_by`, `substance_use`, `medication_on`, `allergies`, `med_conditions` FROM `history` WHERE `patient_id`= :pId";
                        $query = $conn->prepare($sql);
                        $query->execute([':pId' => $patient_id]);
                        $historyInfo = $query->fetch(PDO::FETCH_ASSOC);

                        $historyId = $historyInfo['history_id'];
                    } catch (Exception $e){
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                        
                ?>

                <div class="row " style="margin-top: 10px;">
                <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; ">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>History</B></H5>
                    <br>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--RefferdBy-->    
                        <H6 style="color: black;"><b>Refferd By:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $historyInfo['reffered_by'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Current Medication-->
                        <H6 style="color: black;"><b>Current Medication:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $historyInfo['medication_on'] ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Pastmedical-->
                        <H6 style="color: black;"><b>Past Medical History:
                        <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $historyInfo['med_conditions'] ?></H6></span>
                        </b></H6>
                        </div>      
                        <div class="col mx-4">
                         <!--Substance Use-->    
                        <H6 style="color: black;"><b>Substance Use:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $historyInfo['substance_use'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Allergie-->
                        <H6 style="color: black;"><b>Allergies:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $historyInfo['allergies'] ?></H6></span>
                        </b></H6>
                        <br>
                        </div>                                                
                        </div>
                    </div>
                    
                </div>
                <br>

                <?php
                    try{
                        $conn = conn::getConnection();
                        $sql = "SELECT `complication`, `type` FROM `complication` WHERE  `diagnosis_id` = :dId";
                        $query = $conn->prepare($sql);
                        $query->execute([':dId' => $diagnosisId]);
                        $compInfo = $query->fetchAll(PDO::FETCH_ASSOC);


                    } catch (Exception $e){
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                        
                ?>

                <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; ">
                
                    <div class="row py-4  text-center">
                        <H5 style="color: black;"><B> Complication</B></H5>
                        <br>
                        <br>
                            <div class="row d-flex " style="text-align: left;">
                                <div class="col mx-4">
                                    <?php foreach ($compInfo as $comp) : ?>
                                        <H6 style="color: black;"><b>
                                        <span><H6 style="margin-left: 20px;"><?php echo $comp['complication'] ?></H6></span>
                                    <?php endforeach; ?> 
                                </div>                                                
                            </div>
                    </div>
                    

                <br>
 
            </div>

            <!-- fourth row-->
                <?php
                    try{
                        $conn = conn::getConnection();
                        $sql = "SELECT `name`, `relationship`, `disease` FROM `family_history` WHERE `history_id`= :hId";
                        $query = $conn->prepare($sql);
                        $query->execute([':hId' => $historyId]);
                        $fInfo = $query->fetch(PDO::FETCH_ASSOC);


                    } catch (Exception $e){
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                        
                ?>

                <div class="row " style="margin-top: 10px;">
                <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; ">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Family History</B></H5>
                    <br>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Name-->    
                        <H6 style="color: black;"><b>Name:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $fInfo['name'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Relationship-->
                        <H6 style="color: black;"><b>Relationship:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $fInfo['relationship'] ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Disease-->
                        <H6 style="color: black;"><b>Disease:
                        <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $fInfo['disease'] ?></H6></span>
                        </b></H6>
                        </div>                                               
                        </div>
                    </div>
                    
                </div>
                <br>
                <div class="col-md-5 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; ">
                

                <?php
                    try{
                        $conn = conn::getConnection();
                        $sql = "SELECT  `occupation`, `edu_level` FROM `social_history` WHERE `history_id` = :hId";
                        $query = $conn->prepare($sql);
                        $query->execute([':hId' => $historyId]);
                        $sInfo = $query->fetch(PDO::FETCH_ASSOC);


                    } catch (Exception $e){
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                        
                ?>
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Social History</B></H5>
                    <br>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Occupation-->    
                        <H6 style="color: black;"><b>Occupation:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $sInfo['occupation'] ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Educational Level-->
                        <H6 style="color: black;"><b>Educational Level:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $sInfo['edu_level'] ?></H6></span>
                        </b></H6>
                        
                        </div>                                                
                        </div>
                    </div>
                    
                </div>
            <br>
        </div>
    </div>
    <!-- second row-->
    </div>
</div>
                       
</div>
<br>
<br>       
    
    <!--Container Main end-->
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    
    <style>
       
        .table-wrapper {
    overflow-y: auto;
    }  
    .container {
    margin-left: 3rem;
    margin-right: 1rem;}

    #latestlabre{
        width: auto;
        height: 15px;
    }
    @media (max-width: 767px) { 
       
    .col-md-5 {
    margin-left: 0px; 
    }
    .col-md-5 {
    margin-left: 0px;  
    margin-right: 0px; 
    }
    .container {
    margin-left: -1.5rem;
    }
     #personald{
            flex-direction: column;
        }   
  
    }


    #functions {
    transition: transform 190ms ease-out;

    }

    #functions:hover {
    transform: translate(0px, 0px) scale(1.1, 1.2);
    }
</style>
    
</body>
</html>