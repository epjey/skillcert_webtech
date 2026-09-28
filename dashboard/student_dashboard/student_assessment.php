<?php
include("../../config/db_conn.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Course View | SkillCert</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .course-header {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      margin-bottom: 20px;
    }
    .lesson-card {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.08);
      transition: all 0.3s;
    }
    .lesson-card:hover {
      transform: translateY(-3px);
    }
    .lesson-locked {
      opacity: 0.5;
      pointer-events: none;
    }
    .progress {
      height: 10px;
      border-radius: 5px;
    }
    .progress-bar {
      background-color: #00aaff;
    }
  </style>
</head>
<body>

<div class="container py-5">

  <!-- Course Header -->
  <div class="course-header">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h3 class="fw-bold">Introduction to SQL</h3>
        <p class="text-muted mb-1">Learn how to manage and analyze data using SQL. No experience needed!</p>
        <div class="progress my-2" style="width: 250px;">
          <div class="progress-bar" style="width: 40%"></div>
        </div>
        <small>Progress: <strong>4 / 10 lessons</strong></small>
      </div>
    </div>
  </div>

  <!-- Lessons List -->
  <h5 class="mb-3">Lessons</h5>
  <div class="row gy-3">
    <!-- Example Lesson -->
    <div class="col-md-6">
      <div class="lesson-card d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-1">Lesson 1: Working with Data</h6>
          <small class="text-success">Completed ✅</small>
        </div>
        <a href="#" class="btn btn-sm btn-primary">Learn</a>
      </div>
    </div>

    <div class="col-md-6">
      <div class="lesson-card">
        <h6 class="mb-1">Lesson 2: Running SQL Queries</h6>
        <small class="text-muted">Locked 🔒</small>
      </div>
    </div>

    <!-- You’ll loop lessons here dynamically -->
    <!-- Example for PHP:
      <?php while($lesson = mysqli_fetch_assoc($lessons)): ?>
         <div class="col-md-6">
           <div class="lesson-card <?= $lesson['locked'] ? 'lesson-locked' : '' ?>">
             <h6><?= $lesson['lesson_title'] ?></h6>
             <small><?= $lesson['completed'] ? 'Completed ✅' : 'Not started' ?></small>
             <?php if(!$lesson['locked']): ?>
               <a href="lesson_view.php?lesson_id=<?= $lesson['lesson_id'] ?>" class="btn btn-sm btn-primary float-end">Learn</a>
             <?php endif; ?>
           </div>
         </div>
      <?php endwhile; ?>
    -->
  </div>

  <!-- Final Quiz Section -->
  <div class="text-center mt-5">
    <h5> Final Course Quiz</h5>
    <p class="text-muted">Complete all lessons to unlock the final quiz.</p>
    <button class="btn btn-success btn-lg" disabled id="quizBtn">Take the Quiz</button>
  </div>

</div>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script>
  // Example JS logic for enabling the quiz button
  const progress = 100; // Replace with actual PHP progress value
  if (progress >= 100) {
    document.getElementById('quizBtn').disabled = false;
  }
</script>

</body>
</html>


