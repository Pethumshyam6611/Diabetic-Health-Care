<?php
    session_start();
    require_once ('../data/conn.php');
    require_once('../data/methods.php');
    $id = $_GET['id'];

    if (isset($_SESSION['logged_username'])) {
        $username = $_SESSION['logged_username'];
        $user_id = $_SESSION['logged_id'];
        try {
            $conn = conn::getConnection();
            $sql = "SELECT `lab_tech_id` FROM `lab_technician` WHERE `user_id` = :user_id";
            $query = $conn->prepare($sql);
            $query->execute([':user_id' => $user_id]);
            $labUserId = $query->fetch(PDO::FETCH_ASSOC);

        }catch (Exception $e) {
            echo 'Error connecting to database: ' . $e->getMessage();

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lab Test</title>

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
<link rel="stylesheet" href="../Css/LabAddResult.css">
<link rel="icon" type="imag/jpg" href="../Images/Icons/Dieabatecare.png">

</head>

<body id="body-pd"> 
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <a href="#"  id="open-modal">
        </a>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list"> 
                <a href="LabHome.php" class="nav_link active"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Home</span> </a> 
                    <a href="LabPastTests.php" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Past Lab Tests</span> </a> 
 
                </div>
            </div> 
            <a href="logout.php"  class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>

    <!--Container Main start-->
    <div class="height-100 bg-light">
    <h4><center>Add Lab Results</center></h4>

    <?php
        try{
            $conn = conn::getConnection();
            $sql = "SELECT test_request.request_id, test_request.status , lab_test.test_name, lab_test.normal_range
                    FROM test_request
                    INNER JOIN lab_test ON test_request.test_id = lab_test.test_id
                    WHERE test_request.request_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            $lab_test = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$lab_test) {
                echo "No data found for the provided ID";

            }

        }catch (Exception $e) {
            echo 'Error fetching lab tests: ' . $e->getMessage();

        }
    ?>

    <br>
    <form method="post" enctype="multipart/form-data">
        <div class="add-drug-container">
            <div class="div-1">
                <br><br>
                <label>Test Name</label>
                <label class="label-1"> <?php echo $lab_test['test_name'] ?> </label>
                <br>
                <label>Tested Date</label>
                <input type="date" name="tested_date" required>
                <br><br>
                <label>Note</label>
                <input type="text" name="note">
            </div>

            <div class="div-1">
            <br><br>
            <label>Normal Range</label>
                <label class="label-1"> <?php echo $lab_test['normal_range'] ?></label>
                <br>
            <label>Result Value</label>
            <input type="text" name="result_value" required>
            <br><br>
            <label>Attachment</label>
            <input type="file" name="attachment" >

    
            </div>
            <script>
            function openFileSelector() {
                document.getElementById('fileInput').click();
            }
            </script>

    
        </div>
        <button type="submit" name="btnAdd">Add</button>
        </form>

        <?php
             if (isset($_POST['btnAdd'])) {
                $tested_date = $_POST['tested_date'];
                $result_value = $_POST['result_value'];
                $note = $_POST['note'];
                
        
                if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
                    $attachment = file_get_contents($_FILES['attachment']['tmp_name']);
                } 

                try {
                    $sql = "INSERT INTO `test_result` ( `date`, `result_value`, `note`, `result_attachment`, `request_id`, `labtech_id`) 
                    VALUES (:tested_date, :result_value, :note, :result_attachment, :rId, :labId)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':tested_date', $tested_date);
                    $stmt->bindParam(':result_value', $result_value);
                    $stmt->bindParam(':note', $note);


                    $stmt->bindParam(':result_attachment', $attachment, PDO::PARAM_LOB);

                    
                    $stmt->bindParam(':rId', $id);
                    $stmt->bindParam(':labId', $labUserId['lab_tech_id']);
                    $stmt->execute();

                    $sql1 = "UPDATE `test_request` SET `status`= :status WHERE `request_id` = :id";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->execute(['status' => "Confirm", ':id' => $id]);
        
                    // Display success message
                    echo '<div class="alert alert-success" role="alert">Lab result added successfully!</div>';
                    header("Location: LabHome.php");
                } catch (Exception $e) {
                    echo 'Error adding lab result: ' . $e->getMessage();
                    
            }
        }
        ?>
    </div>



    <!--Modal start-->    
            <div class="modal__container" id="modal-container">
                <div class="modal__content">
                    <div class="modal__close close-modal" title="Close">
                        <i class='bx bx-x'></i>
                    </div>

                    <h1 class="modal__title">Account Details</h1>

                    <img src="../Images/images/pngwing.com.png" class="Profilepicture" srcset="">
                    <br>
                    <br>
                    <h5 class="details"><B>Name:</B> <span>Pethum</span></h5>
                    <h5 class="details"><B>Username:</B> <span>Pethum</span></h5>
                    <h5 class="details"><B>ID:</B><span>Pethum</span></h5>

                </div>
            </div>
    <!--Modal end-->
    


    <!--Container Main end-->
    <script src="../Java Script/main.js"></script>
    <script src="../Java Script/Reciption.JS"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> 

    

    </div> 
</body>
</html>