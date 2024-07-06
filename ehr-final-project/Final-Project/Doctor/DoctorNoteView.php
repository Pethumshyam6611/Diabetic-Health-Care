<?php
    session_start();
    require_once('../data/conn.php');

    if(isset($_GET['recordId'])) {
        $record_id = $_GET['recordId'];
      } else {
        header("Location: DoctorPatientView.php");
        exit; 
      }
    try{
        $conn = conn::getConnection();
    } catch (Exception $e){
        echo 'Error connecting to database: ' . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor Note</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Reciption P reg.css">
    <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
<!-- Link jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Link Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
<header class="row py-3" style="background-color: dodgerblue;">
    
<div class="col text-center">
      <h2 class="text-white mb-0"><b>Doctor Note</b></h2>
    </div>
  </header>
    <div class="container">
        <br>
        <br>
        <div class="row">
        </div>
            <br>

            <?php
                //Retriving Visit Records
                $queryRecords = $conn->prepare("SELECT `bp_systolic`, `bp_diastolic`, `plus_rate`, `glucose_level`, `patient_concerns`, `patient_condition`, `instructions`, `note`, `appoinment_id` 
                                                FROM `visit_record` WHERE `record_id` = :record_id");
                $queryRecords->execute([':record_id'=> $record_id]);
                $record = $queryRecords->fetch(PDO::FETCH_ASSOC);

                $a_id = $record['appoinment_id'];
                $queryTests = $conn->prepare("SELECT test_request.request_id, test_request.status, test_request.test_id, test_request.appointment_id,lab_test.test_name 
                                            FROM test_request
                                            LEFT JOIN lab_test ON  test_request.test_id = lab_test.test_id
                                            WHERE test_request.appointment_id = :aId");
                $queryTests->execute([':aId'=> $a_id]);
                $tests = $queryTests->fetchAll(PDO::FETCH_ASSOC);       
            ?>


        <form>
           
           <div class="row justify-content-center">
                   <div class="col-md-4 py-3" style="background-color:#D9D9D9; ">
                   <div class="row">
                    <h4 class="mb-4 text-center"><u><b>Vital Signs</b></u></h4>
                   </div>
                   <div class="row text-center">
                       <H4>BP Diastolic: <span><B><?php echo $record['bp_diastolic']; ?></B></span></H4>
                    </div>
                    <div class="row text-center">
                        <H4>BP Systolic: <span><B><?php echo $record['bp_systolic']; ?></B></span></H4>
                    </div>
                    <div class="row text-center">
                        <H4>Heart Rate: <span><B><?php echo $record['plus_rate']; ?></B></span></H4>
                    </div>
                    <div class="row text-center">
                        <H4>Glucose Level: <span><B><?php echo $record['glucose_level']; ?></B></span></H4>
                    </div>
                   </div>
   
   
   
       
                   <div class="col-md-4 py-3 " style=" background-color:#D9D9D9; margin-left:10px;">
                   
                   <div class="row">
                        <h4 class="mb-4 text-center"><u><b> Requested Lab Test</b></u></h4>
                   </div>
                   <?php if (empty($tests)) : ?>
                        <div class="row text-center">
                            <h5>No requested tests</h5>
                        </div>
                    <?php else : ?>
                        <?php foreach($tests as $test) : ?>
                            <div class="row text-center">
                                <h4><?php echo $test['test_name']; ?></h4>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                   </div>       
                   </div>
               

           <div class="row justify-content-center" style="margin-top:10px;">
                <div class="col- py-3" style="background-color:#D9D9D9; width: 67%;">
                   <div class="d-flex">
                       <div class="form-group mx-1" style="width: 50%;">
                           <label for="patientNumber"><B>Patient Condition:</B></label>
                        <p><?php echo $record['patient_condition']; ?></p>   
                       </div>
                       <div class="form-group" style="margin-left: 30px; width: 50%;">
                            <label for="patientNumber"><B>Instruction:</B></label>
                       <p><?php echo $record['instructions']; ?></p>
                       </div>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1" style="width: 50%;">
                           <label for="patientNumber"><B>Patient Concern:</B></label>
                        <p><?php echo $record['patient_concerns']; ?></p>
                       </div>
                       <div class="form-group" style="margin-left: 30px; width: 50%;">
                       <label for="patientNumber"><B>Note:</B></label>
                       <p><?php echo $record['note']; ?></p>
                       </div>
                   </div>
                   <div class="d-flex">

                   </div>
      
           </div>
           </form>
        
    </div>
    <br>
    <br>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-boQlKl8gq5zSWmmL3Yf1JNls4c0hVhU8zZH7zpVbQW0y1qivUX8ptTsnpmT4EYuh" crossorigin="anonymous"></script>          
</body>
</html>