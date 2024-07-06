<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');
    $currentDate = date("Y-m-d");


    if(isset($_GET['patientId'])) {
        $patient_id = $_GET['patientId'];
      } else {
        echo "ID not provided!";
      }

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
    
      $queryMedList = $conn->prepare("SELECT `med_id`,`med_name`,`status` FROM `medicine`");
      $queryMedList->execute();
      $medList = $queryMedList->fetchAll(PDO::FETCH_ASSOC);

    
    }

?>
<?php
function getMedicineName($medId, $medList) {
    foreach ($medList as $medicine) {
        if ($medicine['med_id'] == $medId) {
            return $medicine['med_name'];
        }
    }
    return ''; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Reciption P reg.css">
<!-- Link jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Link Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>
<body>
<header class="row py-3" style="background-color: dodgerblue;">
    <div class="col text-center">
      <h2 class="text-white mb-0"><b>Add Prescription</b></h2>
        </div>
            </header>

    <div class="container">
       
        <br>
        <br>
        <br>
        <br>
        <?php 
            if(isset($_POST['btnAdd'])) {
                $medId = $_POST['medId'];
                $dosage = $_POST['dosage'];
                $freq = $_POST['freq'];
                $duration = $_POST['duration'];
                
                if (!isset($_SESSION['prescription'])) {
                    $_SESSION['prescription'] = [];
                }
                $_SESSION['prescription'][] = array(
                    'medId' => $medId,
                    'dosage' => $dosage,
                    'freq' => $freq,
                    'duration' => $duration
                );
            }
            if(isset($_POST['btnSave'])) {
                if(isset($_SESSION['prescription'])) {
                    try{
                        $conn = conn::getConnection();

                        //Insertion to prescription table
                        $sqlPres = "INSERT INTO `prescription`(`prescribed_date`, `p_status`, `patient_id`, `doc_id`) 
                            VALUES (:date, :status, :pId, :docId)";
            
                        $queryPres = $conn->prepare($sqlPres);
                        $queryPres->execute([
                            ':date' => $currentDate,
                            ':status' => "Pending",
                            ':pId' => $patient_id,
                            ':docId' => $doc_id
                        ]);
                        $precriptionId = $conn->lastInsertId();
            
                    foreach($_SESSION['prescription'] as $medicine) {
                        $frequency =  $medicine['freq'];
                        $dur =  $medicine['duration'];
                        $dose =  $medicine['dosage'];
                        $med_id =  $medicine['medId'];
                        
                        $conn = conn::getConnection();
                        
                        //Insertion to Precribed_Medincine Table
                        $sqlPresMed = "INSERT INTO `prescribed_medicine`(`frequency`, `duration`, `dosage`, `med_id`) 
                                        VALUES (:freq, :duration, :dosage, :med_id)";
                        $queryPresMed = $conn->prepare($sqlPresMed);
                        $queryPresMed->execute([':freq' => $frequency, ':duration'=> $dur,':dosage'=> $dose ,':med_id'=> $med_id]);
                        $presMedId = $conn->lastInsertId();

                        $query1 = $conn->prepare("INSERT INTO `prescription_prescribed_med`(`precription_id`, `pmed_id`) VALUES (:p_id, :pmed_id)");
                        $query1->execute([':p_id'=>$precriptionId, ':pmed_id'=> $presMedId]);

                    } 
                } catch (Exception $e){
                    echo 'Error connecting to database: ' . $e->getMessage();
                }
                    unset($_SESSION['prescription']);
                }
                $_SESSION['pres_added_success'] = true;
                            header("Location: DoctorPatientView.php?patientId=".$patient_id);
                            exit;
            }

            if(isset($_POST['btnDelete'])) {
                $index = $_POST['index'];
                if(isset($_SESSION['prescription'][$index])) {
                    unset($_SESSION['prescription'][$index]);
                }
            }
        ?>
    <form method="post"> 
        <div class=" justify-content-center d-flex">
                <div class="col-md-4 py-3">
                   <div class="d-flex">
                       <div class="form-group mx-1"  style="width: 200px;">
                

                           <label for="patientNumber">Drug Name:</label>
                           <select class="btn btn-primary"  name="medId" id="testType" style="width: fit-content;">
                                <option value=""  style="background-color: white; color: black; text-align: left;" restr>Select Drug</option>
                                <?php foreach ($medList as $list) : ?>
                                    <?php if ($list['status'] == "Unavailable") : ?>
                                        <option class="form-control" value="<?php echo $list['med_id']; ?>" data-status="unavailable" style="background-color: white; color: red; text-align: left; width: fit-content; margin:0%;"><?php echo $list['med_name']; ?></option>
                                    <?php else : ?>
                                        <option class="form-control" value="<?php echo $list['med_id']; ?>" data-status="available" style="background-color: white; color: black; text-align: left; width: fit-content;"><?php echo $list['med_name']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                       </div>
                       <div class="form-group mx-1" style="margin-left: 0px;">
                            <label for="patientNumber">Dosage:</label>
                            <input type="text" class="form-control" name="dosage" id="patientNumber" placeholder="Drug Dosage" >
                       </div>
                   </div>
                   <div class="d-flex">
                       <div class="form-group mx-1">
                           <label for="patientNumber">Frequency:</label>
                           <input type="text" class="form-control" name="freq" id="patientNumber" placeholder="Frequency Per Day" >
                       </div>
                       <div class="form-group mx-1">
                            <label for="patientNumber">Duration:</label>
                           <input type="text" class="form-control" name="duration" id="patientNumber" placeholder="Duration" >
                       </div>
                   </div>

                   <div class="form-group mx-1">
                        <button type="submit" name="btnAdd" class="btn btn-primary">ADD</button>
                   </div>
                </div>
                   
                <div class="col- py-3 mx-5" style="width:67%;" >
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Drug Name</th>
                                    <th>Dosage (per day)</th>
                                    <th>Frequency</th>
                                    <th>Duration</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($_SESSION['prescription'])): ?>
                                <?php foreach($_SESSION['prescription'] as $index => $medicine): ?>
                                    <tr>
                                        <td><?php echo getMedicineName($medicine['medId'], $medList); ?></td>
                                        <td><?php echo $medicine['dosage']; ?></td>
                                        <td><?php echo $medicine['freq']; ?></td>
                                        <td><?php echo $medicine['duration']; ?></td>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                                <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
      
                </div>
        </div>
               

        <br>

           <div class="row justify-content-center">

                <div class="row justify-content-center text-center" style="margin-top: 10px;">
                    <div>
                        <button type="submit" name="btnSave" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
          

           </form>
        
        </div>
    <br>
    <br>
    <script>
    document.getElementById('testType').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var status = selectedOption.getAttribute('data-status');
        if (status === 'unavailable') {
            alert('This medicine is unavailable. Please select another one.');
            this.selectedIndex = 0;
        }
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-boQlKl8gq5zSWmmL3Yf1JNls4c0hVhU8zZH7zpVbQW0y1qivUX8ptTsnpmT4EYuh" crossorigin="anonymous"></script>          
</body>
</html>