<?php
session_start();
require_once('../data/conn.php');
require_once('../data/methods.php');

if(!isset($_SESSION['logged_username'])) {
  header("Location: logout.php");
  exit; 
 } 
$logged_username = $_SESSION['logged_username'];
$role = $_SESSION['logged_role']; 


if(isset($_SESSION['drug_added_success']) && $_SESSION['drug_added_success'] == true) {
    echo '<div class="alert alert-success" role="alert">Drug successfully added!</div>';
    unset($_SESSION['drug_added_success']);
}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Inventory</title>

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

<!--=============== CSS ===============-->
<link rel="stylesheet" href="../Css/Modalpopup.css">
<link rel="stylesheet" href="../Css/PharamacyInven.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>

<body id="body-pd"> 
<?php
            // Check if user is logged in
        if (isset($_SESSION['logged_username'])) {
            $username = $_SESSION['logged_username'];
            $user_id = $_SESSION['logged_id'];
            try{
                $conn = conn::getConnection();
                $sql1 = "SELECT `name`,`staff_id` FROM `pharmacist` WHERE `user_id` = :user_id";
                $query1 = $conn->prepare($sql1);
                $query1->execute([':user_id' => $user_id]);
                $user= $query1->fetch(PDO::FETCH_ASSOC);
    
                if($user){
                    $staff_id = $user['staff_id'];
                    $name = $user['name'];
                    $_SESSION['logged_name'] = $name;
                }
                else {
                    echo 'no entry found';
                }
            }catch(Exception $e){
                echo 'Error' . $e->getMessage();
                exit;
            }

            
        } else {
            echo '<p>You are not logged in.</p>';
        }
    ?>
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <a href="#"  id="open-modal">
        <div class="header_img"> <img src="https://assets-global.website-files.com/65c34b372e0d029b28e1caee/65c38deedb3d098d178e7053_Human-centric%20approach-p-500.png" alt=""> </div>
        </a>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list"> 
                    <a href="PharamacyHome.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a> 
                    <a href="PharamacyInventory.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Inventory</span> </a> 
                    <a href="PharamcyAddDrug.php" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Add Drugs</span> </a> 
                </div>
            </div> <a href="logout.php" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Sign Out</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light">
       
    <br>
    <br>
    <br>
   
        <div class="row mt-5">
        <div class="col-md-5 mx-auto">
                    <form method="post">
                            <div class="input-group">
                                <input class="form-control border-end-0 border" type="search" name="drugInput" placeholder="Search Medicine" id="example-search-input">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-start-0 border-bottom-0 border ms-n5" type="submit" name="btnSearch">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <?php
                    // Search functionality
                    if (isset($_POST['btnSearch'])) {
                        $searchTerm = $_POST['drugInput'];
                        $sql1 = "SELECT  * FROM `medicine` WHERE `med_id` LIKE :searchTerm OR `med_name` LIKE :searchTerm OR `status` LIKE :searchTerm OR `type` LIKE :searchTerm";
                        $conn = conn::getConnection();
                        $query1 = $conn->prepare($sql1);
                        $query1->execute([':searchTerm' => "%$searchTerm%"]);
                        $medicines = $query1->fetchAll(PDO::FETCH_ASSOC);

                    } else{
                        $sql1 = "SELECT  * FROM `medicine`";
                        $conn = conn::getConnection();
                        $query1 = $conn->prepare($sql1);
                        $query1->execute();
                        $medicines = $query1->fetchAll(PDO::FETCH_ASSOC);
                    }
                ?> 
        <br>
        <br>
        <div class="container">
                <div class="row">
                    
                    
                    <div class="col-md-12">
                    <h4>Drug List</h4>
                    <div class="table-responsive">
            
                            
                          <table id="mytable" class="table table-bordred table-striped">
                               
                               <thead>
                               <th>ID</th>
                               <th>Name</th>
                               <th>Availability</th>
                               <th>Type</th>
                               <th>MFD</th>
                               <th>EXP</th>
                               <th>Action</th>
                               </thead>
                               <tbody>
                                    <form action="" method="get">
                                    <?php foreach ($medicines as $med) : ?>
                                        <?php
                                         
                                        ?>
                                        <tr>
                                            <td><?php echo $med['med_id']; ?></td>
                                            <td><?php echo $med['med_name']; ?></td>
                                            <td><?php echo $med['status']; ?></td>
                                            <td><?php echo $med['type']; ?></td>
                                            <td><?php echo $med['manu_date']; ?></td>
                                            <td><?php echo $med['exp_date']; ?></td>
                                            <td>
                                            <a href='PharamacyEditDrug.php?med_id=<?php echo $med['med_id']; ?>' class='btn btn-primary btn-sm'>Edit</a>
                                            <a href='<?php echo $_SERVER['PHP_SELF']; ?>?delete_id=<?php echo $med['med_id']; ?>' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </form>
                                </tbody> 
                            </table>

                            <?php
                                if(isset($_GET['delete_id'])) {
                                    $delete_id = $_GET['delete_id'];

                                    try {
                                        $conn = conn::getConnection();
                                        $sql3 = "DELETE FROM `medicine` WHERE `med_id` = :delete_id";
                                        $stmt = $conn->prepare($sql3);
                                        $stmt->execute([':delete_id' => $delete_id]);

                                        $_SESSION['prescription_confirmed_success'] = true;
                                        echo '<div class="alert alert-success" style="position: fixed; top: 10%; left: 50%; transform: translate(-50%, -50%); z-index: 999;" role="alert">Drug successfully updated!</div>';
                                        log_audit_trail("Drug Inventory Manage", "Deleted Drug with ID: " .$delete_id, $logged_username,$role);
                                        header("Location: ".$_SERVER['PHP_SELF']);
                                        exit();
                                        ob_end_flush();
                                    } catch(Exception $e) {
                                        echo "Error: ".$e->getMessage();
                                    }
                                }

                            ?>
                        </div>
                        
                    </div>
                </div>
            </div>
    </div>



    <?php
            // Check if user is logged in
        if (isset($_SESSION['logged_username'])) {
            $username = $_SESSION['logged_username'];
            $user_id = $_SESSION['logged_id'];
            try{
                $conn = conn::getConnection();
                $sql1 = "SELECT `name`,`staff_id` FROM `pharmacist` WHERE `user_id` = :user_id";
                $query1 = $conn->prepare($sql1);
                $query1->execute([':user_id' => $user_id]);
                $user= $query1->fetch(PDO::FETCH_ASSOC);
    
                if($user){
                    $staff_id = $user['staff_id'];
                    $name = $user['name'];
                    $_SESSION['logged_name'] = $name;
                }
                else {
                    echo 'no entry found';
                }
            }catch(Exception $e){
                echo 'Error' . $e->getMessage();
            }
        }
    ?>








    <!--Modal start-->    
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title">Account Details</h1>

                    <img src="../Images/images/pharacist.png" class="Profilepicture" srcset="">
                    <br>
                    <br>
                    <h5 class="details"><B>Staff ID:</B><span> <?php echo $staff_id; ?> </span></h5>
                    <h5 class="details"><B>Name:</B> <span> <?php echo $name; ?> </span></h5>
                    <h5 class="details"><B>Username:</B> <span> <?php echo $username; ?> </span></h5>

                </div>
            </div>
    <!--Modal end-->
    
    <script>
    $(document).ready(function(){
        $('.btn-danger').click(function(e){
            e.preventDefault();
            var delete_link = $(this).attr('href');
            var delete_id = delete_link.split('=')[1]; 
            if(confirm("Are you sure you want to delete this drug?")) {
                $.ajax({
                    url: delete_link,
                    type: 'GET',
                    success: function(response){
                        location.reload();
                        $('.alert').fadeIn().delay(3000).fadeOut();
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>


    <!--Container Main end-->
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 

    

    </div> 
</body>
</html>