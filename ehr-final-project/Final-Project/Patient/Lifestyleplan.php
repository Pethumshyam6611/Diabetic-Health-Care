<?php
  session_start();
  require_once ('../data/conn.php');
	require_once('../data/methods.php');
  $patient_id = $_SESSION['logged_patientId'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Style Plan</title>

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


<body id="body-pd" style="background-image:url(../Images/images/bg23.jpg); background-size: 100% auto; "> 
<header class="header" id="header" style="background-color: #F0F1F3; margin-top:-2px;">
    <div class="header_toggle"><i class='bx bx-menu' id="header-toggle"></i></div>
</header>
    <div class="l-navbar" id="nav-bar">
    <nav class="nav">
            <div>
                <div class="nav_list"> 
                    <a href="PatientHome.php" class="nav_link active"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16"><path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/><path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/></svg><span class="nav_name">Home</span></a>
                    <a href="VisitsRecords.php" class="nav_link "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16"><path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/></svg><span class="nav_name">Visits Records</span></a>
                    <a href="Prescription.php" class="nav_link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16"><path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/><path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118z"/></svg><span class="nav_name">Prescription</span> </a> 
                    <a href="Labresult.php" class="nav_link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-pulse" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z"/></svg><span class="nav_name">Lab Results</span> </a> 
                    <a href="Lifestyleplan.php" class="nav_link"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg><span class="nav_name">Life Style Plan</span> </a> <a href="#" class="nav_link"></div>
            </div> 
                    <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
                   
        </nav>
    </div>
    <!--Container Main start-->
    <br>
        
    <div class="container" style="width: auto;">
    <div class="row" style="margin-left: 11px;">
    <br><br><br>
        <H2 style="-webkit-text-stroke: 1px black; color:black">Life Style Plan</H2>
    </div>
    <?php
        try {
            //Retriving Category
            $conn = conn::getConnection();
            $sql = "SELECT `category_id` FROM `patient` WHERE `patient_id` = :pID";
            $query = $conn->prepare($sql);
            $query->execute([':pID' => $patient_id]);
            $category = $query->fetch(PDO::FETCH_ASSOC);

            //Retriving plan according to the category
            $sql1 = "SELECT `food_id` FROM `dplan_food` WHERE `dplan_id` = :category";
            $query1 = $conn->prepare($sql1);
            $query1->execute([':category' => $category['category_id']]);
            $foodIds = $query1->fetchAll(PDO::FETCH_ASSOC);

            //Retriving the food list
            $foods = array();
            $sql2 = "SELECT `food_id`, `name`, `meal_time`, `amount` FROM `food` WHERE `food_id` = :fId";
            $query2 = $conn->prepare($sql2);
            foreach ($foodIds as $foodId) {
                $query2->execute([':fId' => $foodId['food_id']]);
                $food = $query2->fetch(PDO::FETCH_ASSOC);
                if ($food) {
                    $foods[] = $food;
                }
            }

        } catch (Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
        }
    ?>
<div class="row">
    <div class="col-md-7 mx-4 d-flex " style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;width: -webkit-fill-available;">
        <div class="row py-4 px-4">
            <h4 style="color: black;"><b>Dietary Plan</b></h4>
            <div class="d-flex">
                <div class="col-md-4  py-4 ">
                    <div class="row">
                        <h6 style="color: black;"><b><u>Breakfast:</u></b></h6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Breakfast") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                    </div>
                <div class="row">
                        <H6 style="color: black;"><B><u>Breakfast-Snack:</u></B></H6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Breakfast-Snack") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                </div>
                    <div class="row">
                        <H6 style="color: black;"><B><u>Lunch:</u></B></H6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Lunch") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                    </div>
                    <div class="row">
                        <H6 style="color: black;"><B><u>Evening:</u></B></H6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Evening") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                </div> 
                <div class="row">
                        <H6 style="color: black;"><B><u>Dinner:</u></B></H6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Dinner") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                </div> 
                <div class="row">
                        <H6 style="color: black;"><B><u>Bedtime:</u></B></H6>
                        <table class="table">
                          <tbody>
                              <?php foreach ($foods as $food) : ?>
                                  <?php if ($food['meal_time'] == "Before Bed") : ?>
                                      <tr>
                                          <td><?php echo $food['name']; ?></td>
                                          <td><?php echo $food['amount']; ?></td>
                                      </tr>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          </tbody>
                      </table>
                </div>    
                </div>
                <div class="col-md-8" style="display: flex; align-items: center; justify-content: center;">
  <img src="../Images/images/dieataryplan.png">
</div> 
                    
                </div>
                

            </div>
            </div>

            <div class="col-md-7 mx-4 d-flex "style="background-color: white; border-radius:18px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; margin-top:20px;width: -webkit-fill-available;">
            <div class="row py-4 px-4">
            <H4 style="color: black;"><b>Activity Plan</b></H4>
            <div class="d-flex flex-wrap">
  
            <?php
                try {
                    $sql1 = "SELECT `activity_id` FROM `eplan_activity` WHERE `eplan_id` = :category";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute([':category' => $category['category_id']]);
                    $activityIds = $query1->fetchAll(PDO::FETCH_ASSOC);

                    $activities = array(); 

                    $sql2 = "SELECT `activity_id`, `name`, `intensity`, `duration` FROM `physical_activity` WHERE `activity_id`=:id";
                    $query2 = $conn->prepare($sql2);
                    
                    foreach ($activityIds as $activityId) {
                        $query2->execute([':id' => $activityId['activity_id']]);
                        $activity = $query2->fetch(PDO::FETCH_ASSOC); 
                        if ($activity) {
                            $activities[] = $activity; 
                        }
                    }
                } catch (Exception $e) {
                    echo 'Error connecting to database: ' . $e->getMessage();
                }
              ?>
            <div class="col-md-4 py-4">
                <table class="table table-bordered table-striped" style="border-color:#41a5ee;">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Intensity</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activities as $a) : ?>
                            <tr>
                                <td><?php echo $a['name']; ?></td>
                                <td><?php echo $a['intensity']; ?></td>
                                <td><?php echo $a['duration']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> <!-- Add the closing </table> tag here -->
            </div>
            <div class="col-md-6 mx-5 d-flex justify-content-center align-items-center">
              <img src="../Images/images/Activityplanpic.png" alt="Activity Plan">
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
    #dplanpic{
        width: 100%;
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