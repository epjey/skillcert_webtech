<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module_id = intval($_POST['module_id']); // existing module being edited
    $course_id = intval($_POST['course_id']);
    $module_title = mysqli_real_escape_string($conn, trim($_POST['module_title']));
    $module_order = intval($_POST['module_order']);

    if ($course_id && !empty($module_title) && $module_order > 0 && $module_id > 0) {

        //  Step 1: Check if another module in the same course already has this order
        $checkQuery = "SELECT * FROM modules 
                       WHERE course_id = $course_id 
                       AND module_order = $module_order 
                       AND module_id != $module_id"; // exclude itself
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            //  Duplicate found
            echo json_encode([
                'status' => 'error',
                'message' => 'A module with this order already exists for this course. Please pick another module order.'
            ]);
            exit;
        }

        //  Step 2: Update the module
        $updateQuery = "UPDATE modules 
                        SET course_id = $course_id, 
                            module_title = '$module_title', 
                            module_order = $module_order 
                        WHERE module_id = $module_id";

        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(['status'=>'success','message'=>"Module updated successfully."]);
        } else {
            echo json_encode(['status'=>'error','message'=>"Database error: ".mysqli_error($conn)]);
        }

    } else {
        echo json_encode(['status'=>'error','message'=>'Please fill all fields correctly.']);
    }
}
?>
