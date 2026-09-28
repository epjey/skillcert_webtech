<?php
// Include database connection
include("../../config/db_conn.php");


$module_id = isset($_GET['module_id']) ? intval($_GET['module_id']) : 0;


if ($module_id > 0) {
    $query = "SELECT lesson_id, lesson_title 
              FROM lessons 
              WHERE module_id = $module_id 
              ORDER BY lesson_id ASC";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<option value="">-- Choose Lesson --</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row['lesson_id'].'">'.htmlspecialchars($row['lesson_title']).'</option>';
        }
    } else {
        // No lessons found for the module
        echo '<option value="">No lessons found</option>';
    }
} else {
    // Invalid module_id or not provided
    echo '<option value="">-- Choose Lesson --</option>';
}
?>
