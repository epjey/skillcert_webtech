<?php
include("../../config/db_conn.php");

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["session_token"])) {
    header("Location: ../../authentication/login.php?error=not_logged_in");
    exit();
}

$user_id = $_SESSION["user_id"];
$token   = $_SESSION["session_token"];

$sql = "SELECT session_token, role FROM users WHERE user_id = $user_id LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    if ($row["session_token"] !== $token) {
        session_unset();
        session_destroy();
        header("Location: ../../authentication/login.php?error=session_expired");
        exit();
    }
   
    $_SESSION["role"] = $row["role"];
} else {
    session_unset();
    session_destroy();
    header("Location: ../../authentication/login.php?error=invalid_user");
    exit();
}

function requireRole($role) {
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== $role) {
        header("Location: ../../authentication/login.php?error=unauthorized");
        exit();
    }
}
?>
