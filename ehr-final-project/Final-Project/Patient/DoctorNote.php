<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');
    if(isset($_GET['id'])) {
    
        $appointmentId = $_GET['id'];
        try {
            $conn = conn::getConnection();
            $sql = "SELECT * FROM appointment WHERE appointment_id = :appointmentId";
            $query = $conn->prepare($sql);
            $query->execute([':appointmentId' => $appointmentId]);
            $appointment = $query->fetch(PDO::FETCH_ASSOC);

        
        } catch (Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
        }
    } else {
        header("Location: PatientHome.php");
        exit; 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Visit Record</title>

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

<body id="body-pd" style="background-image:url(../Images/images/bg23.jpg); background-size: 100% auto; padding:0%; "> 
    <header class="header" id="header" style="background-color: rgba(240, 241, 243, 0); ">
        <a href="../Patient/VisitsRecords.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="purple" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
            </svg>
        </a>
    </header>
    
    <!--Container Main start-->
   <?php
   try{
        $conn = conn::getConnection();
        $sql = "SELECT `bp_systolic`, `bp_diastolic`, `plus_rate`, `glucose_level`, `patient_concerns`, `patient_condition`, `instructions`, `note`, `appoinment_id` FROM `visit_record` WHERE `appoinment_id` = :id";
        $query = $conn->prepare($sql);
        $query->execute([':id'=> $appointmentId]);
        $record = $query->fetch(PDO::FETCH_ASSOC);

        $a_id = $record['appoinment_id'];
        $queryTests = $conn->prepare("SELECT test_request.request_id, test_request.status, test_request.test_id, test_request.appointment_id,lab_test.test_name 
                                    FROM test_request
                                    LEFT JOIN lab_test ON  test_request.test_id = lab_test.test_id
                                    WHERE test_request.appointment_id = :aId");
        $queryTests->execute([':aId'=> $a_id]);
        $tests = $queryTests->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        echo 'Error connecting to database: ' . $e->getMessage();
    }

   ?>
        
    <div class="container" style="max-width: fit-content; padding-left: 20%;">
    <div class="row" style="margin-left: 11px;">
        <H2 style="-webkit-text-stroke: 1px black; color:black; margin-bottom: 40px;">Doctor Note</H2>
    </div>

    <!-- first row-->
    <div class="row">
            <div class="col-md-4 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
            <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Vital Sign</B></H5>
                <br>
                <div class="row d-flex " style="text-align: left;">
                    <div class="col mx-4">
                    <H6 style="color: black;"><img src="../Images/Icons/glucosemeter_4333055.png"><b>Glucose Level</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/glucometer_8852600.png"><b>BP Diastolic</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/heartrate.png"><b>Heart Rate</b></H6>
                    <H6 style="color: black;"><img src="../Images/Icons/glucometer_8852600.png"><b>BP Systolic</b></H6>
                    </div>
                    <div class="col" style="text-align: left; margin-left:-30px">
                    <H6><?php echo $record['glucose_level']; ?></H6>
                    <H6 style="margin-top: 14px;"><?php echo $record['bp_diastolic']; ?></H6>
                    <H6 Style="margin-top: 14px;"><?php echo $record['plus_rate']; ?></H6>
                    <H6 Style="margin-top: 14px;"><?php echo $record['bp_systolic']; ?></H6>
                    </div>
                </div>
            </div>
           
                
            </div>
            <br>
            <div class="col-md-4 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Requested Lab Test</B></H5>
                    <br>
                    <div class="row d-flex " style="text-align: left;">
                    <div class="table-wrapper" style="height: 129px;">
                        <div class="col mx-4">
                        <?php if ($tests) : ?>
                            <?php foreach ($tests as $test) : ?>
                                <H6 style="color: black;"><img src="../Images/Icons/clip-board_12590090.png"><b><?php echo $test['test_name']; ?></b></H6>
                            <?php endforeach; ?>
                        <?php else: ?> 
                            <H6 style="color: black;">No requested tests</b></H6>
                        <?php endif; ?> 
                    </div>
                    </div>
                    </div>
                </div>
               
                    
                </div>
        </div>
        <!-- second row-->
        <div class="row" style=" margin-top:10px ;">
            <div class="col-md-4 mx-4 d-flex justify-content-center "style=" background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
            <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Patient Condition</B></H5>
                <br>
                <div class="row d-flex " style="text-align: Center;">
                <div class="table-wrapper" style="height: 160px;">
                        <div class="col mx-4">
                        <H6>
                        <?php echo $record['patient_condition']; ?>
                        </H6>
                        </div>
                    </div>
                </div>
                </div>
           
                
            </div>
            <br>
            <div class="col-md-4 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Instruction</B></H5>
                    <br>
                    <div class="row d-flex " style="text-align: Center;">
                    <div class="table-wrapper" style="height: 160px;">
                        <div class="col mx-4">
                        <H6>
                        <?php echo $record['instructions']; ?>
                        </H6>
                        </div>
                    </div>
                    </div>
                </div>
               
                    
                </div>
        </div>

    <!-- third row-->
    <div class="row" style=" margin-top:10px ;">
            <div class="col-md-4 mx-4 d-flex justify-content-center "style=" background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
            <div class="row py-4  text-center">
                <H5 style="color: black;"><B>Patient Concern</B></H5>
                <br>
                <div class="row d-flex " style="text-align: Center;">
                        <div class="table-wrapper" style="height: 160px;">
                        <div class="col mx-4">
                        <H6>
                        <?php echo $record['patient_concerns']; ?>
                        </H6>
                        </div>
                    </div>
                </div>
            </div>
           
                
            </div>
            <br>
            <div class="col-md-4 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                
                <div class="row py-4  text-center">
                    <H5 style="color: black;"><B>Note</B></H5>
                    <br>
                    <div class="row d-flex " style="text-align: Center;">
                    <div class="table-wrapper" style="height: 160px;">
                        <div class="col mx-4">
                        <H6>
                        <?php echo $record['note']; ?>
                        </H6>
                        </div>
                    </div>
                </div>
               
                    
                </div>
        </div>
   
    </div>

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