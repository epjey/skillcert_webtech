<?php
include("../../config/db_conn.php");


$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$action = $_POST['action'];


$check = mysqli_query($conn, "SELECT status FROM student_courses_progress WHERE user_id='$user_id' AND course_id='$course_id'");
$existing = mysqli_fetch_assoc($check);

if ($action === 'start') {
    if ($existing) {
  
        if ($existing['status'] !== 'completed') {
            $sql = "UPDATE student_courses_progress 
                    SET status='in_progress', completed_at=NULL 
                    WHERE user_id='$user_id' AND course_id='$course_id'";
            mysqli_query($conn, $sql);
        }
    } else {
        
        $sql = "INSERT INTO student_courses_progress (user_id, course_id, status)
                VALUES ('$user_id', '$course_id', 'in_progress')";
        mysqli_query($conn, $sql);
    }
}

if ($action === 'complete') {
    $sql = "UPDATE student_courses_progress 
            SET status='completed', completed_at=NOW() 
            WHERE user_id='$user_id' AND course_id='$course_id'";
    mysqli_query($conn, $sql);
}
?>
