<?php
include("../../config/db_conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["student_id"])) {
        $id = $_POST["student_id"];
    } else {
        $id = "";
    }


    if ($id !== "") {
        $sql = "DELETE FROM users WHERE user_id = '$id' AND role = 'student'";

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            echo "success";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: No student ID provided.";
    }
}
?>
