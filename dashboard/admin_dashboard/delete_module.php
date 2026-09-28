<?php
include("../../config/db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['module_id']); // <-- changed from 'id' to 'module_id'

    if ($id) {
        // Delete lessons first (optional if DB cascade is enabled)
        mysqli_query($conn, "DELETE FROM lessons WHERE module_id=$id");

        // Delete the module
        if (mysqli_query($conn, "DELETE FROM modules WHERE module_id=$id")) {
            echo json_encode(['status'=>'success', 'message'=>'Module deleted successfully!']);
        } else {
            echo json_encode(['status'=>'error', 'message'=>'DB error: '.mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status'=>'error', 'message'=>'Invalid module ID']);
    }
} else {
    echo json_encode(['status'=>'error', 'message'=>'Invalid request']);
}
