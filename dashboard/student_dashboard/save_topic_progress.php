<?php
include("../../config/db_conn.php");


$user_id = $_SESSION['user_id'] ?? 0;
$lesson_id = intval($_POST['lesson_id']);
$topic_id = intval($_POST['topic_id']);

$check = mysqli_query($conn, "SELECT * FROM topic_progress WHERE user_id=$user_id AND topic_id=$topic_id");
if (mysqli_num_rows($check) == 0) {
  mysqli_query($conn, "INSERT INTO topic_progress (user_id, topic_id, lesson_id, status) VALUES ($user_id, $topic_id, $lesson_id, 'completed')");
}

echo json_encode(['status' => 'success']);
?>
