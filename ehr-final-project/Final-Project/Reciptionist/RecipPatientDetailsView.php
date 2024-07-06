<?php
  session_start();
  require_once ('../data/conn.php');
  require_once('../data/methods.php');

  if(isset($_GET['patientID'])) {
    $patientID = $_GET['patientID'];
  } else {
      echo "Patient ID not provided!";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Patient Details</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
      <link rel="stylesheet" href="../Css/Reciption P reg.css">
      <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
  </head>

  <body>
    <header class="row py-3" style="background-color: dodgerblue;">
        <div class="col-1 d-flex align-items-center" style="margin-left: 20px;">
          <a href="ReciptionHome.php" class="btn btn-danger" style="background-color: red;">Back</a>
        </div>
        <div class="col text-center">
          <h2 class="text-white mb-0"><b>Patient Details</b></h2>
        </div>
      </header>
    <br>
    <br>
    <br>

    <?php
      
      try{
        $conn = conn::getConnection();
        $query = $conn->prepare("SELECT `phn`, `nic`, `first_name`, `last_name`, `name_with_intials`, `dob`, `house_no`, `street`, `city`, `gender`, `contact`, `email`, `picture`, `emergency_contact_id` 
                      FROM `patient` WHERE `patient_id` = :patientID");
        $query->bindParam(':patientID', $patientID);
        $query->execute();
        $patient = $query->fetch(PDO::FETCH_ASSOC);
        if((!$patient)) {
          echo "Patient not found!";
          exit; 
        }
        $emergecyContact = $patient['emergency_contact_id'];

        $eQuery = $conn->prepare("SELECT `name`, `relationship`, `contact` FROM `emergency_contact` WHERE `contact_id`= :econtactId");
        $eQuery->bindParam(':econtactId',$emergecyContact);
        $eQuery->execute();
        $eContact = $eQuery->fetch(PDO::FETCH_ASSOC);


        if((!$eContact)) {
          echo "Contact not found!";
        }
        $diagnosisQuery = $conn->prepare("SELECT `diabetes_type`, `date` FROM `diagnosis` WHERE `patient_id` = :pId");
        $diagnosisQuery->bindParam(':pId', $patientID);
        $diagnosisQuery->execute();
        $diagnosis = $diagnosisQuery->fetch(PDO::FETCH_ASSOC);

        if((!$diagnosis)) {
          echo "Diagnosis not found!";
        }
        
        

        //
        
        ?>
        <Div class="row justify-content-center d-flex">
        <div class="col-md-5 py-3 mx-2" style="background-color:#efefef; border-radius:16px; ">
            <div class="row">
              <h4 class="mb-4 text-center"><u><b>Patient Details</b></u></h4>
            </div>
            <div class="d-flex text-center">
              <div style="width:62%;">
                        <?php
                           if (!empty($patient['picture'])) {
                            $pictureData = base64_encode($patient['picture']);
                            $finfo = finfo_open();
                            $mimeType = finfo_buffer($finfo, base64_decode($pictureData), FILEINFO_MIME_TYPE);
                            finfo_close($finfo);
                        
                            $validTypes = ['image/jpeg', 'image/png']; 
                        
                            if (in_array($mimeType, $validTypes)) {
                              $pictureSrc = "data:$mimeType;base64,$pictureData";
                              echo "<img src='$pictureSrc' alt='Patient Picture' style='width: 80%; border-radius:50%'>";
                            } else {
                              echo "<p>Invalid image type</p>";
                            }
                          } else {
                            echo "<p>No picture available</p>";
                          }
                        ?>
              </div>
        <div Style="width: 60%; text-align: left; ">
        <br>
        <br>
        
              <h6><B>PHN: <?php echo $patient['phn']; ?> </B></h6>
              <h6><B>NIC: <?php echo $patient['nic']; ?> </B></h6>
              <h6><B>First Name: <?php echo $patient['first_name']; ?></B></h6>
              <h6><B>Last Name: <?php echo $patient['last_name']; ?></B></h6>
              <h6><B>Name With Initial: <?php echo $patient['name_with_intials'] ; ?></B></h6>
              <h6><B>Date Of Birthday: <?php echo $patient['dob'] ; ?></B></h6>

              <?php
                $dob = new DateTime($patient['dob']);
                $currentDate = new DateTime();
                $age = $currentDate->diff($dob)->y;
                echo "<h6><B>Age: $age years</B></h6>";
              ?>
              <h6><B>Gender: <?php echo $patient['gender'] ; ?></B></h6>
        </div>
            </div>
        </div>
        <div class="col-md-6 py-3 mx-2 " style="background-color:#efefef; border-radius:16px;">
            <div class="row">
              <h4 class="mb-4 text-center" style="margin-bottom: 19px;"><u><b>Contact Details</b></u></h4>
            </div>
            <br>
          <br>
            <div class="d-flex ">
              <div style="margin-left:50px;">
              <h6>
              <B>Address: 
                <?php echo $patient['house_no'] ; ?>,
                <?php echo $patient['street'] ; ?>,
                <?php echo $patient['city'] ; ?>
              </B></h6> 
              
              <h6><B>Phone Number: <?php echo $patient['contact'] ; ?> </B></h6>
              </div>

            </div>
            <br>
            <div class="row">
              <h4 class="mb-4 text-center"><u><b>Emergency Contact Details</b></u></h4>
            </div>
            <br>
            
            <div>
              <div style="margin-left:50px;">
              <h6><B>Name: <?php echo $eContact['name'] ; ?></B></h6>
              <h6><B>Relationship: <?php echo $eContact['relationship'] ; ?></B></h6> 
              <h6><B>Phone Number: <?php echo $eContact['contact'] ; ?></B></h6>         
              </div>
            </div>
        </div>
      </Div>
      <br>
      
      
      <Div class="row justify-content-left d-flex " style="margin-left: 27px;">
      <div class="col-md-5 py-3 mx-2 justify-content-center" style="background-color:#efefef; border-radius:16px; ">
      
          <div class="row">
            <h4 class="mb-4 text-center"><u><b>Diagnosis</b></u></h4>
          </div>
          <div class="d-flex justify-content-center ">
      <div class="text-left"  style="width: 60%;">
      <br>
      
      
            <h6><B>Diabates Type: <?php echo $diagnosis['diabetes_type'] ; ?> </B></h6>
            <h6><B>Diagnosis Date: <?php echo $diagnosis['date'] ; ?></B></h6>
      </div>
          </div>
      </div>
      </Div>

  <?php
      } catch(Exception $e){
        echo "Error: ".$e->getMessage();
      }
    ?>
  
 
    <br>
    <br>
    <br>        
  </body>
</html>