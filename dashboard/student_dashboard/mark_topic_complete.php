<?php
include("../../config/db_conn.php");


$user_id = $_SESSION['user_id'] ?? 0;
$lesson_id = intval($_POST['lesson_id'] ?? 0);
$topic_id = intval($_POST['topic_id'] ?? 0);

if ($user_id && $lesson_id && $topic_id) {
    $check = mysqli_query($conn, "SELECT * FROM topic_progress WHERE user_id=$user_id AND lesson_id=$lesson_id AND topic_id=$topic_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO topic_progress (user_id, lesson_id, topic_id, completed) VALUES ($user_id, $lesson_id, $topic_id, 1)");
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Missing data"]);
}
?>
