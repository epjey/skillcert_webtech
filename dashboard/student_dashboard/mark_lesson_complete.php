<?php
include("../../config/db_conn.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(["status" => "error", "message" => "User not logged in"]);
  exit;
}

if (!isset($_POST['lesson_id'])) {
  echo json_encode(["status" => "error", "message" => "Missing lesson_id"]);
  exit;
}

$user_id = intval($_SESSION['user_id']);
$lesson_id = intval($_POST['lesson_id']);

//  Get course_id
$lesson_query = mysqli_query($conn, "SELECT course_id FROM lessons WHERE lesson_id = $lesson_id");
$lesson_row = mysqli_fetch_assoc($lesson_query);
if (!$lesson_row) {
  echo json_encode(["status" => "error", "message" => "Lesson not found"]);
  exit;
}
$course_id = intval($lesson_row['course_id']);

//  Mark current lesson as completed
$complete_sql = "
  INSERT INTO lesson_progress (user_id, lesson_id, course_id, status, completed_at)
  VALUES ($user_id, $lesson_id, $course_id, 'completed', NOW())
  ON DUPLICATE KEY UPDATE status='completed', completed_at=NOW()
";
if (!mysqli_query($conn, $complete_sql)) {
  error_log(" Lesson complete insert error: " . mysqli_error($conn));
  echo json_encode(["status" => "error", "message" => "Failed to update lesson progress"]);
  exit;
}

//  Find next lesson
$next_lesson_query = mysqli_query($conn, "
  SELECT lesson_id FROM lessons 
  WHERE course_id = $course_id AND lesson_id > $lesson_id 
  ORDER BY lesson_id ASC LIMIT 1
");
$next_lesson = mysqli_fetch_assoc($next_lesson_query);

if ($next_lesson) {
  $next_lesson_id = intval($next_lesson['lesson_id']);

  //  Only unlock if next lesson is not already completed
  $check_next = mysqli_query($conn, "
    SELECT status FROM lesson_progress 
    WHERE user_id = $user_id AND lesson_id = $next_lesson_id
  ");
  $next_status = mysqli_fetch_assoc($check_next);

  if (!$next_status || $next_status['status'] != 'completed') {
    $unlock_sql = "
      INSERT INTO lesson_progress (user_id, lesson_id, course_id, status)
      VALUES ($user_id, $next_lesson_id, $course_id, 'unlocked')
      ON DUPLICATE KEY UPDATE status='unlocked'
    ";
    if (!mysqli_query($conn, $unlock_sql)) {
      error_log(" Next lesson unlock error: " . mysqli_error($conn));
    }
  }
}

echo json_encode(["status" => "success"]);
?>
