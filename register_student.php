<?php

require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $session_plan_id = $_POST['session_plan_id'];
        $professor_id = 0;
        $photo_path = $_POST['photo_path'];
        $acces_card_pdf = "";
}

        $sql = "INSERT INTO students (first_name, last_name, email, phone_number, photo_path, session_plan_id, professor_id, acces_card_pdf_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $run = $conn->prepare($sql);
        $run->bind_param("sssssiis", $first_name, $last_name, $email, $phone_number, $photo_path, $session_plan_id, $professor_id, $acces_card_pdf);
        $run->execute();