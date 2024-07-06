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
    ob_start();
  
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin</title>
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
      <?php
        try{
            $conn = conn::getConnection();
            $sql = "SELECT admin.admin_id, admin.staff_id, admin.name, admin.email, admin.contact, user.username 
                      FROM admin 
                      INNER JOIN user ON admin.user_id = user.user_id";
            $results = $conn->query($sql);

        } catch(Exception $e){
          echo "ERROR: ".$e->getMessage();
        }

      ?>
        <div class="main p-3">
            <div class="text-center">
                <h1>
                    Administator
                </h1>
            </div>
            <br>
            <br>
            <div class="Accountcounts">
                <div class="Repacc">
                    <a href="../Admin/AdminAddAdmin.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">+Add User</a>
                </div>
                
            </div>  
            <br>
            <?php
                if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
                    $deleteId = $_GET['delete'];
                    $deleteSql = "DELETE FROM `admin` WHERE admin_id = :id";
                    $stmt = $conn->prepare($deleteSql);
                    $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                      log_audit_trail("Delete Account", "Deleted Admin Account ID: " .$deleteId, $logged_username,$role);
                        echo "<p>Admin with ID $deleteId has been deleted.</p>";
                        header("Location: {$_SERVER['PHP_SELF']}");
                        exit;
                    } else {
                        echo "Error deleting record: " . $stmt->errorInfo();
                    }
                }
            ?>
            <br>
           
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <h4>Admin List</h4>
                    <div class="table-responsive">
                      <table id="mytable" class="table table-bordred table-striped">
                        <thead>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>email</th>
                          <th>Action</th>
                        </thead>

                        <tbody>
                
                          <form action="" method="get">
                            <?php foreach ($results as $result) : ?>
                    
                                <tr>
                                  <td><?php echo $result['staff_id']; ?></td>
                                  <td><?php echo $result['username']; ?></td>
                                  <td><?php echo $result['name']; ?></td>
                                  <td><?php echo $result['contact']; ?></td>
                                  <td><?php echo $result['email']; ?></td>
                                  <td>
                                  <a href='AdminUserAdminEdit.php?id=<?php echo htmlspecialchars($result['admin_id']); ?>' class='btn btn-primary btn-sm'>Edit</a>

                                      <a href='?delete=<?php echo htmlspecialchars($result['admin_id']); ?>' class='btn btn-danger btn-sm'>Delete</a>
                                  </td>
                                  
                                </tr>
                              <?php endforeach; ?>
                          </form>
                        </tbody>
                      </table>   
                     </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="../Java Script/Admin.js"></script>
    
</body>


</html>