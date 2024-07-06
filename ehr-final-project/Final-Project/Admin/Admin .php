<?php
  session_start();
  require_once('../data/conn.php');
  require_once ('../data/conn.php');

  //Checking wheather user logged in
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
    <title>Admin Panel Home</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../Css/Adminpanel.CSS">
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

  <?php
    try{
      $conn = conn::getConnection();
      $sqlTotalStaffCount = "SELECT SUM(cnt) AS total_staff_count FROM (
                            SELECT COUNT(*) AS cnt FROM admin
                            UNION ALL
                            SELECT COUNT(*) AS cnt FROM lab_technician
                            UNION ALL
                            SELECT COUNT(*) AS cnt FROM pharmacist
                            UNION ALL
                            SELECT COUNT(*) AS cnt FROM doctor
                            UNION ALL
                            SELECT COUNT(*) AS cnt FROM receptionist) AS counts";
      
      $stmtTotalStaffCount = $conn->prepare($sqlTotalStaffCount);
      $stmtTotalStaffCount->execute();
      $totalStaffCount = $stmtTotalStaffCount->fetch(PDO::FETCH_ASSOC)['total_staff_count'];

      $sqlPatientCount = "SELECT COUNT(*) AS patient_count FROM patient";
      $stmtPatientCount = $conn->prepare($sqlPatientCount);
      $stmtPatientCount->execute();
      $patientCount = $stmtPatientCount->fetch(PDO::FETCH_ASSOC)['patient_count'];


    }catch(Exception $e){
      echo "ERROR: ".$e->getMessage();
    }
    
  ?>
        <div class="main p-3">
            <div class="text-center">
                <h1>
                    Admin Panel
                </h1>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="Accountcounts">
                <div class="stffacc">
                    <h1>
                    <B>Staff Accounts</B>
                    </h1>
                    <h1 class="text-center">
                      <?php echo $totalStaffCount;  ?>
                    </h1>
                </div>
                
                <div class="Repacc">
                    <h1>
                        <B>Patients Accounts</B>
                    </h1>
                    <h1 class="text-center">
                    <?php echo $patientCount;  ?>
                    </h1>
                </div>
            </div>  
            <br>
            <br>
            <br>
            <br>
       
            <div class="navlinkshead">
                <H1><B><u>Navigation Links</u></B></H1>
                <br>
            </div>
            <br>
            <div class="navlinkswrapper">
                <div class="navlinkscap">
                <H5>Patient Website Link</H5><br>
                <H5>Physician Website Link</H5><br>
                <H5>Lab Website Link</H5><br>
                <H5>Pharmacy Website Link</H5><br>
                <H5>Receptionist Website Link</H5>
                </div>
                <div class="vl"></div>
                 <div class="navlinks">
                 <div class="navlinks">
                  <a href="../Patient/PatientLogin.php" class="btn btn-dark btn-sm active" role="button" aria-pressed="true" target="_blank">view</a><br><br>
                  <a href="../Doctor/DoctorLogin.php" class="btn btn-dark btn-sm active" role="button" aria-pressed="true" target="_blank">view</a><br><br>  
                  <a href="../Lab/LabLogin.php" class="btn btn-dark btn-sm active" role="button" aria-pressed="true" target="_blank">view</a><br><br>
                  <a href="../Pharmacy/Pharmacy.php" class="btn btn-dark btn-sm active" role="button" aria-pressed="true" target="_blank">view</a><br><br>
                  <a href="../Reciptionist/RecipLogin.php" class="btn btn-dark btn-sm active" role="button" aria-pressed="true" target="_blank">view</a><br>
                </div>
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="../Java Script/Admin.Js"></script>
</body>
</html>