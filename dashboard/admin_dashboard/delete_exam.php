<?php
include("../../config/db_conn.php");

if(isset($_POST['lesson_id'])){
    $id = intval($_POST['lesson_id']);
    $query = "DELETE FROM lessons WHERE lesson_id = $id";
    if(mysqli_query($conn, $query)){
        echo json_encode(['status'=>'success','message'=>'Lesson deleted successfully']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Failed to delete lesson']);
    }
}

$exam_id = intval($_POST['exam_id']);

// Delete all related questions first
mysqli_query($conn, "DELETE FROM exam_questions WHERE exam_id = $exam_id");

// Then delete the exam itself
if (mysqli_query($conn, "DELETE FROM exams WHERE exam_id = $exam_id")) {
    echo json_encode(['status'=>'success','message'=>'Exam deleted successfully!']);
} else {
    echo json_encode(['status'=>'error','message'=>'Failed to delete exam.']);
}