<?php
  session_start();
  require_once('../data/conn.php');
  require_once ('../data/methods.php');
  if(!isset($_SESSION['logged_username'])) {
    header("Location: logout.php");
    exit; 
   } 
  $logged_username = $_SESSION['logged_username'];
	$role = $_SESSION['logged_role']; 
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Activites</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/AdminpanelManageUser.css">
    <link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">
</head>

<body>
    <div class="wrapper">
    <aside id="sidebar">
  <div class="d-flex">
    <button class="toggle-btn" type="button">
      <i class="lni lni-grid-alt"></i>
    </button>
    <div class="sidebar-logo">
      <a href="#">Admin Panel</a>
    </div>
  </div>
  <ul class="sidebar-nav">
    <li class="sidebar-item">
    <a href="../Admin/Admin .php" class="sidebar-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
</svg>
        <span>Home</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="#" data-bs-toggle="collapse" data-bs-target="#manageUserSubMenu" class="sidebar-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
  <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
</svg>
        <span>Manage User</span>
      </a>
      <div class="collapse submenu" id="manageUserSubMenu" style="margin-left: 30px;">  
      <a href="../Admin/AdminManageUserLab.php" class="sidebar-link"><span>Lab Technician</span></a>
        <a href="../Admin/AdminManageUserPharmecy.php" class="sidebar-link"><span>Pharmacist</span></a>
        <a href="../Admin/AdminManageUserDoctor.php" class="sidebar-link"><span>Doctor</span></a>
        <a href="../Admin/AdminManageUserRec.php" class="sidebar-link"><span>Receptionist</span></a>
        <a href="../Admin/AdminManageUserAdmin.php" class="sidebar-link"><span>Admin</span></a>
      </div>
    </li>
    <li class="sidebar-item">
      <a href="#" data-bs-toggle="collapse" data-bs-target="#LifestyleSubMenu" class="sidebar-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
  <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
</svg>
        <span>Life Style Plan</span>
      </a>
      <div class="collapse submenu" id="LifestyleSubMenu" style="margin-left: 30px;">  <a href="../Admin/AdminDieatary.php" class="sidebar-link"><span>Dietary</span></a>
        <a href="../Admin/Adminllifestyle.php" class="sidebar-link"><span>Activity</span></a>
      </div>
    </li>
    <li class="sidebar-item">
      <a href="../Admin/AdminAudittrail.php" class="sidebar-link">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z"/>
</svg>
        <span>Audit Trail</span>
      </a>
    </li>
  </ul>
  <div class="sidebar-footer">
  <a href="logout.php" class="sidebar-link">
      <i class="lni lni-exit"></i>
      <span>Logout</span>
    </a>
  </div>
