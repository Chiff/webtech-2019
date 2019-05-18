<?php
if (isset($_POST['data'])) {

    $download_file = "../../uploaded/student_stats.csv";
    $fp = fopen($download_file, 'w');

    $data = json_decode($_POST['data'], true);
    fputcsv($fp, array("ais_id", "student_name", "points"), ';');

    foreach ($data as $row) {
        fputcsv($fp, $row, ';');
    }
    fclose($fp);

    echo "../../uploaded/student_stats.csv";
}