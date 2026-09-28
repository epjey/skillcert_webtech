<?php
include("../../config/db_conn.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_id = intval($_POST['module_id']);
    $lesson_title = mysqli_real_escape_string($conn, $_POST['lesson_title']);
    $lesson_description = mysqli_real_escape_string($conn, $_POST['lesson_description']);

    // Get course_id from module
    $module = mysqli_fetch_assoc(mysqli_query($conn, "SELECT course_id FROM modules WHERE module_id = $module_id"));
    if (!$module) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid module selected']);
        exit;
    }
    $course_id = $module['course_id'];

   
    $insert = mysqli_query($conn, "
        INSERT INTO lessons (course_id, module_id, lesson_title, lesson_description)
        VALUES ($course_id, $module_id, '$lesson_title', '$lesson_description')
    ");

    if (!$insert) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
        exit;
    }

    $new_lesson_id = mysqli_insert_id($conn);

    //  Lock this new lesson 
    $lock_sql = "
        INSERT INTO lesson_progress (user_id, course_id, lesson_id, status)
        SELECT DISTINCT lp.user_id, $course_id, $new_lesson_id, 'locked'
        FROM lesson_progress lp
        WHERE lp.course_id = $course_id
        ON DUPLICATE KEY UPDATE status = 'locked'
    ";
    mysqli_query($conn, $lock_sql);

    echo json_encode(['status' => 'success', 'message' => 'Lesson added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