</aside>
        <div class="main p-3">
            <div class="text-center">
                <h1>
                    Activity Plan
                </h1>
            </div>
            <br>
            <br>
            <div class="container mt-3  " style="margin-left: 59px;;">
           
            <!-- Activity Adding Form-->
              <form action="" method="post">
                <div class="row">
                  <div class="col">
                    <div class="mb-3 d-inline-flex">
                      <div class="input-group">
                          <select class="form-select" name="category" id="mealTime" required>
                            <option value="">Select Category</option>
                            <option value="Category 1">Category 1 </option>
                            <option value="Category 2">Category 2</option>
                            <option value="Category 3">Category 3</option>
                          </select>
                        </div>
                        <input type="text" name="activity" class="form-control mx-2" id="foodInput" placeholder="Enter Activity">
                        
                        <div class="input-group">
                          <select class="form-select" name="intensity" id="mealTime" style="margin-right: 5px;" required>
                            <option value="">Select Intensity</option>
                            <option value="Low">Low</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Vigorous">Vigorous</option>
                          </select>
                        </div>

                      <input type="text" name="duration" class="form-control" id="amountInput" placeholder="Enter Duration">
                      <button type="submit" name="btnAdd" class="btn btn-primary ms-2">ADD</button>
                    </div>
                  </div>
                </div>
              </form>
          </div>
          <?php
              if(isset($_POST['btnAdd'])){
                $category = $_POST["category"];
                $activity = $_POST["activity"];
                $intensity = $_POST["intensity"];
                $duration = $_POST["duration"];

                try{
                  $conn = conn::getConnection();
                  $activityQuery = $conn->prepare("INSERT INTO `physical_activity`(`name`, `intensity`, `duration`) 
                                      VALUES 
                                      (:name, :intensity, :duration)");
                  $activityQuery->execute([':name'=> $activity, ':intensity'=> $intensity, ':duration'=> $duration]);
                  $activityId = $conn->lastInsertId();
                  $eplanQuery = $conn->prepare("INSERT INTO `eplan_activity`(`eplan_id`, `activity_id`) 
                                    VALUES (:eplanId, :activity_id)");

                  if($category == "Category 1"){
                    $eplanQuery->execute([':eplanId'=> 1, ':activity_id'=> $activityId]);

                  } elseif($category == "Category 2"){
                    $eplanQuery->execute([':eplanId'=> 2, ':activity_id'=> $activityId]);

                  } elseif($category == "Category 3") {
                    $eplanQuery->execute([':eplanId'=> 3, ':activity_id'=> $activityId]);

                  } 
                  log_audit_trail("Manage Lifestyle Plan", "Added Activity ID: ".$activityId." to " .$category, $logged_username,$role); 
                  $_SESSION['success_message'] = "Successfully added.";

                } catch(Exception $e){
                  echo "Erre: ".$e->getMessage();
                }
              }
              if(isset($_SESSION['success_message'])) {
                echo '<div id="successMessage" class="alert alert-success" role="alert">
                        ' . $_SESSION['success_message'] . '
                      </div>';
                unset($_SESSION['success_message']);
              }

            ?>
            <br>
            <br>
           
            <div class="container">
            <H1>Category 1 (High Risk Patient)</H1><br>
                <div class="row">
                    <div class="col-md-12">
                    <div class="table-responsive">
                    <?php
                              try{
                                $activity_category_1 = [];
                                $activity_category_2 = [];
                                $activity_category_3 = [];
                                
                                $conn = conn::getConnection();

                                //getting category 1 activity ids
                                $sql_category_1 = "SELECT * FROM `eplan_activity` WHERE `eplan_id`= 1";
                                $query_category_1 = $conn->prepare($sql_category_1);
                                $query_category_1->execute();
                                $activity_category_1_records = $query_category_1->fetchAll(PDO::FETCH_ASSOC);

                                $activityIdsCategory1 = array_column($activity_category_1_records, 'activity_id');
                                if (!empty($activityIdsCategory1)) {
                                  $activityQueryCategory1 = $conn->prepare("SELECT * FROM `physical_activity` WHERE `activity_id` IN (" . implode(',', $activityIdsCategory1) . ")");
                                  $activityQueryCategory1->execute();
                                  $activity_category_1 = $activityQueryCategory1->fetchAll(PDO::FETCH_ASSOC);
                                } else {
                                    $activity_category_1 = array(); 
                                }

                                //getting category 2 food ids
                                $sql_category_2 = "SELECT * FROM `eplan_activity` WHERE `eplan_id`= 2";
                                $query_category_2 = $conn->prepare($sql_category_2);
                                $query_category_2->execute();
                                $activity_category_2_records = $query_category_2->fetchAll(PDO::FETCH_ASSOC);

                                $activityIdsCategory2 = array_column($activity_category_2_records, 'activity_id');
                                if (!empty($activityIdsCategory2)) {
                                  $activityQueryCategory2 = $conn->prepare("SELECT * FROM `physical_activity` WHERE `activity_id` IN (" . implode(',', $activityIdsCategory2) . ")");
                                  $activityQueryCategory2->execute();
                                  $activity_category_2 = $activityQueryCategory2->fetchAll(PDO::FETCH_ASSOC);
                                } else {
                                    $activity_category_2 = array(); 
                                }

                                //getting category 3 food ids
                                $sql_category_3 = "SELECT * FROM `eplan_activity` WHERE `eplan_id`= 3";
                                $query_category_3 = $conn->prepare($sql_category_3);
                                $query_category_3->execute();
                                $activity_category_3_records = $query_category_3->fetchAll(PDO::FETCH_ASSOC);

                                $activityIdsCategory3 = array_column($activity_category_3_records, 'activity_id');
                                if (!empty($activityIdsCategory3)) {
                                  $activityQueryCategory3 = $conn->prepare("SELECT * FROM `physical_activity` WHERE `activity_id` IN (" . implode(',', $activityIdsCategory3) . ")");
                                  $activityQueryCategory3->execute();
                                  $activity_category_3 = $activityQueryCategory3->fetchAll(PDO::FETCH_ASSOC);
                                } else {
                                    $activity_category_3 = array(); 
                                }

                              } catch(Exception $e){
                                echo "Error in Here: ".$e->getMessage();
                              }

                            ?>         
                          <table id="mytable" class="table table-bordred table-striped">
                               <!--Category 1 Table-->
                            <?php if (!empty($activity_category_1)) : ?> 
                               <thead>
                               <th>Activity</th>
                                <th>Intensity</th>
                                 <th>Duration</th>
                                 <th>Action</th>
                               </thead>
                                <tbody>
                                <?php foreach ($activity_category_1 as $activity1) :?>
                                  <tr>
                                    <td> <?php echo $activity1['name'];?> </td>
                                    <td> <?php echo $activity1['intensity'];?> </td>
                                    <td> <?php echo $activity1['duration'];?> </td>
                                    <td>
                                      <form method="post">
                                          <input type="hidden" name="activity_id" value="<?php echo $activity1['activity_id']; ?>">
                                          <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Delete</button>
                                      </form>
                                    </td>
                                  </tr>
                                  <?php endforeach; ?>
                                </tbody>
                                  <?php else : ?>
                                        <p>No activity plans found for this category.</p>
                                    <?php endif; ?>  
                          </table>    
                        </div>
                    </div>
                </div>
            </div>
            
        
            <br>
            <br>
            <br>
            <div class="container">
            <H1>Category 2 (Moderate Risk Patient)</H1> <br>
                <div class="row">
                    
                    
                    <div class="col-md-12">

                    <div class="table-responsive">
            
                            
                    <table id="mytable" class="table table-bordred table-striped">
                               <!--Category 1 Table-->
                            <?php if (!empty($activity_category_2)) : ?> 
                               <thead>
                               <th>Activity</th>
                                <th>Intensity</th>
                                 <th>Duration</th>
                                 <th>Action</th>
                               </thead>
                                <tbody>
                                <?php foreach ($activity_category_2 as $activity1) :?>
                                  <tr>
                                    <td> <?php echo $activity1['name'];?> </td>
                                    <td> <?php echo $activity1['intensity'];?> </td>
                                    <td> <?php echo $activity1['duration'];?> </td>
                                    <td>
                                      <form method="post">
                                          <input type="hidden" name="activity_id" value="<?php echo $activity1['activity_id']; ?>">
                                          <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Delete</button>
                                      </form>
                                    </td>
                                  </tr>
                                  <?php endforeach; ?>
                                </tbody>
                                  <?php else : ?>
                                        <p>No activity plans found for this category.</p>
                                    <?php endif; ?>  
                          </table> 

                            
                        </div>
                        
                    </div>
                </div>
            </div>
            
        
          

            <br>
            <br>
           
            <div class="container">
            <H1>Category 3 (No Risk)</H1>
                <div class="row">
                    
                    
                    <div class="col-md-12">

                    <div class="table-responsive">
            
                            
                    <table id="mytable" class="table table-bordred table-striped">
                               <!--Category 2 Table-->
                            <?php if (!empty($activity_category_3)) : ?> 
                               <thead>
                               <th>Activity</th>
                                <th>Intensity</th>
                                 <th>Duration</th>
                                 <th>Action</th>
                               </thead>
                                <tbody>
                                <?php foreach ($activity_category_3 as $activity1) :?>
                                  <tr>
                                    <td> <?php echo $activity1['name'];?> </td>
                                    <td> <?php echo $activity1['intensity'];?> </td>
                                    <td> <?php echo $activity1['duration'];?> </td>
                                    <td>
                                      <form method="post">
                                          <input type="hidden" name="activity_id" value="<?php echo $activity1['activity_id']; ?>">
                                          <button type="submit" name="btnDelete" class="btn btn-danger btn-sm">Delete</button>
                                      </form>
                                    </td>
                                  </tr>
                                  <?php endforeach; ?>
                                </tbody>
                                  <?php else : ?>
                                        <p>No activity plans found for this category.</p>
                                    <?php endif; ?>  
                          </table> 

                            
                        </div>
                        
                    </div>
                </div>
            </div>
            
              </div>
                </div>
 
        </div>
    </div>

    <?php

                //Delete Button Function

                if(isset($_POST['btnDelete'])){
                  $activity_id = $_POST["activity_id"];
                  try{
                    $conn = conn::getConnection();
                    $deleteQuery1 = $conn->prepare("DELETE FROM `physical_activity` WHERE `activity_id` = :activity_id");
                    $deleteQuery2 = $conn->prepare("DELETE FROM `eplan_activity` WHERE `activity_id` = :activity_id");

                    $deleteQuery1->execute([':activity_id' => $activity_id]);
                    $deleteQuery2->execute([':activity_id' => $activity_id]);
                    $_SESSION['success_message'] = "Successfully deleted.";
                    log_audit_trail("Manage Lifestyle Plan", "Delete Activity ID: ".$activity_id, $logged_username,$role); 

                  } catch (Exception $e){
                    echo "ERROR: ".$e->getMessage();
                  }
                }
                if(isset($_SESSION['success_message'])) {
                  echo '<div id="successMessage" class="alert alert-success" role="alert">
                          ' . $_SESSION['success_message'] . '
                        </div>';
                  unset($_SESSION['success_message']);
                }  
              ?>

              <!--JS-->
              <script>
                  setTimeout(function(){
                      document.getElementById('successMessage').style.display = 'none';
                  }, 3000);
              </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="../Java Script/Admin.js"></script>
    
</body>


</html>