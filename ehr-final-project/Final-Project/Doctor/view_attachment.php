<?php
session_start();
require_once ('../data/conn.php');
require_once('../data/methods.php');
if(isset($_GET['result_id'])) {
    $result_id = $_GET['result_id'];

    $conn = conn::getConnection();
    $sqlBlob = "SELECT `result_attachment` FROM `test_result` WHERE `result_id` = :result_id";
    $queryBlob = $conn->prepare($sqlBlob);
    $queryBlob->execute([':result_id' => $result_id]);
    $blobData = $queryBlob->fetchColumn();


    header('Content-type: image/jpeg'); 
    echo $blobData;
    exit();
} else {

    echo "Result ID not provided!";
}
?>