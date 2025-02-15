<?php

require_once 'config.php';
require_once 'fpdf/fpdf.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $session_plan_id = $_POST['session_plan_id'];
        $professor_id = 0;
        $photo_path = $_POST['photo_path'];
        $acces_card_pdf = "";


        $sql = "INSERT INTO students (first_name, last_name, email, phone_number, photo_path, session_plan_id, professor_id, acces_card_pdf_path)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $run = $conn->prepare($sql);
        $run->bind_param("sssssiis", $first_name, $last_name, $email, $phone_number, $photo_path, $session_plan_id, $professor_id, $acces_card_pdf);
        $run->execute();

        $student_id = $conn->insert_id;

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont("Arial","B",16);

        $pdf->Cell(40,10, 'Acces Card');
        $pdf->Ln();
        $pdf->Cell(40,10,'Member ID:' . $student_id);
        $pdf->Ln();
        $pdf->Cell(40,10,'Name: ' . $first_name . " " . $last_name);
        $pdf->Ln();
        $pdf->Cell(40,10,'Email: ' . $email);
        $pdf->Ln();

        $filename = 'access_cards/access_card_' . $student_id . '.pdf';
        $pdf->Output('F',$filename);

        $sql ="UPDATE students SET acces_card_pdf_path = '$filename' WHERE student_id = $student_id";
        $conn->query($sql);

        $_SESSION['success_message'] = 'Student successfully registered.';
        header('location: admin_dashboard.php');
        exit();

}