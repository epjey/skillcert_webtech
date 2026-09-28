<?php
include("../../config/db_conn.php");
header('Content-Type: application/json');

//  Use POST instead of GET
if (isset($_POST['topic_id'])) {
    $topic_id = intval($_POST['topic_id']);

    $delete = mysqli_query($conn, "DELETE FROM lesson_topics WHERE topic_id = $topic_id");

    if ($delete) {
        echo json_encode([
            'status' => 'success',
            'message' => ' Topic deleted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => ' Failed to delete topic: ' . mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '⚠ Invalid request: topic_id missing.'
    ]);
}
?>
