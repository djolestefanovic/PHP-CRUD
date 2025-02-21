<?php

require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $student_id = $_POST['student'];
    $professor_id = $_POST['professor'];

    $sql = "UPDATE students SET professor_id = ? WHERE student_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param("ii", $student_id, $professor_id);

    $run->execute();

    $_SESSION['success_message'] = 'Trener uspesno dodeljen';

    header('location: admin_dashboard.php');
    exit();
}