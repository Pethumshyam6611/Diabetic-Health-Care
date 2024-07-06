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
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Reciption P reg.css">
    <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>
<body>
<header class="row py-3" style="background-color: dodgerblue;">
    <div class="col-1 d-flex align-items-center" style="margin-left: 20px;">
      <a href="#" class="btn btn-danger" style="background-color: red;">Back</a>
    </div>
    <div class="col text-center">
      <h2 class="text-white mb-0"><b>Patient Registration</b></h2>
    </div>
  </header>
        <br>
        <br>
        <br>
        <form method="post">
            <div class="row justify-content-center">
                    <div class="col-md-3 py-3" style="background-color:#D9D9D9; ">
                    <div class="row">
                    <h4 class="mb-4 text-center"><u><b>Diagnosis</b></u></h4>
                    </div>
                        <div class="form-group">
                            <label for="patientNumber">Diabetes Type:</label>
                            <select class="form-control" name="dtype" id="" >
                                <option value="Type 1">Type 1</option>
                                <option value="Type 2">Type 2</option>
                                <option value="Gestational">Gestational</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="dateOfBirth">Diagnosed Date:</label>
                            <input type="date" name="ddate" class="form-control" id="dateOfBirth" required>
                        </div>
                    </div>

                    <div class="col-md-4 py-3 " style=" background-color:#D9D9D9; margin-left:10px;">
                    <div class="row">
                    <h4 class="mb-4 text-center"><u><b>Complication</b></u></h4>
                    </div>
                    <div class="d-flex">
                    <div>
                    <div class="row">
                    <label for="patientPicture"><U>Micro Vascular</U></label>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="microVascular[]" type="checkbox" value="Neuropathy" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Neuropathy
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="microVascular[]" type="checkbox" value="Nephropathy" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Nephropathy
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="microVascular[]" type="checkbox" value="Retinopathy" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Retinopathy
                            </label>
                        </div>
                        <br>
                        <div class="row">
                    <label for="patientPicture"><U>Macro Vascular</U></label>
                    
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="macroVascular[]" type="checkbox" value="IHD" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            IHD
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="macroVascular[]" type="checkbox" value="Stroke" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Stroke/TIA
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="macroVascular[]" type="checkbox" value="Peripharal" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Peripharal Vascular Dis
                            </label>
                        </div>                
                    </div>    
                </div>    
            </div>

            <div style="margin-left: 10px;">
                    <div class="row">
                    <label for="patientPicture"><U>Foot</U></label>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="foot[]" type="checkbox" value="Ulcer" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Foot Ulcer/Callosity
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="foot[]" type="checkbox" value="Arthropathy" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Charcot's Arthropathy
                            </label>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                    <label for="patientPicture"><U>Core Morbidities</U></label>
                    
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" name="coreMorbidities[]" type="checkbox" value="Hypertension" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Hypertension
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="coreMorbidities[]" type="checkbox" value="Dyslipidaemia" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Dyslipidaemia
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="coreMorbidities[]" type="checkbox" value="NAFLD" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            NAFLD
                            </label>
                        </div>     
                        <div class="form-check">
                            <input class="form-check-input" name="coreMorbidities[]" type="checkbox" value="Obesity" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Obesity(BMI>23)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="coreMorbidities[]" type="checkbox" value="Smoking" id="phoneCheckbox">
                            <label class="form-check-label" for="phoneCheckbox">
                            Smoking
                            </label>
                        </div>               
                    </div>    
                </div>
                </div>        
            </div>
        
        
    </div>
    <br>

    
    <div class="row justify-content-center" style="margin-top: 10px;">
    <div class="py-3" style="background-color:#D9D9D9; width: 804px; height:auto">
    <div class="row">
            <h4 class="mb-4 text-center"><u><b>History</b></u></h4>
    </div>
                <div class="d-flex">
                    <div class="form-group">
                        <label for="patientNumber">Reffered By</label>
                        <input type="text"  class="form-control" name="refferedBy" id="patientNumber" placeholder="Reffered By" required>
                    </div>
                    <div class="form-group" style="margin-left: 90px;">
                        <label for="dateOfBirth">Substance Use</label>
                        <input type="text" class="form-control" name="substanceUse" id="patientNumber" placeholder="Substance Use" required>
                    </div>
                    <div class="form-group" style="margin-left: 90px;">
                        <label for="dateOfBirth">Current Medication</label>
                        <input type="text" name="currentMedi" class="form-control" id="patientNumber" placeholder="Current Medication" required>
                    </div>
                </div>
                
                <div class="d-flex" style="margin-top: 20px;">
                <div class="d-flex">
                    <div class="form-group" id="postMedicalHistoryFields">
                        <label for="patientNumber">Past Medical History</label>
                        <input type="text" name="pastMedHistory" class="form-control mb-3" placeholder="Past Medical History" required>
                    </div>
                </div>    
                <div class="d-flex" style="margin-left:40px">
                    <div class="form-group" id="allergiesFields">
                        <label for="patientNumber">Allergies</label>
                        <input type="text" name="allergies" class="form-control mb-3" placeholder="Allergies">
                    </div>

                     
                </div>
                </div>    

            </div>
            </div>
        <br>
        <div class="row justify-content-center" style="margin-top: 10px;">
            <div class="py-3" style="background-color:#D9D9D9; width: 804px; height:auto">
            <div class="row">
                    <h4 class="mb-4 text-center"><u><b>Family And Social History</b></u></h4>
            </div>
            <div class="row d-flex">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="patientNumber">Family Member Name</label>
                        <input type="text" name="fmname" class="form-control" id="patientNumber" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="dateOfBirth">Relationship</label>
                        <input type="text" name="relate" class="form-control" id="patientNumber" placeholder="Relationship" required>
                    </div>
                    <div class="form-group">
                        <label for="dateOfBirth">Disease</label>
                        <input type="text" name="disease" class="form-control" id="patientNumber" placeholder="Disease" required>
                    </div>
                </div>
                <div class="col-md-4" style="margin-left:30px;">
                    <div class="form-group">
                        <label for="patientNumber">Occupation</label>
                        <input type="text" name="ocuupation" class="form-control" id="patientNumber" placeholder="Occupation" required>
                    </div>
                    <div class="form-group">
                        <label for="dateOfBirth">Education Level</label>
                        <select class="form-control" style="color:black" id="educationLevel" name="educationLevel" required>
                            <option value="None">None</option>
                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Higher Secondary">Higher Secondary</option>
                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                            <option value="Master's Degree">Master's Degree</option>
                            <option value="PhD or higher">PhD or higher</option>
                        </select>
                    </div>
                </div>
            
                </div>
                </div>    

        </div>

        <div class="row justify-content-center text-center" style="margin-top: 10px;">
        <div>
        <button type="submit" name="btnSave" class="btn btn-primary">SAVE</button>
        </div>
        </div>
    </form>

    <?php
        if(isset($_POST["btnSave"])){
            $dtype = $_POST["dtype"];
            $ddate = $_POST["ddate"];

            if(isset($_POST["foot"])) {
                $foot  = $_POST["foot"];
            } else {
                $foot  = array();
            }

            if(isset($_POST["coreMorbidities"])) {
                $coreMorb  = $_POST["coreMorbidities"];
            } else {
                $coreMorb  = array();
            }
            
            if(isset($_POST["microVascular"])) {
                $microVasc = $_POST["microVascular"];
            } else {
                $microVasc = array();
            }

            if(isset($_POST["macroVascular"])) {
                $macroVasc = $_POST["macroVascular"];
            } else {
                $macroVasc = array();
            }

            $refferdBy = $_POST["refferedBy"];
            $substance = $_POST["substanceUse"];
            $currentMedi = $_POST["currentMedi"];
            $pastMedHistory = $_POST["pastMedHistory"];
            $allergies = $_POST["allergies"];
            $familyMemName = $_POST["fmname"];
            $relation = $_POST["relate"];
            $disease = $_POST["disease"];
            $ocuupation = $_POST["ocuupation"];
            $eduLevel = $_POST["educationLevel"];
            $patient_id = $_SESSION['patient_id'];

            try{
                $conn = conn::getConnection();
                
                //Diagnosis Assigm

                $diagnosisQuery = $conn->prepare("INSERT INTO `diagnosis`(`diabetes_type`, `date`, `patient_id`) 
                                        VALUES (:dtype,:ddate,:pId)");
                $diagnosisQuery->execute([':dtype'=> $dtype, ':ddate'=> $ddate, ':pId'=> $patient_id]);
                $dId = $conn->lastInsertId();

                if(!empty($microVasc)){
                    foreach($microVasc as $complication){
                        $compQuery = $conn->prepare("INSERT INTO `complication`(`complication`, `type`, `diagnosis_id`) 
                                    VALUES (:comp,:compType,:dId)");
                        $compQuery->execute([':comp'=> $complication, ':compType'=> 'Micro Vascular', ':dId'=> $dId]);
                    }
                }
                if(!empty($macroVasc)){
                    foreach($macroVasc as $complication){
                        $compQuery = $conn->prepare("INSERT INTO `complication`(`complication`, `type`, `diagnosis_id`) 
                                    VALUES (:comp,:compType,:dId)");
                        $compQuery->execute([':comp'=> $complication, ':compType'=> 'Macro Vascular', ':dId'=> $dId]);
                    }
                }
                if(!empty($foot)){
                    foreach($foot as $complication){
                        $compQuery = $conn->prepare("INSERT INTO `complication`(`complication`, `type`, `diagnosis_id`) 
                                    VALUES (:comp,:compType,:dId)");
                        $compQuery->execute([':comp'=> $complication, ':compType'=> 'Foot', ':dId'=> $dId]);
                    } 
                }
                if(!empty($coreMorb)){
                    foreach($coreMorb as $complication){
                        $compQuery = $conn->prepare("INSERT INTO `complication`(`complication`, `type`, `diagnosis_id`) 
                                    VALUES (:comp,:compType,:dId)");
                        $compQuery->execute([':comp'=> $complication, ':compType'=> 'Core Morbidities', ':dId'=> $dId]);
                    } 
                }
                 //History
                $historyQuery = $conn->prepare("INSERT INTO `history`( `reffered_by`, `substance_use`, `medication_on`,`allergies`, `med_conditions`, `patient_id`) 
                                        VALUES (:refferdBy,:substanceUse,:medOn,:allergy,:pastMId,:pId)");
                $historyQuery->execute([':refferdBy'=> $refferdBy,':substanceUse'=> $substance,':medOn'=> $currentMedi,':allergy'=>$$allergies,':pastMId'=>$pastMedHistory,':pId'=> $patient_id]);
                $historyId = $conn->lastInsertId();
                

                //family history
                $fHistoryQuery = $conn->prepare("INSERT INTO `family_history`(`name`, `relationship`, `disease`, `history_id`) 
                                        VALUES (:name, :relate, :dieases, :hId)");
                $fHistoryQuery->execute([':name'=> $familyMemName, ':relate'=> $relation, ':dieases'=> $disease, ':hId'=> $historyId]);

                //social history
                $sHistoryQuery = $conn->prepare("INSERT INTO `social_history`( `occupation`, `edu_level`, `history_id`) 
                                                VALUES (:occupation,:eduLevel,:hId)");
                $sHistoryQuery->execute([':occupation'=> $ocuupation, ':eduLevel'=> $eduLevel, ':hId'=> $historyId]);

                $_SESSION['patient_added_success'] = true;
                log_audit_trail("Patient Registertaion", "Registered a Patient with ID: ". $patient_id, $logged_username,$role); 
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "ReciptionHome.php";
                    }, 3000); 
                </script>';
                exit;

            } catch(Exception $e) {
                echo "Error: ".$e->getMessage();
            }



        }
        ob_end_flush();
    ?>


        <!-- JavaScript -->
    <script>
        function addTextField(containerId) {
            var container = document.getElementById(containerId);
            var textField = document.createElement("input");
            textField.type = "text";
            textField.className = "form-control mb-3";
            textField.placeholder = "Enter Text";
            container.appendChild(textField);
        }


    </script>
</body>
</html>
