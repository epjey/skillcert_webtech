<?php
include("../../config/db_conn.php");

$lesson_id = intval($_POST['lesson_id']);
$title = $_POST['topic_title'];
$content = $_POST['topic_content'];

$stmt = $conn->prepare("INSERT INTO lesson_topics (lesson_id, topic_title, topic_content) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $lesson_id, $title, $content);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Topic added successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add topic: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
