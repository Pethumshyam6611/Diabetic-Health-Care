<?php
    ob_start();
    session_start();
    require_once('../data/conn.php');

    //error reporting for debugging
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);

    if(isset($_GET['patientId'])) {
        $patient_id = $_GET['patientId'];
      } else {
        echo "ID not provided!";
      }
      
    $currentDate = date("Y-m-d");

    //Getting logged in user's details
    if (isset($_SESSION['logged_username'])) {
        $username = $_SESSION['logged_username'];
        $user_id = $_SESSION['logged_id'];

        try{
            $conn = conn::getConnection();
            $sql = "SELECT `doc_id` FROM `doctor` WHERE `user_id` = :user_id";
            $query = $conn->prepare($sql);
            $query->execute([':user_id' => $user_id]);
            $doctor_data = $query->fetch(PDO::FETCH_ASSOC);
            $doc_id = $doctor_data['doc_id'];
        } catch (Exception $e){
            echo 'Error connecting to database: ' . $e->getMessage();
        }
    }

    function updatePatientCategory($connection, $glucoseLevelString, $patient_id) {
        $glucoseLevel = intval(preg_replace('/[^0-9]/', '', $glucoseLevelString)); 
    
        $category = 3;
        if ($glucoseLevel > 180) {
            $category = 1;
        } elseif ($glucoseLevel >= 126 && $glucoseLevel <= 180) {
            $category = 2;
        }
    
        $query = "UPDATE `patient` SET `category_id` = :category WHERE `patient_id` = :pId";
        $statement = $connection->prepare($query);
        $statement->bindParam(':category', $category, PDO::PARAM_INT);
        $statement->bindParam(':pId', $patient_id, PDO::PARAM_INT);
        $statement->execute();
    
        if ($statement->rowCount() > 0) {
            echo "Patient category updated successfully.";
        } else {
            echo "Failed to update patient category.";
        }
        $statement->closeCursor();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment Notes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Reciption P reg.css">
    <!-- Link jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
    <!-- Link Bootstrap JS (including Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
<header class="row py-3" style="background-color: dodgerblue;">
    <div class="col-1 d-flex align-items-center" style="margin-left: 20px;"> 
    <a href="DoctorPatientView.php?patientId=<?php echo $patient_id; ?>" class="btn btn-danger" style="background-color: red;">Back</a> <!-- DoctorPatientView.php?patientId=<?php //echo $patient_id; ?>-->
    </div>
    <div class="col text-center">
      <h2 class="text-white mb-0"><b>Add Doctor Note</b></h2>
    </div>
  </header>

<?php
    try{
        $conn = conn::getConnection();
        $sqlCheck = "SELECT `appointment_id`,`status`
                    FROM `appointment`
                    WHERE `patient_id` = :pId
                    ORDER BY `date` DESC
                    LIMIT 1;";
        $queryCheck = $conn->prepare($sqlCheck);
        $queryCheck->execute([':pId'=> $patient_id]);
        $appInfo = $queryCheck->fetch(PDO::FETCH_ASSOC);

        if($appInfo['status']=="Scheduled"){
            $scheduled = TRUE;
        } else{
            $scheduled = FALSE;
            echo "Confimed";
        }

    } catch (Exception $e){
        echo 'Error connecting to database: ' . $e->getMessage();
    }
?>
    <div class="container">
    <form method="post">
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-md-auto ms-auto" style="margin-right:170px;">  
                <div class="dropdown" style="text-align:left;">
                    <select class="btn btn-primary" data-bs-toggle="dropdown" name="appointmentType" id="" style="width:fit-content;" required>
                        <option value="" style="background-color: white; color:black;text-align:left;">-- Select Appointment Type --</option>
                        <option value="General" style="background-color: white; color:black; text-align:left;width:fit-content;">General Visit</option>
                        <option value="Special Refferal" style="background-color: white; color:black; text-align:left;width:fit-content;">Special Refferal</option>
                        <option value="First Time" style="background-color: white; color:black; text-align:left;width:fit-content;">First Time Visit</option>
                    </select>
                </div>
            </div>
        </div>
        <br>

        
           
           <div class="row justify-content-center">
                <div class="col-md-4 py-3" style="background-color:#D9D9D9; ">
                   <div class="row">
                        <h5 class="mb-4 text-center"><u><b>Vital Signs</b></u></h5>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1">
                           <label for="patientNumber">Glucoose Level:</label>
                           <input type="text" class="form-control" id="patientNumber" name="glucoseLevel" placeholder="mg/dL" required>
                       </div>
                       <div class="form-group mx-1">
                            <label for="patientNumber">Diastolic (BP):</label>
                            <input type="text" class="form-control" id="patientNumber" name="diastolic" placeholder="mmHg" required>
                       </div>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1">
                           <label for="patientNumber">Heart Rate:</label>
                           <input type="text" class="form-control" id="patientNumber" name="pulseRate" placeholder="bpm" required>
                       </div>
                       <div class="form-group mx-1">
                            <label for="patientNumber">Systolic (BP):</label>
                            <input type="text" class="form-control" id="patientNumber" name="systolic" placeholder="mmHg" required>
                       </div>
                   </div>
                </div>
   
                <?php
                    $queryTestList = $conn->prepare("SELECT `test_id`,`test_name` FROM `lab_test` ORDER BY `test_name` ASC");
                    $queryTestList->execute();
                    $testList = $queryTestList->fetchAll(PDO::FETCH_ASSOC);

                ?>
   
       
                <div class="col-md-4 py-3 " style=" background-color:#D9D9D9; margin-left:10px;">
                   <div class="row">
                        <h5 class="mb-4 text-center"><u><b>Lab Tests</b></u></h5>
                   </div>
                   <div class="d-flex" >
                        <div class="dropdown">

                            <select class="btn btn-primary" data-bs-toggle="dropdown" name="testType" id="testType" style="width:fit-content;">
                                <option value="" style="background-color: white; color:black;text-align:left;">Select Test Type</option>
                                <?php foreach($testList as $list) : ?>
                                <option value="<?php echo $list['test_id']; ?>"" style="background-color: white; color:black; text-align:left;width:fit-content;"><?php echo $list['test_name']; ?></option>
                                <?php endforeach ?>
                            </select>

                        </div>
                        <div>
                        <a href="#" class="btn btn-primary" style="margin-left: 8px; padding: 4px 9px 4px 9px;" onclick="addTestType()">Add</a>
                        </div>
                    </div>
               <br>
               <div id="selectedTestTypes">

                </div>    
           </div>       
        </div>
               

        <br>

           <div class="row justify-content-center">
                <div class="col- py-3" style="background-color:#D9D9D9; width: 67%;">
                    <div class="d-flex">
                       <div class="form-group mx-1" style="width: 50%;">
                           <label for="patientNumber">Patient Condition:</label>
                           <textarea class="form-control" id="exampleFormControlTextarea1" name="condition" rows="5" style="width: 100%;" placeholder="Enter patient current condition here..."></textarea>
                       </div>

                       <div class="form-group" style="margin-left: 30px; width: 50%;">
                            <label for="patientNumber">Instruction:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="instruction" placeholder="Enter given instructions here..." ></textarea>
                       </div>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1" style="width: 50%;">
                           <label for="patientNumber">Patient Concern:</label>
                           <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" style="width: 100%;" name="concern" placeholder="Enter patient concerns here..."></textarea>
                       </div>
                       <div class="form-group" style="margin-left: 30px; width: 50%;">
                            <label for="patientNumber">Note:</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="note" placeholder="Enter other notes here..."></textarea>
                       </div>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1">
                           <label for="patientNumber">Next Visit Date:</label>
                           <input type="date" class="form-control" name="nextDate" id="dateOfBirth" required>
                       </div>
                   </div>
      
                </div>
                <div class="row justify-content-center text-center" style="margin-top: 10px;">
            <div>
                <button type="submit" class="btn btn-primary" name="btnSave">SAVE</button>
            </div>
            </div>
        </form>


        <?php
            if(isset($_POST['btnSave'])){
                $appointmentType = $_POST["appointmentType"];
                $glucose = $_POST["glucoseLevel"];
                $bp_d = $_POST["diastolic"];
                $pulse = $_POST["pulseRate"];
                $bp_s = $_POST["systolic"];

                //Can be nullable varibles
                $nextDate = isset($_POST["nextDate"]) ? $_POST["nextDate"] : null;
                $condition = isset($_POST["condition"]) ? $_POST["condition"] : null;
                $inst = isset($_POST["instruction"]) ? $_POST["instruction"] : null;
                $concern = isset($_POST["concern"]) ? $_POST["concern"] : null;
                $note = isset($_POST["note"]) ? $_POST["note"] : null;


                $appointmentId = $appInfo['appointment_id'];
            
                //Saving Requested Tests
                if (isset($_POST['selectedTests']) && ($_POST['selectedTests']) != NULL){
                    foreach($_POST['selectedTests'] as $selectedTestId) {
                        try {
                            $testId = $_POST["testType"];
                            $currentDate = date("Y-m-d");
                            $conn = conn::getConnection();
                            $sqlReq = $conn->prepare("INSERT INTO `test_request`(`request_date`, `status`, `test_id`, `patient_id`, `doc_id`,`appointment_id`) 
                                    VALUES (:currentDate, :status, :testId, :pId, :docId, :a_id )");
                            $success = $sqlReq->execute([':currentDate' => $currentDate, ':status' => "Pending", ':testId' => $selectedTestId, ':pId' => $patient_id, ':docId' => $doc_id, ':a_id'=> $appointmentId]);
                            if(!$success){
                                echo "Failed to insert test request.";
                            }
                        } catch (Exception $e) {
                            echo 'Error connecting to database: ' . $e->getMessage();
                        }
                    }
                }

                    try{
                        if($scheduled == TRUE){
                            $conn = conn::getConnection();
                            
                            $sqlUpdate = "UPDATE `appointment` SET `date`= :date,`type`= :type,`status`= :status,`patient_id`= :pId,`doc_id`= :docId 
                                        WHERE `appointment_id` = :a_Id";
                            $queryUpdate = $conn->prepare($sqlUpdate);
                            $success = $queryUpdate->execute([':date' => $currentDate, ':type' => $appointmentType ,':status' => "Confirm", ':pId' => $patient_id, ':docId' => $doc_id, ':a_Id' => $appointmentId]);
                                if(!$success){
                                    echo "Failed to update appointment.";
                                }

                            //Visit Record Saving
                            $sqlVRecords = "INSERT INTO `visit_record`(`bp_systolic`, `bp_diastolic`, `plus_rate`, `glucose_level`, `patient_concerns`, `patient_condition`, `instructions`, `note`, `appoinment_id`) 
                                            VALUES (:bp_s, :bp_d, :pulse, :glucose, :concerns, :condition, :instruction, :note, :appointmentId)";
                            $queryRecords = $conn->prepare($sqlVRecords);
                            $success = $queryRecords->execute([':bp_s' => $bp_s, ':bp_d' => $bp_d, ':pulse' => $pulse, ':glucose' =>$glucose, ':concerns'=> $concern, ':condition'=> $condition, ':instruction'=>$inst, ':note'=> $note, ':appointmentId'=> $appointmentId]);
                            updatePatientCategory($conn,$glucose,$patient_id);
                            if(!$success){
                                echo "Failed to insert visit record.";
                            }
                        } else {
                            $conn = conn::getConnection();
                            $sqlInsertAppointment = "INSERT INTO `appointment` ( `date`, `type`, `status`, `patient_id`, `doc_id`)
                                        VALUES (:date,:type,:status,:pId,:docId)";
                            $queryInsertAppointment = $conn->prepare($sqlInsertAppointment);
                            $success = $queryInsertAppointment->execute([':date' => $currentDate, ':type' => $appointmentType ,':status' => "Confirm", ':pId' => $patient_id, ':docId' => $doc_id]);
                            updatePatientCategory($conn,$glucose,$patient_id);
                            if(!$success){
                               echo "Failed to insert appointment.";
                            }
                            
                            $a_Id = $conn->lastInsertId();


                            //Visit Record Saving
                            $sqlVRecords = "INSERT INTO `visit_record`(`bp_systolic`, `bp_diastolic`, `plus_rate`, `glucose_level`, `patient_concerns`, 
                                            `patient_condition`, `instructions`, `note`, `appoinment_id`) 
                                            VALUES (:bp_s, :bp_d, :pulse, :glucose, :concerns, :condition, :instruction, :note, :appointmentId)";
                            $queryRecords = $conn->prepare($sqlVRecords);
                            $success = $queryRecords->execute([':bp_s' => $bp_s, ':bp_d' => $bp_d, ':pulse' => $pulse, ':glucose' =>$glucose, ':concerns'=> $concern, 
                            ':condition'=> $condition, ':instruction'=>$inst, ':note'=> $note, ':appointmentId'=> $a_Id]);
                            if(!$success){
                                echo "Failed to insert visit record.";
                            }
                        }

                        // Next appointment
                            $conn = conn::getConnection();
                            $sqlAdd = "INSERT INTO `appointment` ( `date`, `status`, `patient_id`, `doc_id`)
                            VALUES (:date,:status,:pId,:docId)";
                            $queryAdd = $conn->prepare($sqlAdd);
                            $success = $queryAdd->execute([':date' => $nextDate, ':status' => "Scheduled", ':pId' => $patient_id, ':docId' => $doc_id]);
                            if(!$success){
                                echo "Failed to add next appointment.";
                            }

                            
                            $_SESSION['patient_added_success'] = true;
                            header("Location: DoctorPatientView.php?patientId=".$patient_id);
                            exit;
                            
                    } catch (Exception $e){
                        echo 'Error connecting to database: ' . $e->getMessage();
                    }
                }ob_end_flush();

               
            
        ?>
                
    </div>
            <br>
            <br>
<script>
    function addTestType() {
        var selectedTestType = document.getElementById("testType").value;
        var testTypeName = document.getElementById("testType").options[document.getElementById("testType").selectedIndex].text;
        var selectedTestTypesContainer = document.getElementById("selectedTestTypes");
        var selectedTestTypeElement = document.createElement("div");
        selectedTestTypeElement.classList.add("selected-test-type");
        selectedTestTypeElement.innerHTML = `
            <span style="padding-bottom:3px;" class="test-type-name">${testTypeName}</span>
            <input type="hidden" name="selectedTests[]" value="${selectedTestType}">
            <button type="button" class="btn btn-sm btn-danger remove-test-type" style="padding:1px 5px 1px 5px; ">
                <i class="bi bi-x"></i>
            </button>
        `;
        selectedTestTypesContainer.appendChild(selectedTestTypeElement);
    }

    $(document).on("click", ".remove-test-type", function() {
        $(this).parent().remove();
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-boQlKl8gq5zSWmmL3Yf1JNls4c0hVhU8zZH7zpVbQW0y1qivUX8ptTsnpmT4EYuh" crossorigin="anonymous"></script>          
</body>
</html>