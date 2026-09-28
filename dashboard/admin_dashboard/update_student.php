<?php
include("../../config/db_conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id     = intval($_POST["student_id"]);
    $fname  = $_POST["first_name"];
    $lname  = $_POST["last_name"];
    $email  = $_POST["email"];
    $status = $_POST["status"]; 

    $sql = "UPDATE users 
            SET first_name='$fname', last_name='$lname', email='$email', status='$status'
            WHERE user_id=$id AND role='student'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>