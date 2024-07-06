<?php
require_once('../data/conn.php');
require_once('../data/methods.php');

if (isset($_GET['presId'])) {
    $prescriptionId = $_GET['presId'];

    try {
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
        $query->execute([':pId' => $prescriptionId]);
        $info = $query->fetchAll(PDO::FETCH_ASSOC);


    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "Prescription ID not provided";
    header("Location: PatientHome.php");
        exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Prescreption</title>

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
<link rel="stylesheet" href="../Css/ReciptionHome.css">

</head>

<body id="body-pd" style="background-image:url(../Images/images/bg23.jpg); background-size: 100% ;  background-repeat: no-repeat; 
  background-attachment: fixed;  
  background-size: cover;        
  height: 100vh;">    
<!--Container Main start--> 
<header class="header" id="header" style="background-color: rgba(240, 241, 243, 0);margin-top:15px  ">
<a href="PatientHome.php"><svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="purple" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
</svg>
</a>
</header> 
<div class="container" style="margin-top: -15px;width: auto;">
  <br>
  <br>
  <br>
  
    <div class="row" >
        <H2 style="-webkit-text-stroke: 1px black; color:black;">Latest Prescription</H2>
    </div>
    <div class="bg-white"  style=" box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;border: 1px solid #41A5EE;">

            <div class="table-responsive">
            
            <div class="table-wrapper" style="height: 300px;">
                <table id="mytable" class="table table-bordred table-striped table table-fixed" style="max-width: 100%;">              
                               
                <thead>
                                <th>Drug Name</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Duration</th>
                               </thead>
                                <tbody>
                                  <?php foreach($info as $pres) : ?>
                                    <tr>
                                      <td><?php echo $pres['med_name']; ?></td>
                                      <td><?php echo $pres['dosage']; ?></td>
                                      <td><?php echo $pres['frequency']; ?></td>
                                      <td><?php echo $pres['duration']; ?></td>
                                    </tr>
                                  <?php endforeach ?>
                                
                                </tbody>
                    
            </table>                
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
      overflow-x: auto;
    }    
    .container {
      margin-left: 2rem;
      margin-right: 2rem;}
    @media (max-width: 767px) {
      body{
          background-repeat: no-repeat;  
          background-attachment: fixed;  
          background-size: cover;        
          height: 100vh;                
          margin: 0;                   
      } 
        
        #prescriptionmodal{
        max-width: 400px;
      }
      .container {
      margin-left: -0.5rem;

      }
    
      .col-lg{
          margin-left: 3rem;
          margin-right: 1rem;
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