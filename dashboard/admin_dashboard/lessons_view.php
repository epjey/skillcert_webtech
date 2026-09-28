<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");

if (!isset($_GET['lesson_id'])) {
  die("<h4 class='text-danger text-center mt-5'>Missing lesson_id in URL!</h4>");
}

$lesson_id = intval($_GET['lesson_id']);

// Get current lesson
$lesson = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lessons WHERE lesson_id = $lesson_id"));
if (!$lesson) {
  die("<h4 class='text-danger text-center mt-5'>Lesson not found!</h4>");
}

$course_id = $lesson['course_id'];
$module_id = $lesson['module_id']; 

// Get all lessons in the same module
$all_lessons = mysqli_query($conn, "
  SELECT lesson_id, lesson_title 
  FROM lessons 
  WHERE module_id = $module_id 
  ORDER BY lesson_id ASC
");

$lessons = [];
while ($l = mysqli_fetch_assoc($all_lessons)) {
  $lessons[] = $l;
}

// Current lesson index & progress
$current_index = array_search($lesson_id, array_column($lessons, 'lesson_id'));
$total_lessons = count($lessons);
$current_number = $current_index !== false ? $current_index + 1 : 1;
$progress = ($current_number / $total_lessons) * 100;

// Get topics for this lesson
$topics_result = mysqli_query($conn, "SELECT * FROM lesson_topics WHERE lesson_id = $lesson_id ORDER BY topic_id ASC");
$topics = [];
while ($t = mysqli_fetch_assoc($topics_result)) {
  $topics[] = $t;
}
$total_topics = count($topics);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($lesson['lesson_title']) ?> | Lesson</title>
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .lesson-content img, .lesson-content video { max-width: 100%; border-radius: 8px; margin: 10px 0; }
    .progress { height: 10px; border-radius: 10px; }
  </style>
</head>

<style>
.back-btn {
  background: linear-gradient(135deg, #daa520, #b8860b);
  border: none;
  border-radius: 12px;
  padding: 10px 22px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  display: inline-block;
}

.back-btn a {
  color: white;
  text-decoration: none;
  font-weight: 600;
  font-size: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.back-btn:hover {
  background: linear-gradient(135deg, #b8860b, #daa520);
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}

.back-btn a:hover {
  color: #fff;
} 
</style>
<body class="bg-light">

<div class="container mt-5">
    <button class="back-btn" onclick="window.location.href='lessons.php?course_id=<?= $lesson['course_id'] ?>'">
        <i class="fa-solid fa-arrow-left"></i> Back to Lessons
    </button>

  <div class="card shadow-lg p-4 w-50 mx-auto">
    <h3 class="text-warning mb-3"><?= htmlspecialchars($lesson['lesson_title']) ?></h3>
    <p class="text-muted"><?= htmlspecialchars($lesson['lesson_description']) ?></p>
    <hr>

    <!-- Lesson Topics -->
    <?php if ($total_topics > 0): ?>
      <div id="topic-container" class="lesson-content">
        <h4 class="text-secondary" id="topic-title"><?= htmlspecialchars($topics[0]['topic_title']) ?></h4>
        <div id="topic-content"><?= $topics[0]['topic_content'] ?></div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button id="prevTopic" class="btn btn-outline-secondary" disabled>← Previous</button>
        <button id="nextTopic" class="btn btn-warning">Next →</button>
      </div>
    <?php else: ?>
      <div class="alert alert-info mt-3">No topics added yet for this lesson.</div>
    <?php endif; ?>

    <hr>

    <!-- Lesson Progress -->
    <div class="mb-3">
      <div class="d-flex justify-content-between align-items-center">
        <small>Lesson <?= $current_number ?> of <?= $total_lessons ?> (Module Progress)</small>
        <small><?= round($progress) ?>%</small>
      </div>
      <div class="progress mt-1">
        <div class="progress-bar bg-warning" role="progressbar"
             style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>"
             aria-valuemin="0" aria-valuemax="100"></div>
      </div>
    </div>

    <!-- Navigation Between Lessons -->
    <div class="d-flex justify-content-between mt-4">
      <?php if ($current_index > 0): ?>
        <a href="lessons_view.php?lesson_id=<?= $lessons[$current_index - 1]['lesson_id'] ?>" class="btn btn-outline-secondary">
          ← <?= htmlspecialchars($lessons[$current_index - 1]['lesson_title']) ?>
        </a>
      <?php else: ?>
        <span></span>
      <?php endif; ?>

      <?php if ($current_index < $total_lessons - 1): ?>
        <a id="nextLessonBtn" href="lessons_view.php?lesson_id=<?= $lessons[$current_index + 1]['lesson_id'] ?>" class="btn btn-warning d-none">
          Next Lesson →
        </a>
      <?php else: ?>
        <a href="lessons.php?course_id=<?= $course_id ?>" class="btn btn-outline-success d-none" id="backBtn">
           Back to Lessons
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
const topics = <?= json_encode($topics) ?>;
let currentTopic = 0;
const totalTopics = topics.length;

const topicTitle = document.getElementById("topic-title");
const topicContent = document.getElementById("topic-content");
const prevBtn = document.getElementById("prevTopic");
const nextBtn = document.getElementById("nextTopic");
const nextLessonBtn = document.getElementById("nextLessonBtn");
const backBtn = document.getElementById("backBtn");

function updateTopic() {
  topicTitle.innerText = topics[currentTopic].topic_title;
  topicContent.innerHTML = topics[currentTopic].topic_content;

  prevBtn.disabled = currentTopic === 0;
  nextBtn.innerText = currentTopic === totalTopics - 1 ? "Finish Lesson" : "Next →";
}

if (topics.length > 0) {
  prevBtn.addEventListener("click", () => {
    if (currentTopic > 0) { currentTopic--; updateTopic(); }
  });

  nextBtn.addEventListener("click", () => {
    if (currentTopic < totalTopics - 1) { currentTopic++; updateTopic(); }
    else {
      nextBtn.classList.add("d-none");
      if (nextLessonBtn) nextLessonBtn.classList.remove("d-none");
      if (backBtn) backBtn.classList.remove("d-none");
    }
  });
}
</script>

</body>
</html>