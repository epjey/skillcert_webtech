<?php
include("../../config/db_conn.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  echo json_encode(array("status" => "error", "message" => "Invalid request method."));
  exit();
}

$course_name = "";
$course_description = "";

if (isset($_POST["course_name"])) {
  $course_name = $_POST["course_name"];
}

if (isset($_POST["description"])) {
  $course_description = $_POST["description"];
}

if ($course_name == "") {
  echo json_encode(array("status" => "error", "message" => "Course name is required."));
  exit();
}

$sql = "INSERT INTO courses (course_name, description) VALUES ('$course_name', '$course_description')";
$result = mysqli_query($conn, $sql);

if ($result) {
  echo json_encode(array("status" => "success", "message" => "Course added successfully!"));
} else {
  echo json_encode(array("status" => "error", "message" => "Error saving course: " . mysqli_error($conn)));
}

mysqli_close($conn);
?>
