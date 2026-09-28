<?php
include("../../config/db_conn.php");
ini_set('display_errors',1); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "invalid_request";
    exit;
}

$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
if ($course_id <= 0) {
    echo "missing_id";
    exit;
}

// prevent delete if there are issued certificates
$check = mysqli_prepare($conn, "SELECT COUNT(*) FROM certificates WHERE course_id = ?");
mysqli_stmt_bind_param($check, "i", $course_id);
mysqli_stmt_execute($check);
mysqli_stmt_bind_result($check, $cnt);
mysqli_stmt_fetch($check);
mysqli_stmt_close($check);


if ($cnt > 0) {
    echo "has_certificates";
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM courses WHERE course_id = ?");
if (!$stmt) {
    echo "prepare_error: " . mysqli_error($conn);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $course_id);
if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "execute_error: " . mysqli_error($conn);
}
mysqli_stmt_close($stmt);
?>
