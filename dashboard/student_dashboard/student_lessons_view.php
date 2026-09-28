<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");


if (!isset($_GET['lesson_id'])) {
  die("<h4 class='text-danger text-center mt-5'>Missing lesson_id in URL!</h4>");
}

$lesson_id = intval($_GET['lesson_id']);
$user_id = $_SESSION['user_id'] ?? 0;

//  Fetch Lesson Info
$lessonQuery = mysqli_query($conn, "SELECT * FROM lessons WHERE lesson_id = $lesson_id");
if (!$lessonQuery) {
  die("SQL Error (lesson): " . mysqli_error($conn));
}
$lesson = mysqli_fetch_assoc($lessonQuery);
if (!$lesson) die("<h4 class='text-danger text-center mt-5'>Lesson not found!</h4>");
$course_id = intval($lesson['course_id']);

//  Fetch All Lessons for Navigation
$lessons = [];
$all_lessons = mysqli_query($conn, "SELECT lesson_id, lesson_title FROM lessons WHERE course_id = $course_id ORDER BY lesson_id ASC");
while ($l = mysqli_fetch_assoc($all_lessons)) $lessons[] = $l;

$current_index = array_search($lesson_id, array_column($lessons, 'lesson_id'));
$total_lessons = count($lessons);

// Load Topics
$topics = [];
$topics_query = mysqli_query($conn, "SELECT * FROM lesson_topics WHERE lesson_id = $lesson_id ORDER BY topic_id ASC");
if ($topics_query) {
  while ($t = mysqli_fetch_assoc($topics_query)) $topics[] = $t;
}
$total_topics = count($topics);

