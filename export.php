<?php

require_once 'config.php';

if(isset($_GET['what'])) {
    if($_GET['what'] == 'students') {
        $sql = "SELECT * FROM students";
        $csv_cols = [
                "student_id",
                "first_name",
                "last_name",
                "email",
                "phone_number",
                "photo_path",
                "session_plan_id",
                "professor_id",
                "acces_card_pdf_path",
                "created_at"];
        
    } else if($_GET['what'] == "professors") {
        $sql = "SELECT * FROM professors";
        $csv_cols = [
                "professor_id",
                "first_name",
                "last_name",
                "email",
                "phone_number",
                "created_at"];
    } else {
        echo "Ne";
        die();
    }

    $run = $conn->query($sql);

    $results = $run->fetch_all(MYSQLI_ASSOC);

    $output = fopen('php://output', 'w');

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename=' . $_GET['what'] . ".csv");

    fputcsv($output, $csv_cols);

    foreach($results as $result) {
        fputcsv($output, $result);
    }
    fclose($output);
}
