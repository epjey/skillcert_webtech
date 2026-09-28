<?php
include("../config/db_conn.php");

// kapag naka log in ung user mawawala na sya ng session token
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $conn->query("UPDATE users SET session_token = NULL WHERE user_id = $user_id");
}


session_unset();
session_destroy();

// redirect to login page
header("Location: login.php?logout=success");
exit();
?>
