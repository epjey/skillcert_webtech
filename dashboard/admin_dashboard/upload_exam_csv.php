<?php
include("../../config/db_conn.php");

if (!isset($_POST['exam_id'])) {
    die("<div class='alert alert-danger'>Missing exam_id in POST.</div>");
}

$exam_id = intval($_POST['exam_id']);

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    die("<div class='alert alert-danger'>No valid CSV file uploaded.</div>");
}

$file = $_FILES['csv_file']['tmp_name'];
$handle = fopen($file, "r");

if (!$handle) {
    die("<div class='alert alert-danger'>Failed to open uploaded file.</div>");
}

$inserted_count = 0;
$header = true;

while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    // Skip the header row
    if ($header) { 
        $header = false; 
        continue; 
    }

    // Skip empty rows
    if (count($data) < 6 || empty(trim($data[0]))) continue;

    $question = mysqli_real_escape_string($conn, trim($data[0]));
    $a = mysqli_real_escape_string($conn, trim($data[1]));
    $b = mysqli_real_escape_string($conn, trim($data[2]));
    $c = mysqli_real_escape_string($conn, trim($data[3]));
    $d = mysqli_real_escape_string($conn, trim($data[4]));
    $correct = mysqli_real_escape_string($conn, trim($data[5]));

    $insert = "
        INSERT INTO exam_questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_answer)
        VALUES ($exam_id, '$question', '$a', '$b', '$c', '$d', '$correct')
    ";
    if (mysqli_query($conn, $insert)) {
        $inserted_count++;
    }
}

fclose($handle);

// Update total_items in exams table
mysqli_query($conn, "UPDATE exams SET total_items = $inserted_count WHERE exam_id = $exam_id");

if ($inserted_count > 0) {
    echo "<div class='alert alert-success'>
            <strong>Success!</strong> $inserted_count questions uploaded.
            <br>Total items updated successfully.
          </div>";
} else {
    echo "<div class='alert alert-warning'>No valid questions found in CSV.</div>";
}
?>
