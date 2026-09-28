<?php
include("../../config/db_conn.php");


$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'] ?? intval($data['user_id'] ?? 0);
$exam_id = intval($data['exam_id'] ?? 0);

if (!$user_id || !$exam_id) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
    exit;
}


$check = mysqli_query($conn, "SELECT warning_count FROM security_logs WHERE user_id=$user_id AND exam_id=$exam_id");

if (mysqli_num_rows($check) > 0) {
 
    mysqli_query($conn, "UPDATE security_logs SET warning_count = warning_count + 1 WHERE user_id=$user_id AND exam_id=$exam_id");
} else {

    mysqli_query($conn, "INSERT INTO security_logs (user_id, exam_id, warning_count) VALUES ($user_id, $exam_id, 1)");
}

echo json_encode(["status" => "success"]);
?>
