<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lesson_id = intval($_POST['lesson_id']);
    if ($lesson_id) {
        // Delete topics first 
        mysqli_query($conn, "DELETE FROM lesson_topics WHERE lesson_id = $lesson_id");

       
        if (mysqli_query($conn, "DELETE FROM lessons WHERE lesson_id = $lesson_id")) {
            echo json_encode(['status'=>'success', 'message'=>'Lesson deleted successfully!']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'DB error: '.mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Invalid lesson ID']);
    }
} else {
    echo json_encode(['status'=>'error', 'message'=>'Invalid request']);
}
