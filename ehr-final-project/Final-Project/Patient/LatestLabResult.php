<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');
    if (isset($_GET['resultId'])) {
        $resultId = $_GET['resultId'];
    

        try{
            $conn = conn::getConnection();
            $sqlTest = "SELECT test_request.request_id, test_request.request_date, test_result.result_id,test_result.date, 
            test_result.result_value,test_result.note, test_result.result_attachment, lab_test.test_name, lab_test.normal_range
                        FROM test_request 
                        INNER JOIN test_result ON test_request.request_id = test_result.request_id
                        INNER JOIN lab_test ON test_request.test_id = lab_test.test_id
                        WHERE test_request.request_id = :id";
            $queryTest = $conn->prepare($sqlTest);
            $queryTest->execute([':id'=>$resultId]);
            $test = $queryTest->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo 'Error connecting to database: ' . $e->getMessage();
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
    <title>Latest Lab Result</title>

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

<body id="body-pd" style="background-image:url(../Images/images/bg23.jpg); background-size: 100% ;  background-repeat: no-repeat;  
  background-attachment: fixed;  
  background-size: cover;        
  height: 100vh;">    
<header class="header" id="header" style="background-color: rgba(240, 241, 243, 0); ">
<a href="PatientHome.php">
<svg xmlns="http://www.w3.org/2000/svg" width="65" height="65" fill="purple" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
</svg>
</a>
</header>
    
    <!--Container Main start-->
   
        
    <div class="container" style="width: fit-content;">
    <div class="row" style="margin-left: 11px; ">
        <H2 style="-webkit-text-stroke: 1px black; color:black">Latest Lab Result</H2>
    </div>

    <!-- first row-->
    <div class="row">
            <div class="col-md-6 mx-4 d-flex justify-content-center "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;width: 150%;">
                
            <div class="row py-4  text-center">
                <H5 style="color: black;padding-bottom:40px;"><B>Latest Lab Result Details</B></H5>
                <br>
                <br>
                <div class="row d-flex " style="text-align: left;">
                    <div class="row d-flex " style="text-align: left;">
                        <div class="col mx-4">
                         <!--Test Name-->    
                        <H6 style="color: black;"><b>Test Name:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $test['test_name']; ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Test Requested Date-->    
                         <H6 style="color: black;"><b>Requested Date:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $test['request_date']; ?></H6></span>
                        </b></H6>
                        <br>
                         <!--Tested-->
                        <H6 style="color: black;"><b>Tested Date:
                            <br>
                            <span><H6 style="margin-left: 20px;"><?php echo $test['date']; ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Normal Range-->
                        <H6 style="color: black;"><b>Normal Range:
                        <br>
                        <div>
                            <span><H6 style="margin-left: 20px;"><?php echo $test['normal_range']; ?></H6></span>
                        </b></H6>
                        <br>
                        <!--Result Value-->
                        <H6 style="color: black;"><b>Result Value:
                        <br>
                        <div>
                            <span><H6 style="margin-left: 20px;"><?php echo $test['result_value']; ?></H6></span>
                        </b></H6>
                        
                        <br>
                          <!--Attachment-->
                          <H6 style="color: black;"><b>Attachment:
                        <br>
                        <div>
                            <span><H6 style="margin-left: 20px;">

                            <a href="view_attachement.php?result_id=<?php echo $test['result_id']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z"/>
                            </svg>Attachment</a></H6></span>
                        </b></H6>
                        
                        </div>    
                    </div>
                       
                        
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