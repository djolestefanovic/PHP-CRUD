<?php

require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $student_id = $_POST['student_id'];

    $sql = "DELETE FROM students WHERE student_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("i", $student_id);
    $message = "";

    if($run->execute()){
        $message = "clan obrisan";
    }else{
        $message = "clan nije obrisan";
    }

    $_SESSION['success_message'] = $message;
    header('location: admin_dashboard.php');
    exit();

}