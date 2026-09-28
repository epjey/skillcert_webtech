<?php
include("../../config/db_conn.php");

$topic_id = intval($_POST['topic_id']);
$topic_title = $_POST['topic_title'];
$topic_content = $_POST['topic_content'];

$stmt = $conn->prepare("UPDATE lesson_topics SET topic_title = ?, topic_content = ? WHERE topic_id = ?");
$stmt->bind_param("ssi", $topic_title, $topic_content, $topic_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Topic updated successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
