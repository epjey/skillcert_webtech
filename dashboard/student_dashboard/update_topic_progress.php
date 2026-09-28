<?php
error_reporting(E_ERROR | E_PARSE); 
header('Content-Type: application/json');
include("../../config/db_conn.php");

// Response template
$response = ['status' => 'error', 'message' => 'Unknown error'];

if (!isset($_POST['course_id'], $_POST['module_id']) || !isset($_FILES['quiz_file'])) {
    $response['message'] = 'Missing course, module, or file.';
    echo json_encode($response);
    exit;
}

$course_id = intval($_POST['course_id']);
$module_id = intval($_POST['module_id']);

// Validate foreign keys exist
$course_check = mysqli_query($conn, "SELECT 1 FROM courses WHERE course_id = $course_id");
$module_check = mysqli_query($conn, "SELECT 1 FROM modules WHERE module_id = $module_id AND course_id = $course_id");

if (mysqli_num_rows($course_check) == 0) {
    $response['message'] = 'Selected course does not exist.';
    echo json_encode($response);
    exit;
}

if (mysqli_num_rows($module_check) == 0) {
    $response['message'] = 'Selected module does not exist or does not belong to this course.';
    echo json_encode($response);
    exit;
}

// Handle uploaded CSV
$file = $_FILES['quiz_file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    $response['message'] = 'File upload error.';
    echo json_encode($response);
    exit;
}

// Open CSV
$handle = fopen($file['tmp_name'], 'r');
if (!$handle) {
    $response['message'] = 'Cannot open CSV file.';
    echo json_encode($response);
    exit;
}

$line_number = 0;
$inserted = 0;

while (($data = fgetcsv($handle)) !== false) {
    $line_number++;
    if ($line_number == 1) continue; 

    if (count($data) < 6) continue;

    $question = mysqli_real_escape_string($conn, trim($data[0]));
    $choice_a = mysqli_real_escape_string($conn, trim($data[1]));
    $choice_b = mysqli_real_escape_string($conn, trim($data[2]));
    $choice_c = mysqli_real_escape_string($conn, trim($data[3]));
    $choice_d = mysqli_real_escape_string($conn, trim($data[4]));
    $correct_answer = strtoupper(trim($data[5]));

    $exam_title = "Module $module_id Quiz"; 
    $exam_check = mysqli_query($conn, "SELECT exam_id FROM exams WHERE module_id = $module_id LIMIT 1");
    if (mysqli_num_rows($exam_check) > 0) {
        $exam_row = mysqli_fetch_assoc($exam_check);
        $exam_id = $exam_row['exam_id'];
    } else {
        mysqli_query($conn, "INSERT INTO exams (course_id, module_id, exam_title) VALUES ($course_id, $module_id, '$exam_title')");
        $exam_id = mysqli_insert_id($conn);
    }

 
    mysqli_query($conn, "INSERT INTO exam_questions (exam_id, question_text, choice_a, choice_b, choice_c, choice_d, correct_answer) 
                        VALUES ($exam_id, '$question', '$choice_a', '$choice_b', '$choice_c', '$choice_d', '$correct_answer')");
    $inserted++;
}

fclose($handle);

$response['status'] = 'success';
$response['message'] = "$inserted question(s) uploaded successfully.";
echo json_encode($response);
exit;
