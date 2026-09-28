<?php
include("../../config/db_conn.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo json_encode(array("status" => "error", "message" => "Invalid request method."));
  exit();
}

$course_id = "";

if (isset($_POST["course_id"])) {
  $course_id = $_POST["course_id"];
}

if ($course_id == "") {
  echo json_encode(array("status" => "error", "message" => "Missing course ID."));
  exit();
}

// Delete related data first
$deleteTopics = "DELETE FROM lesson_topics WHERE lesson_id IN (SELECT lesson_id FROM lessons WHERE course_id = '$course_id')";
mysqli_query($conn, $deleteTopics);

$deleteLessons = "DELETE FROM lessons WHERE course_id = '$course_id'";
mysqli_query($conn, $deleteLessons);

// Delete the course itself
$deleteCourse = "DELETE FROM courses WHERE course_id = '$course_id'";
$result = mysqli_query($conn, $deleteCourse);

if ($result) {
  echo json_encode(array("status" => "success", "message" => "Course deleted successfully!"));
} else {
  echo json_encode(array("status" => "error", "message" => "Error deleting course: " . mysqli_error($conn)));
}

mysqli_close($conn);
?>
