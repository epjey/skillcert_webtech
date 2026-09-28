<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = intval($_POST['exam_id']);
    $exam_title = mysqli_real_escape_string($conn, $_POST['exam_title']);

    if (empty($exam_title)) {
        echo json_encode(['status' => 'error', 'message' => 'Quiz title cannot be empty.']);
        exit;
    }

    $update = mysqli_query($conn, "UPDATE exams SET exam_title = '$exam_title' WHERE exam_id = $exam_id");

    if ($update) {
        echo json_encode(['status' => 'success', 'message' => 'Quiz updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
    }
}
?>
