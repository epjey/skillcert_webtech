<?php
include("../../config/db_conn.php");

header("Content-Type: application/json");

$course_id = "";
$name = "";
$desc = "";

if (isset($_POST["course_id"])) {
  $course_id = $_POST["course_id"];
}

if (isset($_POST["course_name"])) {
  $name = $_POST["course_name"];
}

if (isset($_POST["description"])) {
  $desc = $_POST["description"];
}

if ($course_id == "" || $name == "") {
  echo json_encode(array("status" => "error", "message" => "Missing required fields."));
  exit();
}

$sql = "UPDATE courses SET course_name = '$name', description = '$desc' WHERE course_id = '$course_id'";
$result = mysqli_query($conn, $sql);

if ($result) {
  echo json_encode(array("status" => "success", "message" => "Course updated successfully!"));
} else {
  echo json_encode(array("status" => "error", "message" => "Error updating course: " . mysqli_error($conn)));
}

mysqli_close($conn);
?>
