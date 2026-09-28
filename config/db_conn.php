<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$db_server = "127.0.0.1";
$db_user = "root";
$db_pass = "";
$db_name = "skillcertified";

try {
    $conn = mysqli_connect(
        $db_server,
        $db_user,
        $db_pass,
        $db_name
    );
} catch (mysqli_sql_exception $e) {
    echo "Could not connect!";
    exit();
}

/* Optional for debugging
 if ($conn) {
     echo "Database connected!";
}*/
?>
