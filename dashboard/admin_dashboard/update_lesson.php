<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lesson_id = intval($_POST['lesson_id']);
    $lesson_title = mysqli_real_escape_string($conn, trim($_POST['lesson_title']));
    $lesson_desc = mysqli_real_escape_string($conn, trim($_POST['lesson_description']));

    if ($lesson_id && !empty($lesson_title)) {
        $query = "UPDATE lessons SET lesson_title='$lesson_title', lesson_description='$lesson_desc' WHERE lesson_id=$lesson_id";
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status'=>'success', 'message'=>'Lesson updated successfully!']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'DB error: '.mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status'=>'error', 'message'=>'All fields are required.']);
    }
} else {
    echo json_encode(['status'=>'error', 'message'=>'Invalid request']);
}
