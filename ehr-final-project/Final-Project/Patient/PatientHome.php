<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');

    if(!isset($_SESSION['logged_username'])) {
        header("Location: logout.php");
        exit; 
       } 
      $logged_username = $_SESSION['logged_username'];
      $role = $_SESSION['logged_role']; 


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
    <title>Home</title>

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
<header class="header" id="header" style="background-color: #F0F1F3;">
    <div class="header_toggle"><i class='bx bx-menu' id="header-toggle"></i></div>
</header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list"> 
                    <a href="PatientHome.php" class="nav_link active"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/></svg><span class="nav_name">Home</span></a>
                    <a href="VisitsRecords.php" class="nav_link "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/></svg><span class="nav_name">Visits Records</span></a>
                    <a href="Prescription.php" class="nav_link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16"><path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/><path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z"/></svg><span class="nav_name">Prescription</span> </a> 
                    <a href="Labresult.php" class="nav_link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-pulse" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z"/></svg><span class="nav_name">Lab Results</span> </a> 
                    <a href="Lifestyleplan.php" class="nav_link"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg><span class="nav_name">Life Style Plan</span> </a> <a href="#" class="nav_link"></div>
            </div> 
                    <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
                   
        </nav>
    </div>
    <!--Container Main start-->
         <!--Prescreption View Modal start-->   
         <div class="modal__container" id="modal-container">
       <div class="modal__content" style="width: 100%; max-width: 425px;" id="prescriptionmodal">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>
                    <?php

                        $conn = conn::getConnection();
                        $sql = "SELECT appointment.appointment_id,appointment.date, appointment.status, appointment.patient_id, 
                                visit_record.bp_systolic, visit_record.bp_diastolic, visit_record.plus_rate, visit_record.glucose_level, visit_record.appoinment_id
                                FROM appointment
                                INNER JOIN visit_record ON appointment.appointment_id = visit_record.appoinment_id
                                WHERE appointment.patient_id = :pId AND appointment.status = :status
                                ORDER BY appointment.date DESC LIMIT 1";
                        $query = $conn->prepare($sql);
                        $query->execute([':pId' => $patient_id, ':status' => "Confirm"]);
                        $vitals = $query->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <div class="row">
                    <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Vital Sign</B></H5>
                <br>
                <div class="row d-flex " style="text-align: left;">
                    <div class="col mx-4">
                    <H6 style="color: black;"><img src="../Images/Icons/glucosemeter_4333055.png"><b>  Glucose</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/glucometer_8852600.png"><b>  BP Diastolic</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/heartrate.png"><b>  Heart Rate</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/glucometer_8852600.png"><b>  BP Systolic</b></H6>
                    </div>
                    <div class="col" style="text-align: left; margin-left:-30px">
                    <H6><?php echo $vitals['glucose_level'] ?></H6>
                    <H6 style="margin-top: 14px;"><?php echo $vitals['bp_diastolic'] ?></H6>
                    <H6 Style="margin-top: 14px;"><?php echo $vitals['plus_rate'] ?></H6>
                    <H6 Style="margin-top: 14px;"><?php echo $vitals['bp_systolic'] ?></H6>
                    </div>
                </div>
            </div>
                  </div>
                </div>
            </div>





      

    <!--Modal end-->
        
    <div class="container" style="width: fit-content;">
    <div class="row" style="margin-left: 11px;">
        <H2 style="-webkit-text-stroke: 1px black; color:black;margin-top: 15px;margin-bottom:15px">Home</H2>
        </div>
    <!--first row-->

    <?php

        $conn = conn::getConnection();
        $sql = "SELECT `phn`, `nic`, `first_name`, `last_name`, `name_with_intials`, `dob`, `gender`, `contact`, `email`, `picture`, `category_id` FROM `patient` WHERE `patient_id` = :pId";
        $query = $conn->prepare($sql);
        $query->execute([':pId' => $patient_id]);
        $patientInfo = $query->fetch(PDO::FETCH_ASSOC);


        $dob = $patientInfo['dob'];
        $dateOfBirth = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dateOfBirth)->y;
    ?>
        <div class="row">
            <div class="col-md-4 mx-4 d-flex "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
              
            <div class="col-md-8 py-4 px-4 text-center ">
            <?php
                if (!empty($patientInfo['picture'])) {
                $pictureData = base64_encode($patientInfo['picture']);
                $finfo = finfo_open();
                $mimeType = finfo_buffer($finfo, base64_decode($pictureData), FILEINFO_MIME_TYPE);
                finfo_close($finfo);
            
                $validTypes = ['image/jpeg', 'image/png']; 
            
                if (in_array($mimeType, $validTypes)) {
                    $pictureSrc = "data:$mimeType;base64,$pictureData";
                    echo "<img src='$pictureSrc' alt='Patient Picture' style='border-radius: 50%; width:100%'>";
                } else {
                    echo "<p>Invalid image type</p>";
                }
                } else {
                echo "<p>No picture available</p>";
                }
            ?>

                    
                    <div style="text-align: left;">
                    <h6 style="margin-left: 20px; color:black;margin-top: 5px"><b><?php echo $name ?></b></h6>  
                    <h6 style="margin-left: 20px; margin-top: -4px"><?php echo $patientInfo['nic'] ?></h6>
                    </div>
                </div>
                <div class="col py-4 px-4">
                    <div class="row">
                        <H6 style="color: black;"><B>Name:</B></H6>
                        <p><?php echo $patientInfo['first_name'] ?></p>
                    </div> 
                    <div class="row">
                        <H6 style="color: black;"><B>Age:</B></H6>
                        <p><?php echo $age ?></p>
                    </div>
                    <div class="row">
                        <H6 style="color: black;"><B>Gender:</B></H6>
                        <p><?php echo $patientInfo['gender'] ?></p>
                    </div>
                    <div class="d-flex">
                        <div>
                    <a href="PatientProfile.php?patientId=<?php echo $patient_id; ?>" class="btn btn-danger btn-sm" style="background-color:red" >View</a>
                        </div>

                    </div>  
                
            </div>
            </div>
            <br>
            <div class="col-md-6 mx-4"style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="row py-4 px-4">
            <H6 style="color: black;"><b>Next Appointment Date</b></H6>
            </div>
            <br>
            <br>
            <?php
                try{
                    $conn = conn::getConnection();
                    $sql = "SELECT `date`, `status` FROM `appointment` 
                            WHERE `patient_id` = :pId AND `status` = :status 
                            ORDER BY `date` DESC LIMIT 1";
                    $query = $conn->prepare($sql);
                    $query->execute([':pId' => $patient_id, ':status' => "Scheduled"]);
                    $nextAppointment = $query->fetch(PDO::FETCH_ASSOC);

                    $nextAppointmentDate = strtotime($nextAppointment['date']);
                    $currentDate = strtotime(date('Y-m-d'));
                    $daysUntilNextAppointment = floor(($nextAppointmentDate - $currentDate) / (60 * 60 * 24));

                } catch (Exception $e){
                    echo 'Error connecting to database: ' . $e->getMessage();
                }
                        
            ?>           

            <div class="row text-center">
            <H1 style="color: black;"><b><?php echo $nextAppointment['date']?></b></H1>
            <p>  <?php echo $daysUntilNextAppointment; ?> Days Until Next Appointment</p>
            </div>
            </div>
        </div>
        <br>

    <!--second row-->
    <?php
        try {
            $conn = conn::getConnection();
            $sql = "SELECT test_result.result_id, test_result.date, test_result.result_id, lab_test.test_name
                    FROM test_result 
                    INNER JOIN test_request ON test_result.request_id  = test_request.request_id
                    INNER JOIN lab_test ON test_request.test_id = lab_test.test_id
                    WHERE test_request.patient_id = :pId
                    ORDER BY test_result.date DESC LIMIT 1";
            $query = $conn->prepare($sql);
            $query->execute([':pId'=>$patient_id]);
            $latestLabTest = $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
        }
    ?>
        <div class="row">

            <div class="col-md-4 mx-4" id="latestlabres">
                <div class="col-md-16 " style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; height: 100px; margin-left:-12px; margin-right:-12px" id="latestlabres">
                    <div class="row py-4 px-4">
                        <H6 style="color: black;"><b>Latest Lab Tests:</b></H6>
                    
                        <?php if (!empty($latestLabTest)) : ?>
                            <a href="LatestLabResult.php?resultId=<?php echo $latestLabTest['result_id']; ?>"><h6 style="color: black;">
                            <img src="../Images/Icons/document_13530164.png" width="30px" alt="Blood Test Icon">
                            <b> <?php echo $latestLabTest['test_name']; ?> Result</b>
                            
                        <?php else : ?>
                            <p>No lab test results available.</p>
                        <?php endif; ?>        
                    </div>
                
         
                 </div>
                <br>
                <?php
                    try {
                        $conn = conn::getConnection();
                        $sql = "SELECT `prescription_id`, `prescribed_date`, `p_status`, `patient_id` FROM `prescription`
                                WHERE `patient_id`  = :pId
                                ORDER BY `prescribed_date` DESC LIMIT 1";
                        $query = $conn->prepare($sql);
                        $query->execute([':pId'=>$patient_id]);
                        $latestPresc = $query->fetch(PDO::FETCH_ASSOC);
                    } catch (Exception $e) {
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                ?>
                <div class="col-md-16 " style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; height: 100px; margin-left:-12px;margin-right:-12px" id="latestlabres">
                    <div class="row py-4 px-4">
                        <H6 style="color: black;"><b>Latest Prescription:</b></H6>
                    
                        <?php if (!empty($latestPresc)) : ?>
                            <a href="LatestPrescription.php?presId=<?php echo $latestPresc['prescription_id']; ?>"><h6 style="color: black;">
                            <img src="../Images/Icons/document_13530164.png" width="30px" alt="Blood Test Icon">
                            <b> <?php echo $latestPresc['prescribed_date']; ?> </b>
                        </a>
                        <?php else : ?>
                            <p>No new prescriptions available.</p>
                        <?php endif; ?>
                
                    </div>
                
         
                </div>

            </div>
        
         

            
            <br>
            <div class=" row col-md-6 mx-4 d-flex" style="align-items:center; background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class=" row"  style="align-items:center;">
            <div class=" col-md-6 py-4 " id="functions">
                    <a href="Labresult.php">  
                        <div class="col-md-12 mx-4" style="background-color: white; border: 1px solid #41A5EE; border-radius:18px;" id="funtion1">
                        <div class="d-flex justify-content-center">

                            <div class="py-2 d-flex align-items-center">
                            <img src="../Images/Icons/flask_3034736.png" style="width:40px ;height:40px">
                            </div>

                            <div class="py-2 mx-3 d-flex align-items-center">
                            <h4><b>Lab Result</b></h4>
                            </div>

                        </div>
                        </div>
                    </a>
                    </div>

                    <div class=" col-md-6   " id="functions">
                    <a href="Prescription.php">  
                        <div class="col-md-12 mx-4" style="background-color: white; border: 1px solid #41A5EE; border-radius:18px;">
                        <div class="d-flex justify-content-center">

                            <div class="py-2 d-flex align-items-center">
                            <img src="../Images/Icons/invoice_2709484 (1).png" style="width:40px ;height:40px">
                            </div>

                            <div class="py-2 mx-3 d-flex align-items-center">
                            <h4><b>Prescription</b></h4>
                            </div>

                        </div>
                        </div>
                    </a>
                    </div>

                    <br>
                    




                
</div>
<div class=" row d-flex"  style="align-items:center;">
            <div class=" col-md-6 py-4" id="functions">
                    <a href="Lifestyleplan.php">  
                        <div class="col-md-12 mx-4" style="background-color: white; border: 1px solid #41A5EE; border-radius:18px;" id="funtion1">
                        <div class="d-flex justify-content-center">

                            <div class="py-2 d-flex align-items-center">
                            <img src="../Images/Icons/diet_8119294.png" style="width:40px ;height:40px">
                            </div>

                            <div class="py-2 mx-3 d-flex align-items-center">
                            <h4><b>Lifestyle Plan</b></h4>
                            </div>

                        </div>
                        </div>
                    </a>
                    </div>

                    <div class="col-md-6 " id="functions">
                    <a href="#" id="open-modal">  
                        <div class="col-md-12 mx-4" style="background-color: white; border: 1px solid #41A5EE; border-radius:18px;">
                        <div class="d-flex justify-content-center">

                            <div class="py-2 d-flex align-items-center">
                            <img src="../Images/Icons//love_9073386.png" style="width:40px ;height:40px">
                            </div>

                            <div class="py-2 mx-3 d-flex align-items-center">
                            <h4><b>Vital Sign</b></h4>
                            </div>

                        </div>
                        </div>
                    </a>
                    </div>
                
                    




                
</div>
<br>
<br>       




          
        </div>
        <br>
        <br>
    </div>
    
    <!--Container Main end-->
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
    
    <style>
    .container {
    margin-left: 3rem;
    margin-right: 1rem;}

    #latestlabre{
        width: auto;
        height: 15px;
    }
    @media (max-width: 767px) { 
    .col-md-6{  
      flex-direction: column; 
    }
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