//  Load completed topics for this user
$completed_topics = [];
$progress_query = mysqli_query($conn, "
  SELECT topic_id FROM topic_progress 
  WHERE lesson_id = $lesson_id AND user_id = $user_id AND completed = 1
");
if ($progress_query) {
  while ($row = mysqli_fetch_assoc($progress_query)) {
    $completed_topics[] = $row['topic_id'];
  }
}

//  Check if the whole lesson is already marked completed
$lesson_completed = false;
$check_lesson_query = mysqli_query($conn, "
  SELECT status FROM lesson_progress 
  WHERE user_id = $user_id AND lesson_id = $lesson_id AND status = 'completed'
");
if ($check_lesson_query && mysqli_num_rows($check_lesson_query) > 0) {
  $lesson_completed = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($lesson['lesson_title']) ?> | Lesson</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { 
      background: #f9f9f9; 
      font-family: 'Inter', sans-serif; 
      padding: 50px 20px; 
    }
    .lesson-card { 
      background: #fff; 
      border-radius: 18px; 
      box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
      padding: 40px; 
      max-width: 900px; 
      margin: auto; 
    }
    .lesson-content img, .lesson-content video { 
      max-width: 100%; 
      border-radius: 8px; 
      margin: 10px 0; 
    }
    .btn-gold { 
      background-color: #d4af37; 
      color: #000; 
      font-weight: 600; 
      border: none; 
      border-radius: 8px; 
      padding: 10px 20px; 
    }
    .btn-gold:hover { 
      background-color: #c19e34; 
    }
    #backToCourseBtn { 
      position: fixed; 
      top: 30px; 
      left: 30px; 
      border: 2px solid #d4af37; 
      background: #fff; 
      color: #000; 
      border-radius: 8px; 
      font-weight: 600; 
      padding: 8px 16px; 
    }
    #backToCourseBtn:hover { 
      background: #d4af37; 
    }
  </style>
</head>
<body>

<a href="course_management.php?course_id=<?= $course_id ?>" 
   id="backToCourseBtn" 
   class="btn btn-gold">
  ← Back to Course
</a>

<div class="lesson-card">
  <h3 class="text-warning mb-3"><?= htmlspecialchars($lesson['lesson_title']) ?></h3>
  <p class="text-muted"><?= htmlspecialchars($lesson['lesson_description']) ?></p>
  <hr>

  <?php if ($total_topics > 0): ?>
    <div id="topic-container" class="lesson-content">
      <h4 id="topic-title" class="text-secondary"><?= htmlspecialchars($topics[0]['topic_title']) ?></h4>
      <div id="topic-content"><?= $topics[0]['topic_content'] ?></div>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button id="prevTopic" class="btn btn-outline-secondary" disabled>← Previous</button>
      <button id="nextTopic" class="btn btn-gold">Next →</button>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-3">No topics yet for this lesson.</div>
  <?php endif; ?>

  <hr>
  <div class="mb-3">
    <div class="d-flex justify-content-between">
      <small>Topic <span id="currentTopicNum">1</span> of <?= $total_topics ?></small>
      <small><span id="topicProgressPercent">0</span>%</small>
    </div>
    <div class="progress mt-1"><div id="topicProgressBar" class="progress-bar bg-warning" style="width:0%"></div></div>
  </div>

  <div class="d-flex justify-content-between mt-4">
    <?php if ($current_index > 0): ?>
      <a href="student_lessons_view.php?lesson_id=<?= $lessons[$current_index - 1]['lesson_id'] ?>" class="btn btn-outline-secondary">← <?= htmlspecialchars($lessons[$current_index - 1]['lesson_title']) ?></a>
    <?php else: ?><span></span><?php endif; ?>

    <?php if ($current_index < $total_lessons - 1): ?>
      <a id="nextLessonBtn" href="student_lessons_view.php?lesson_id=<?= $lessons[$current_index + 1]['lesson_id'] ?>" class="btn btn-gold d-none">Next Lesson →</a>
    <?php endif; ?>
  </div>
</div>

<script>
const topics = <?= json_encode($topics) ?>;
const completedTopics = <?= json_encode($completed_topics) ?>;
const lessonAlreadyCompleted = <?= $lesson_completed ? 'true' : 'false' ?>;
let currentTopic = 0;
const totalTopics = topics.length;

function findFirstIncompleteTopic() {
  for (let i = 0; i < topics.length; i++) {
    if (!completedTopics.includes(topics[i].topic_id)) return i;
  }
  return topics.length - 1;
}

//Smooth fade transition for topic updates
function updateTopic(smooth = true) {
  if (topics.length === 0) return;

  const titleEl = document.getElementById("topic-title");
  const contentEl = document.getElementById("topic-content");

  const applyUpdate = () => {
    titleEl.innerText = topics[currentTopic].topic_title;
    contentEl.innerHTML = topics[currentTopic].topic_content;

    document.getElementById("prevTopic").disabled = currentTopic === 0;
    document.getElementById("nextTopic").innerText =
      currentTopic === totalTopics - 1 ? "Finish Lesson" : "Next →";

    const completedCount = completedTopics.length;
    const progress = (completedCount / totalTopics) * 100;
    document.getElementById("topicProgressBar").style.width = progress + "%";
    document.getElementById("currentTopicNum").innerText = currentTopic + 1;
    document.getElementById("topicProgressPercent").innerText = Math.round(progress);
  };

  if (!smooth) {
    applyUpdate();
    return;
  }

  // Fade out, then update, then fade in
  contentEl.style.opacity = 0;
  titleEl.style.opacity = 0;
  setTimeout(() => {
    applyUpdate();
    contentEl.style.transition = "opacity 0.4s ease";
    titleEl.style.transition = "opacity 0.4s ease";
    contentEl.style.opacity = 1;
    titleEl.style.opacity = 1;
  }, 250);
}

function markTopicComplete(topicId) {
  if (!completedTopics.includes(topicId)) {
    completedTopics.push(topicId);
    // Save progress to DB
    fetch('mark_topic_complete.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `lesson_id=<?= $lesson_id ?>&topic_id=${topicId}`
    });
  }
}

function markLessonComplete() {
  if (lessonAlreadyCompleted) {
    Swal.fire({
      icon: "info",
      title: "Lesson Already Completed",
      text: "You've already completed this lesson ",
      confirmButtonColor: "#d4af37"
    }).then(() => {
      window.location.href = `course_management.php?course_id=<?= $course_id ?>`;
    });
    return;
  }

  fetch('mark_lesson_complete.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `lesson_id=<?= $lesson_id ?>`
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      Swal.fire({
        icon: "success",
        title: "Lesson Completed!",
        confirmButtonColor: "#d4af37"
      }).then(() => {
        window.location.href = `course_management.php?course_id=<?= $course_id ?>`;
      });
    } else {
      Swal.fire({ icon: "error", title: "Error", text: data.message || "Failed to mark lesson" });
    }
  });
}

if (totalTopics > 0) {
  currentTopic = findFirstIncompleteTopic();
  updateTopic(false); // initial load without animation

  document.getElementById("prevTopic").addEventListener("click", () => {
    if (currentTopic > 0) {
      currentTopic--;
      updateTopic();
    }
  });

  document.getElementById("nextTopic").addEventListener("click", () => {
    const topicId = topics[currentTopic].topic_id;
    markTopicComplete(topicId);

    if (currentTopic < totalTopics - 1) {
      currentTopic++;
      updateTopic();
    } else {
      markLessonComplete();
    }
  });
}
</script>

</body>
</html>
