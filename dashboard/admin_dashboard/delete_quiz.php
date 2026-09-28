<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = intval($_POST['exam_id']);
    if ($exam_id) {

        // Delete related questions first
        mysqli_query($conn, "DELETE FROM exam_questions WHERE exam_id=$exam_id");

        // Delete the quiz
        if (mysqli_query($conn, "DELETE FROM exams WHERE exam_id=$exam_id")) {
            echo json_encode(['status'=>'success','message'=>'Quiz deleted successfully!']);
        } else {
            echo json_encode(['status'=>'error','message'=>'DB error: '.mysqli_error($conn)]);
        }

    } else {
        echo json_encode(['status'=>'error','message'=>'Invalid quiz ID']);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
