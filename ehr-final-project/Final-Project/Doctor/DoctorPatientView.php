<?php
  session_start();
  require_once ('../data/conn.php');
  require_once('../data/methods.php');
  require_once('../data/charts/glucoseChart.php');
  require_once('../data/charts/systolicChart.php');
  require_once('../data/charts/diastolicChart.php');

  if(!isset($_SESSION['logged_username'])) {
    header("Location: logout.php");
    exit; 
   } 
  $logged_username = $_SESSION['logged_username'];
  $role = $_SESSION['logged_role']; 

  
  if(isset($_SESSION['patient_added_success']) && $_SESSION['patient_added_success'] == true) {
    echo '<div id="success-message" class="alert alert-success" role="alert">Visit Record successfully added!</div>';
    unset($_SESSION['patient_added_success']);
}

if(isset($_SESSION['pres_added_success']) && $_SESSION['pres_added_success'] == true) {
  echo '<div id="success-message" class="alert alert-success" role="alert">Visit Prescription successfully placed!</div>';
  unset($_SESSION['pres_added_success']);
}
  

      $username = $_SESSION['logged_username'];
      $user_id = $_SESSION['logged_id'];

      try {
        $conn = conn::getConnection();
        $sql = "SELECT `doc_id` FROM `doctor` WHERE `user_id` = :user_id";
        $query = $conn->prepare($sql);
        $query->execute([':user_id' => $user_id]);

        $doc_id = $query->fetchColumn();
    } catch (Exception $e) {
        echo 'Error connecting to database: ' . $e->getMessage();
    }
    

  ob_start();
  if(isset($_GET['patientId'])) {
    $patient_id = $_GET['patientId'];
  } else {
    echo "ID not provided!";
    header("Location: DoctorHome.php");
        exit; 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Modalpopup.css">
    <link rel="stylesheet" href="../Css/DoctorHome.Css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
<link rel="stylesheet" href="../Css/DoctorPviewModal.css">
<link rel="stylesheet" href="../Css/PrescriptionModal.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>
<style>
.table-wrapper {
    overflow-y: auto;
    }
</style>
  <?php

    try{
      $conn = conn::getConnection();
      $query = $conn->prepare("SELECT `patient_id`, `phn`, `nic`, `first_name`, `last_name`, `name_with_intials`, `dob`, `house_no`, `street`, `city`, `gender`, `contact`, `email`, `picture`, `emergency_contact_id`, `category_id`, `user_id` FROM `patient` 
                                  WHERE `patient_id` = :pId");
      $query->execute([':pId'=> $patient_id]);
      $patient = $query->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e){
        echo "Error: ".$e->getMessage();
    }

    if (!empty($patient['picture'])) {
      $pictureData = base64_encode($patient['picture']);
      $finfo = finfo_open();
      $mimeType = finfo_buffer($finfo, base64_decode($pictureData), FILEINFO_MIME_TYPE);
      finfo_close($finfo);
  
      $validTypes = ['image/jpeg', 'image/png']; 
  
      if (in_array($mimeType, $validTypes)) {
        $pictureSrc = "data:$mimeType;base64,$pictureData";
      } else {
        echo "<p>Invalid image type</p>";
      }
    } else {
      echo "<p>No picture available</p>";
    }
  ?>


<body>
  <div class="container ">

<div class="row py-3 d-flex">
  <div class="col-1 d-flex align-items-center">
    <a href="DoctorHome.php" class="btn btn-danger" style="background-color: red;">Back</a>
  </div>
  <div class="col text-center" style="display: table;">
  <h2 class="text-black mb-0" style="display: table-cell; vertical-align: middle;"><b>Patient Details</b></h2>
</div>
  <div class="text-center" style="width:90px; margin-left:10px"  >
  <a href="#"  id="open-modal">
        <div class="header_img"> <img src="../Images/images/patient_1533506.png" alt="" style="border-radius:50px; Width: 100px;"> </div>
  </a> 
  </div>
</div>


<div class="height-100 bg-light">
       <!--Modal start-->    
       <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title"> Patient Account Details</h1>
                    <?php
                      echo "<img src='$pictureSrc'  style='width: 100px; height: 100px; border-radius:70%;'>";

                      $dob = new DateTime($patient['dob']);
                      $currentDate = new DateTime();
                      $age = $currentDate->diff($dob)->y;
                    ?>

                    <br>
                    <br>
                    <div class="row" style="float: left; margin-left:40px;">
                      <div>
                    <h6 class="details" style="float: left"><B>Name:</B> <span> <?php echo $patient['first_name'] . " " . $patient['last_name']; ?></span></h6><br>
                    <h6 class="details" style="float: left"><B>PHN:</B> <span> <?php echo $patient['phn']; ?> </span></h6><br>
                    <h6 class="details" style="float: left"><B>NIC:</B> <span> <?php echo $patient['nic']; ?> </span></h6><br>
                    <h6 class="details" style="float: left"><B>Age:</B> <span> <?php echo $age; ?></span></h6><br>
                    <h6 class="details" style="float: left"><B>Date of birthday:</B> <span> <?php echo $patient['dob']; ?> </span></h6><br>
                    <h6 class="details" style="float: left"><B>Tel No:</B> <span> <?php echo $patient['contact']; ?> </span></h6><br>
                    <h6 class="details" style="float: left"><B>Email:</B> <span> <?php echo $patient['email']; ?> </span></h6><br>
                    <h6 class="details" style="float: left"><B>Address:</B><span> <?php echo $patient['house_no']; ?>, </span><br>
                    <span style="margin-left: 66px;"> <?php echo $patient['street']; ?>, </span><br>
                    <span style="margin-left: 66px;"> <?php echo $patient['city']; ?></span></h6><br>
                      </div>  
                  </div>
                </div>
            </div>
<!--Modal end-->


<!--Prescreption View Modal start--> 

  <br>
  <br>
  <br>
  </div>

<?php
  $sqlLatest = "SELECT  appointment.appointment_id, appointment.date, appointment.status,appointment.patient_id,
                 visit_record.bp_systolic,visit_record.bp_diastolic,visit_record.plus_rate,visit_record.glucose_level
                FROM appointment
                INNER JOIN visit_record ON appointment.appointment_id = visit_record.appoinment_id 
                WHERE appointment.patient_id = :pId
                AND appointment.status = :status
                ORDER BY appointment.appointment_id DESC LIMIT 1";
  $queryVital = $conn->prepare($sqlLatest);
  $queryVital->execute([':pId' => $patient_id, ':status' => "Confirm"]);
  $vitalInfo = $queryVital->fetch(PDO::FETCH_ASSOC);

?>
  <div class="row ">
    <div class="col-sm">
    <div class="" style=" width:75%">
      <div  class="" style="background-color:dodgerblue; border-radius:16px;width:125%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;">
      <div class="row text-center py-2">
        <H4 style="color: white;"><b>Vital Signs</b></H4>
      </div>
      
      <div class="row text-center">
        <H5  style="color: white;">Diastolic BP: 
          <?php echo $vitalInfo['bp_diastolic']; ?>
        <span style="color: black;"></span></H5>
      </div>
      <div class="row text-center">
        <H5  style="color: white;">Systolic BP:
          <?php echo $vitalInfo['bp_systolic']; ?> 
        <span style="color: black;"></span></H5>
      </div>
      <div class="row text-center">
        <H5  style="color: white;">Heart Rate: 
          <?php echo $vitalInfo['plus_rate']; ?>
        <span style="color: black;"></span></H5>
      </div>
      <div class="row text-center">
        <H5  style="color: white;">Glucose Level: 
          <?php echo $vitalInfo['glucose_level']; ?>
        <span style="color: black;"></span></H5>
      </div>

      </div>
      <br>
      <br>

    <?php

      //medical info retriving
        $medtSql = "SELECT diagnosis.date, diagnosis.diabetes_type, diagnosis.patient_id,
        history.substance_use, history.medication_on, history.allergies, history.med_conditions
        FROM diagnosis
        INNER JOIN history ON diagnosis.patient_id = history.patient_id
        WHERE diagnosis.patient_id = :pId";
        $queryMed = $conn->prepare($medtSql);
        $queryMed->execute([':pId' => $patient_id]);
        $medInfo = $queryMed->fetch(PDO::FETCH_ASSOC);

    ?>
      <div style="border-radius:16px;width:125%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;">
      <div class="row text-center py-2">
        <H4 style="color: black;"><b>Medical Information</b></H4>
      </div>
      
      <div class="row text-center">
        <H5>Date Of Diagnosis: <span style="color: black;"> 
          <?php echo $medInfo['date'] ?>
        </span></H5>
      </div>
      <div class="row text-center">
        <H5>Allergies: <span style="color: black;">
          <?php echo $medInfo['allergies'] ?>
        </span></H5>
      </div>
      <div class="row text-center">
        <H5>Medication On: <span style="color: black;">
          <?php echo $medInfo['medication_on'] ?>
        </span></H5>
      </div>
      <div class="row text-center">
        <H5>Diabetic Type: <span style="color: black;">
          <?php echo $medInfo['diabetes_type'] ?>
        </span></H5>
      </div>
      <div class="row text-center">
        <H5>Substance Use: <span style="color: black;">
          <?php echo $medInfo['substance_use'] ?>
        </span></H5>
      </div>
      <div class="row text-center">
        <H5>Medical Conditions: <span style="color: black;">
          <?php echo $medInfo['med_conditions'] ?>
        </span></H5>
      </div>

      </div>
      <br>
      <br>

      <?php
        //COmplication
        $sqlComp = "SELECT diagnosis.diagnosis_id, diagnosis.patient_id, complication.complication
                    FROM diagnosis
                    INNER JOIN complication ON diagnosis.diagnosis_id = complication.diagnosis_id
                    WHERE diagnosis.patient_id = :pId";
        $queryComp = $conn->prepare($sqlComp);
        $queryComp->execute([':pId' => $patient_id]);
        $compInfo = $queryComp->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <div style="border-radius:16px;width:125%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px; padding-bottom: 10px;">
        <div class="row text-center py-2">
          <H4 style="color: black;"><b>Complications</b></H4>
        </div>
      
      <div class="row text-left d-flex justify-content-center">

        <?php foreach ($compInfo as $comp) : ?>
          <div class="row text-center">
            <H5><span style="color: black;">
              <?php echo $comp['complication'] ?>
            </span></H5>
          </div>
          <?php endforeach; ?> 

      </div>
      </div>
      <br>
      <br>

      <?php
      
        //Family History
        $sqlFam = "SELECT history.patient_id, family_history.name,family_history.relationship, family_history.disease
                    FROM history
                    INNER JOIN family_history ON history.history_id = family_history.history_id
                    WHERE history.patient_id = :pId";
        $queryFam = $conn->prepare($sqlFam);
        $queryFam->execute([':pId' => $patient_id]);
        $famiHis = $queryFam->fetch(PDO::FETCH_ASSOC);
      ?>
      <div style="border-radius:16px;width:125%; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;">
      <div class="row text-center py-2">
        <H4 style="color: black;"><b>Family History</b></H4>
      </div>
      <br>
      <div class="row text-center d-flex justify-content-center">
        <table class="table table-bordered" style="width: 85%;">
          <tr>
            <th>Name</th>
            <th>Relationship</th>
            <th>Disease</th>
          </tr>
          <tr>
            <td> <?php echo $famiHis['name'];?> </td>
            <td> <?php echo $famiHis['relationship'];?></td>
            <td> <?php echo $famiHis['disease'];?></td>
          </tr>
        </table>
      </div>
      </div>
      <br>
      <br>
      <div style="border-radius:16px;width:125%;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px; height:fit-content;">
          <div class="row text-center py-2">
            <H4 style="color: black;"><B>Charts</B></H4>
          </div>
          <br>
          <div  id="glucose_chart" style="width: fit-content;" class="row text-center d-flex justify-content-center">
            <?php generateGlucoseChart($patient_id);?>
          </div>
          <br>
          <div  id="bp_chart" style="width: fit-content;"  class="row text-center d-flex justify-content-center">
            <?php generateSystolicChart($patient_id);?>
          </div>
          <br>
          <div  id="d_bp_chart" style="width: fit-content; margin-bottom:20px;"  class="row text-center d-flex justify-content-center">
            <?php generateDiastolicChart($patient_id);?>
          </div>
        </div>
    </div>
    
  </div>

  <div class="col-md-7" >

  <!--Patient Records Results Start-->
    <div class="" style="margin-left:10px;">
      <div style="box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
        <div class="row">
          <H2>Visits Records</H2>
          <div>
          <a href="Adddoctornote.php?patientId=<?php echo $patient_id; ?>" class="btn btn-primary">+ADD RECORD</a>
          </div>
        </div>
        

        <?php
          $sqlVisit = "SELECT appointment.appointment_id, appointment.date, appointment.type, appointment.status, appointment.patient_id, appointment.doc_id, doctor.name, visit_record.record_id
          FROM appointment 
          LEFT JOIN doctor ON appointment.doc_id = doctor.doc_id
          LEFT JOIN visit_record ON appointment.appointment_id = visit_record.appoinment_id
          WHERE appointment.patient_id = :pId
          ORDER BY appointment.date DESC";
          $queryVisit = $conn->prepare($sqlVisit);
          $queryVisit->execute([':pId'=> $patient_id]);
          $visitInfo = $queryVisit->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="col-md-12">

                    <div class="table-responsive">
                    <div class="table-wrapper" style="height: 300px;">
                            
                          <table id="mytable" class="table table-bordred table-striped">
                               
                              <thead>
                               <th>Date</th>
                               <th>Type</th>
                               <th>Doctor</th>
                               <th>Notes</th>
                              </thead>

                              <tbody>
                                <?php foreach ($visitInfo as $info) : ?>
                                  <tr style="background-color: <?php echo ($info['status'] == "Scheduled") ? '#beffd0' :''; ?>">
                                  <td><?php echo $info['date'] ?></td>
                                  <td>
                                    <?php 
                                      if( $info['type'] == NULL){
                                          echo "Scheduled";
                                      } else{
                                          echo $info['type'] ;
                                      }  ?>
                                  </td>
                                  <td>Dr. <?php echo $info['name'] ?></td>
                                  <td>
                                    <?php
                                        if( $info['type'] == NULL){
                                          echo " ";
                                        } else{
                                          echo '<button type="button" name="btnView" class="btn btn-primary btn-sm" onclick="viewNote(' . $info['record_id'] . ')">View Note</button>';
                                        }
                                    ?>
                                    
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                               
                              </tbody>
                                
                          </table>                
            </div>
                    </div>
            </div>
    </div>
    </div>
    <!--Patient Records Results End-->
    <br>
    <br>


    <!--Prescription Results Starts-->

    <?php
      $sqlPres = "SELECT prescription.prescription_id,prescription.prescribed_date, prescription.p_status,doctor.name 
                  FROM prescription 
                  INNER JOIN doctor ON prescription.doc_id = doctor.doc_id
                  WHERE prescription.patient_id = :pId
                  ORDER BY  prescription.prescribed_date DESC";
      $queryPres = $conn->prepare($sqlPres);
      $queryPres->execute([':pId'=> $patient_id]);
      $presInfo = $queryPres->fetchAll(PDO::FETCH_ASSOC);  
    ?>
    <div class="" style="margin-left:10px;box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
      <div>
        <div class="row">
          <H2>Prescreption</H2>
          <div>
          <a href="Addprescription.php?patientId=<?php echo $patient_id; ?>" class="btn btn-primary">+ADD PRESCRIPTION</a>
          </div>
        </div>
          <div class="col-md-12">

                    <div class="table-responsive">
                    <div class="table-wrapper" style="height: 300px;">
                          <table id="mytable" class="table table-bordred table-striped">
                               
                              <thead>
                                <th>Precribed Date</th>
                                <th>Status</th>
                                <th>Doctor</th>
                                <th>Prescription</th>
                              </thead>

                              <tbody>
                                <?php foreach ($presInfo as $info): ?>
                                  <tr style="background-color: <?php echo ($info['p_status'] == "Pending") ? '#beffd0' :''; ?>">
                                  <td><?php echo $info['prescribed_date'] ?></td>
                                  <td>
                                    <?php 
                                      if($info['p_status'] == "Confirm"){
                                        echo "Dispensed";
                                      } else{
                                        echo "Pending";
                                      }
                                    ?>
                                  </td>
                                  <td>Dr. <?php echo $info['name'] ?></td> 
                                  <td><button type="button" name="btnView" class="btn btn-primary btn-sm" onclick="viewPres('<?php echo $info['prescription_id']; ?>')">View</button></td>
                                </tr>
                                 <?php endforeach; ?>   
                              </tbody>      
                          </table>                
                      </div>
                    </div>
           </div>
    </div>
    </div>

    <!--Prescreption Results End-->
    <br>
    <br>


    <!--Lab Results Start-->

    <?php
      $queryTestList = $conn->prepare("SELECT `test_id`,`test_name` FROM `lab_test` ORDER BY `test_name` ASC");
      $queryTestList->execute();
      $testList = $queryTestList->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="" style="margin-left:10px; margin-left:10px;box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
      <div>
        <div class="row">
          <H2>Lab Result</H2>

          

          <div class="d-flex">
            <form action="" method="post" style="display: flex;">
            <div class="dropdown">
                <select class="btn btn-primary" data-bs-toggle="dropdown" name="testType" id="" style="width:fit-content;" required>
                    <option value="" style="background-color: white; color:black;text-align:left;">Select Test Type</option>
                    <?php foreach($testList as $list) : ?>
                      <option value="<?php echo $list['test_id']; ?>"" style="background-color: white; color:black; text-align:left;width:fit-content;"><?php echo $list['test_name']; ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="dropdown" style="margin-left:10px">
                <button type="submit" class="btn btn-primary" name="btnRequest">+REQUEST LAB TEST</button>
            </div> 
            </form> 

            

            <?php
              if(isset($_POST['btnRequest'])){
                $testId = $_POST["testType"];
                $currentDate = date("Y-m-d");
                $sqlReq = $conn->prepare("INSERT INTO `test_request`(`request_date`, `status`, `test_id`, `patient_id`, `doc_id`) 
                          VALUES (:currentDate, :status, :testId, :pId, :docId )");
                $sucees = $sqlReq->execute([':currentDate' => $currentDate, ':status' => "Pending", ':testId' => $testId,':pId' => $patient_id, ':docId' => $doc_id]);
              }
            ?>
          </div>
          
        </div>

        <?php 
          $sqlTest = "SELECT test_request.request_id, test_request.request_date, test_request.status, test_request.patient_id,
                             test_result.result_id,test_result.date, test_result.result_value, test_result.result_attachment, lab_test.test_name
                      FROM test_request 
                      LEFT JOIN test_result ON test_request.request_id = test_result.request_id
                      LEFT JOIN lab_test ON test_request.test_id = lab_test.test_id
                      WHERE test_request.patient_id = :pId
                      ORDER BY test_request.request_date DESC";
          $queryTest = $conn->prepare($sqlTest);
          $queryTest->execute([':pId'=>$patient_id]);
          $tests = $queryTest->fetchAll(PDO::FETCH_ASSOC);
        ?>

      <div class="col-md-12">
        <div class="table-responsive">
        <div class="table-wrapper" style="min-height:fit-content; height:300px">
          <table id="mytable" class="table table-bordred table-striped">
                               
            <thead>
              <th>Test</th>
              <th>Requ.Date</th>
              <th>Test.Date</th>
              <th>Value</th>
              <th>Attachment</th>
            </thead>
            <tbody>
            <?php foreach($tests as $test) : ?>
              <tr style="background-color: <?php echo ($test['status'] == "Pending") ? '#beffd0' :''; ?>">
                <td><?php echo $test['test_name']; ?></td>
                <td><?php echo $test['request_date']; ?></td>
                <td><?php echo $test['date']; ?></td>
                <td><?php echo $test['result_value']; ?></td>
                <td>
                  <?php
                    if( $test['status'] != "Pending") :?>
                      <a href="view_attachment.php?result_id=<?php echo $test['result_id']; ?>" target="_blank" class="btn btn-primary btn-sm">View</a>
                    <?php endif; ?>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
            <?php
              if(isset($_POST['btnAttachView'])){

              }
            ?>
          </table>   
        </div>             
        </div>
      </div>
    </div>
    </div>
   <!--Lab Results End-->

    </div>
  
    

  </div>
  <script>
        function viewNote(recordId) {
            window.location.href = 'DoctorNoteView.php?recordId=' + recordId;
        }

        function viewPres(presId) {
            window.location.href = 'Prescriptionview.php?presId=' + presId;
        }
  </script>

  <script>
    setTimeout(function() {
        $('#success-message').fadeOut('slow');
    }, 3000);
    
</script>
  <script src="../Java Script/main.js"></script>
  <script src="../Java Script/Reciption.JS"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 
  </div>
</div>

</div>
</body>
</html>