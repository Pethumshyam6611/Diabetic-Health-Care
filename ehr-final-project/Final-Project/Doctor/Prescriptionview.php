<?php
  session_start();
  require_once ('../data/conn.php');
  require_once('../data/methods.php');

  if(isset($_GET['presId'])) {
    $presId = $_GET['presId'];
  } else {
    echo "ID not provided!";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription</title>
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
      <h2 class="text-white mb-0"><b>Prescription</b></h2>
    </div>
  </header>

    <div class="container">
       
        <br>
        <br>
        <br>
        <br>
  <?php
    try{
        $conn = conn::getConnection();
        $sql = "SELECT prescription.prescription_id,prescription_prescribed_med.pmed_id, 
                        prescribed_medicine.frequency,prescribed_medicine.duration,prescribed_medicine.dosage,
                         medicine.med_name
                FROM prescription 
                INNER JOIN prescription_prescribed_med ON prescription.prescription_id = prescription_prescribed_med.precription_id 
                INNER JOIN prescribed_medicine ON prescription_prescribed_med.pmed_id = prescribed_medicine.pmed_id
                INNER JOIN medicine ON prescribed_medicine.med_id = medicine.med_id
                WHERE prescription.prescription_id = :pId";
        $query = $conn->prepare($sql);
        $query->execute([':pId' => $presId]);
        $info = $query->fetchAll(PDO::FETCH_ASSOC);


    } catch (Exception $e){
        echo 'Error connecting to database: ' . $e->getMessage();
    }
  ?>
<form>
           
           <div class=" justify-content-center d-flex">
                   <div class="col- py-3 mx-5" style="width:67%;" >
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Dosage</th>
                    <th>Frequency (per day)</th>
                    <th>Duration</th>
                    
                </tr>
            </thead>
            <tbody>
            <?php foreach ($info as $i): ?>
                <tr>
                    <td><?php echo $i['med_name'] ?></td>
                    <td><?php echo $i['dosage'] ?></td>
                    <td><?php echo $i['frequency'] ?></td>
                    <td><?php echo $i['duration'] ?></td>
                    
                </tr>
                <?php endforeach; ?>  
            </tbody>
        </table>
    </div>
      
           </div>
           </div>
               

<br>

           <div class="row justify-content-center">

           <div class="row justify-content-center text-center" style="margin-top: 10px;">
    </div>
           </form>
        
    </div>
    <br>
    <br>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-boQlKl8gq5zSWmmL3Yf1JNls4c0hVhU8zZH7zpVbQW0y1qivUX8ptTsnpmT4EYuh" crossorigin="anonymous"></script>          
</body>
</html>