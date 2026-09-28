<?php
include("../../config/db_conn.php");

if (!isset($_GET['course_id'])) {
  die("No course selected.");
}

$course_id = intval($_GET['course_id']);
$user_id = $_SESSION['user_id'] ?? 0;

// Get course info
$courseQuery = mysqli_query($conn, "SELECT * FROM courses WHERE course_id = $course_id");
$course = mysqli_fetch_assoc($courseQuery);

// Get modules ordered
$moduleQuery = mysqli_query($conn, "SELECT * FROM modules WHERE course_id = $course_id ORDER BY module_order ASC");
if (!$moduleQuery) {
  die("SQL Error (modules): " . mysqli_error($conn));
}

$modules = [];
$globalPreviousCompleted = true;

while ($module = mysqli_fetch_assoc($moduleQuery)) {
  $module_id = $module['module_id'];

  // Get lessons
  $lessonQuery = mysqli_query($conn, "
    SELECT l.lesson_id, l.lesson_title, l.lesson_description,
           COALESCE(lp.status, 'locked') AS progress_status
    FROM lessons l
    LEFT JOIN lesson_progress lp 
      ON lp.lesson_id = l.lesson_id AND lp.user_id = $user_id
    WHERE l.module_id = $module_id
    ORDER BY l.lesson_id ASC
  ");
  if (!$lessonQuery) die('SQL Error (lessons): ' . mysqli_error($conn));

  $lessons = [];
  foreach ($lessonQuery as $lesson) {
    $lessons[] = [
      'id' => $lesson['lesson_id'],
      'title' => $lesson['lesson_title'],
      'meta' => $lesson['lesson_description'],
      'status' => $lesson['progress_status']
    ];
  }

  // Progress logic
  $completedLessons = array_filter($lessons, fn($l) => $l['status'] === 'completed');
  $completedCount = count($completedLessons);
  $totalLessons = count($lessons);

  for ($i = 0; $i < $totalLessons; $i++) {
    if ($lessons[$i]['status'] === 'completed') continue;
    if ($i === 0) {
      $lessons[$i]['status'] = ($globalPreviousCompleted) ? 'in_progress' : 'locked';
    } else {
      $lessons[$i]['status'] = ($lessons[$i - 1]['status'] === 'completed')
        ? 'in_progress'
        : 'locked';
    }
  }

  // Get exam
  $examQuery = mysqli_query($conn, "SELECT * FROM exams WHERE module_id = $module_id LIMIT 1");
  $exam = mysqli_fetch_assoc($examQuery);
  $examData = null;
  $examPassed = false;

  if ($exam) {
    $examResult = mysqli_fetch_assoc(mysqli_query($conn, "
      SELECT status FROM exam_results 
      WHERE user_id=$user_id AND exam_id={$exam['exam_id']}
      ORDER BY taken_at DESC LIMIT 1
    "));
    $examPassed = ($examResult && $examResult['status'] === 'passed');
    $examUnlocked = ($completedCount === $totalLessons && $totalLessons > 0);

    $examData = [
      'id' => $exam['exam_id'],
      'title' => $exam['exam_title'] ?? 'Module Exam',
      'status' => $examUnlocked ? 'in_progress' : 'locked',
      'passed' => $examPassed
    ];
  }

  $moduleCompleted = ($completedCount === $totalLessons && $totalLessons > 0 && (!$exam || $examPassed));
  $globalPreviousCompleted = $moduleCompleted;

  $moduleStatus = $moduleCompleted
    ? 'completed'
    : (($completedCount > 0) ? 'in_progress' : 'not_started');

  $modules[] = [
    'id' => $module['module_id'],
    'title' => $module['module_title'],
    'status' => $moduleStatus,
    'lessons' => $lessons,
    'exam' => $examData
  ];
}

// Course progress
$totalLessonsInCourse = 0;
$completedLessonsInCourse = 0;
foreach ($modules as $mod) {
  foreach ($mod['lessons'] as $lesson) {
    $totalLessonsInCourse++;
    if ($lesson['status'] === 'completed') $completedLessonsInCourse++;
  }
}
$courseProgressPercent = ($totalLessonsInCourse > 0)
  ? round(($completedLessonsInCourse / $totalLessonsInCourse) * 100)
  : 0;

  // Automatically issue certificate if course is fully completed
if ($courseProgressPercent == 100) {
    // Check if all exams in this course are passed
    $examCheck = mysqli_query($conn, "
        SELECT e.exam_id 
        FROM exams e
        INNER JOIN modules m ON e.module_id = m.module_id
        WHERE m.course_id = $course_id
    ");
    $allPassed = true;
    while ($exam = mysqli_fetch_assoc($examCheck)) {
        $exam_id = $exam['exam_id'];
        $res = mysqli_query($conn, "
            SELECT status FROM exam_results 
            WHERE user_id = $user_id AND exam_id = $exam_id 
            ORDER BY taken_at DESC LIMIT 1
        ");
        $row = mysqli_fetch_assoc($res);
        if (!$row || $row['status'] !== 'passed') {
            $allPassed = false;
            break;
        }
    }

    if ($allPassed) {
        // Check if certificate already exists
        $checkCert = mysqli_query($conn, "
            SELECT * FROM certificates 
            WHERE user_id = $user_id AND course_id = $course_id
        ");
        if (mysqli_num_rows($checkCert) == 0) {
            $certificate_code = strtoupper(substr(md5(uniqid()), 0, 10));
            $issued_date = date('Y-m-d');
            mysqli_query($conn, "
                INSERT INTO certificates (user_id, course_id, certificate_code, issued_date)
                VALUES ($user_id, $course_id, '$certificate_code', '$issued_date')
            ");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($course['course_name']); ?> | Course View</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../libs/sweetalert2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
  background-color: #f8f9fa;
  font-family: 'Poppins', sans-serif;
  color: #333;
}
.course-container {
  max-width: 1100px;
  margin: 60px auto;
  background: #fff;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 6px 25px rgba(0,0,0,0.08);
}
.header-area {
  text-align: center;
  margin-bottom: 30px;
}
.header-area h1 {
  color: #d4af37;
  font-weight: 700;
}
.header-area p {
  color: #555;
  font-size: 1rem;
}
.progress {
  height: 20px;
  border-radius: 10px;
  background-color: #e9ecef;
}
.progress-bar {
  font-weight: 600;
}
.module-block {
  margin-top: 40px;
}
.module-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 15px;
  font-weight: 600;
  color: #222;
}
.module-title i {
  color: #d4af37;
}
.lesson-card, .exam-card {
  background: #fff;
  border: 2px solid #eee;
  border-radius: 14px;
  padding: 20px;
  transition: 0.3s;
  position: relative;
  cursor: pointer;
}
.lesson-card:hover, .exam-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}
.lesson-card h5, .exam-card h5 {
  font-weight: 600;
  color: #333;
}
.lesson-card p, .exam-card p {
  font-size: 0.9rem;
  color: #666;
}
.lesson-card.locked, .exam-card.locked {
  opacity: 0.6;
  cursor: not-allowed;
  border-color: #ddd;
}
.lesson-card.locked::after, .exam-card.locked::after {
  content: "\f023"; /* lock icon */
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  position: absolute;
  top: 15px;
  right: 15px;
  color: #d4af37;
}
.exam-card {
  border-color: #27ae60;
}
.exam-card:hover {
  border-color: #1e8449;
}
.status-badge {
  background-color: #d4af37;
  color: #000;
  font-weight: 600;
  border-radius: 12px;
  padding: 6px 12px;
  font-size: 0.85rem;
}
.btn-gold {
  background-color: #d4af37;
  color: #000;
  border-radius: 8px;
  border: none;
  font-weight: 600;
  padding: 10px 20px;
  transition: 0.3s;
}
.btn-gold:hover {
  background-color: #c19e34;
}
</style>
</head>

<body>
<div class="course-container">
  <div class="header-area">
    <h1><i class="fa-solid fa-book-open"></i> <?= htmlspecialchars($course['course_name']); ?></h1>
    <p><?= htmlspecialchars($course['description']); ?></p>
  </div>

  <div class="progress mb-4">
    <?php 
      $barClass = $courseProgressPercent == 100 ? 'bg-success' : 'bg-warning';
    ?>
    <div class="progress-bar <?= $barClass ?>" style="width: <?= $courseProgressPercent ?>%;">
      <?= $courseProgressPercent ?>%
    </div>
  </div>

  <?php foreach ($modules as $mod): ?>
    <div class="module-block">
      <div class="module-title">
        <span><i class="fa-solid fa-layer-group me-2"></i><?= htmlspecialchars($mod['title']); ?></span>
        <span class="status-badge"><?= ucfirst(str_replace('_', ' ', $mod['status'])); ?></span>
      </div>

      <div class="row g-3">
        <?php foreach ($mod['lessons'] as $lesson): ?>
          <div class="col-md-4">
            <div class="lesson-card <?= $lesson['status'] == 'locked' ? 'locked' : '' ?>" data-lesson="<?= $lesson['id']; ?>">
              <h5><i class="fa-solid fa-book me-2 text-warning"></i><?= htmlspecialchars($lesson['title']); ?></h5>
              <p><?= htmlspecialchars($lesson['meta']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>

        <?php if ($mod['exam']): ?>
          <div class="col-md-4">
            <div class="exam-card <?= $mod['exam']['status'] == 'locked' ? 'locked' : '' ?>" data-exam="<?= $mod['exam']['id']; ?>">
              <h5><i class="fa-solid fa-clipboard-question me-2 text-success"></i><?= htmlspecialchars($mod['exam']['title']); ?></h5>
              <p><?= $mod['exam']['passed'] ? '<i class="fa-solid fa-circle-check text-success"></i> Passed' : 'Module Exam'; ?></p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="text-center mt-5">
    <button class="btn btn-gold me-2" onclick="window.location.href='view_certificate.php?course_id=<?= $course_id ?>'">
      <i class="fa-solid fa-award me-1"></i> View Certificate
    </button>
    <button class="btn" style="border: 2px solid #d4af37;" onclick="window.location.href='student_dashboard.php'">
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </button>
  </div>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../libs/sweetalert2.all.min.js"></script>
<script>
// Scroll memory (course-specific)
document.addEventListener("DOMContentLoaded", () => {
  const key = "courseScroll_" + <?= $course_id ?>;
  const savedScroll = localStorage.getItem(key);
  if (savedScroll) window.scrollTo(0, parseInt(savedScroll));
});

window.addEventListener("beforeunload", () => {
  const key = "courseScroll_" + <?= $course_id ?>;
  localStorage.setItem(key, window.scrollY);
});


// Lesson click
document.querySelectorAll(".lesson-card").forEach(card => {
  card.addEventListener("click", () => {
    if (card.classList.contains("locked")) {
      Swal.fire({
        icon: "warning",
        title: "Lesson Locked",
        text: "Please complete previous lessons first.",
        confirmButtonColor: "#d4af37"
      });
    } else {
      window.location.href = "student_lessons_view.php?lesson_id=" + card.dataset.lesson;
    }
  });
});

// Exam click
document.querySelectorAll(".exam-card").forEach(card => {
  card.addEventListener("click", () => {
    if (card.classList.contains("locked")) {
      Swal.fire({
        icon: "warning",
        title: "Exam Locked",
        text: "Complete all lessons in this module first.",
        confirmButtonColor: "#d4af37"
      });
    } else {
      window.location.href = "student_take_exam.php?exam_id=" + card.dataset.exam;
    }
  });
});
</script>
</body>
</html>
