<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = intval($_POST['course_id']);
    $module_title = mysqli_real_escape_string($conn, trim($_POST['module_title']));
    $module_order = intval($_POST['module_order']); // <-- get manual order

    if ($course_id && !empty($module_title) && $module_order > 0) {

        //   Check if the same module_order already exists for this course
        $checkQuery = "SELECT * FROM modules WHERE course_id = $course_id AND module_order = $module_order";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            //  Module order already exists
            echo json_encode([
                'status' => 'error',
                'message' => 'A module with this order already exists for the selected course. Please choose another module order.'
            ]);
            exit;
        }

       
        $query = "INSERT INTO modules (course_id, module_title, module_order) 
                  VALUES ($course_id, '$module_title', $module_order)";

        if (mysqli_query($conn, $query)) {
            echo json_encode(['status'=>'success','message'=>"Module '$module_title' added successfully."]);
        } else {
            echo json_encode(['status'=>'error','message'=>"Database error: ".mysqli_error($conn)]);
        }

    } else {
        echo json_encode(['status'=>'error','message'=>'Please fill all fields correctly.']);
    }
}
?>
