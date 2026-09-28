<?php
include("../../config/db_conn.php");


$user_id = $_SESSION['user_id'] ?? 0;
$lesson_id = intval($_POST['lesson_id']);
$course_id = intval($_POST['course_id']);

$check = mysqli_query($conn, "SELECT * FROM lesson_progress WHERE user_id=$user_id AND lesson_id=$lesson_id");
if (mysqli_num_rows($check) == 0) {
  mysqli_query($conn, "INSERT INTO lesson_progress (user_id, course_id, lesson_id, status, completed_at) VALUES ($user_id, $course_id, $lesson_id, 'completed', NOW())");
}


echo json_encode(['status' => 'success']);
?>
