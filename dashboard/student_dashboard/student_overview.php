<?php
include("../../config/db_conn.php");


$student_id = $_SESSION['user_id'] ?? 0;

// Check DB connection
if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}

// Default values
$completed = 0;
$in_progress = 0;
$average_score = 0;

// Completed courses
$q_completed = mysqli_query($conn, "SELECT * FROM student_progress WHERE user_id = $student_id AND status = 'completed'");
if ($q_completed) {
  $completed = mysqli_num_rows($q_completed);
}

// In-progress courses
$q_inprogress = mysqli_query($conn, "SELECT * FROM student_progress WHERE user_id = $student_id AND status = 'in_progress'");
if ($q_inprogress) {
  $in_progress = mysqli_num_rows($q_inprogress);
}

// Average score (optional if you have a score column)
$q_avg = mysqli_query($conn, "SELECT AVG(score) AS avg_score FROM student_progress WHERE user_id = $student_id AND score IS NOT NULL");
if ($q_avg && mysqli_num_rows($q_avg) > 0) {
  $avg_data = mysqli_fetch_assoc($q_avg);
  $average_score = round($avg_data['avg_score'] ?? 0);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../../included/student_dashboard.css">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <link href="../../libs/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
  <!-- Main -->
  <main id="main-content" style="background-color: white;">
    <div class="studash-dashboard-card shadow-lg" style="margin-top: 100px;">

      <h2 class="studash-title fw-bold mb-4 text-black">
        <i class="fa-solid fa-gauge-high fa-2xl" style="color: #daa520;"></i> Student Dashboard
      </h2>

      <!--  Overview Section -->
      <div class="studash-overview-section row g-4 mb-4">
        <div class="col-md-3 col-6">
          <div class="studash-overview-card card text-center p-3">
            <h6 class="fw-bold">Completed</h6>
            <h3 class="fw-bold text-success"><?= $completed ?></h3>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="studash-overview-card card text-center p-3">
            <h6 class="fw-bold">In Progress</h6>
            <h3 class="fw-bold text-primary"><?= $in_progress ?></h3>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="studash-overview-card card text-center p-3">
            <h6 class="fw-bold">Average Score</h6>
            <h3 class="fw-bold text-black"><?= $average_score ?>%</h3>
          </div>
        </div>
      </div>

      <!--  My Courses -->
      <div class="studash-certifications-section">
        <h4 class="studash-section-title fw-bold mb-3 text-black" style="font-size: 30px;">
          <i class="fa-solid fa-ribbon fa-2xl" style="color: #daa520;"></i> My Courses
        </h4>

        <?php
            $q_courses = mysqli_query($conn, "
              SELECT c.course_name, sp.status, sp.progress_percent, sp.updated_at
              FROM student_progress sp
              JOIN courses c ON sp.course_id = c.course_id
              WHERE sp.user_id = $student_id
              ORDER BY sp.status DESC, c.course_name ASC
            ");



        if ($q_courses && mysqli_num_rows($q_courses) > 0) {
          while ($course = mysqli_fetch_assoc($q_courses)) {
            $status = $course['status'];
            $badgeClass = $status === 'completed' ? 'bg-success' : 'bg-warning text-dark';
            $date = $course['updated_at'] ? "Updated on " . date("M d, Y", strtotime($course['updated_at'])) : '';
            $progress = $course['progress_percent'] ?? 0;

            echo "
              <div class='studash-certification-card card p-3 mb-3'>
                <p class='fw-bold mb-1'>{$course['course_name']}</p>
                <span class='badge {$badgeClass}'>" . ucfirst($status) . "</span>
                <small class='text-muted d-block'>Progress: {$progress}%</small>
                <small class='text-muted d-block'>{$date}</small>
              </div>
            ";


          }
        } else {
          echo "<p class='text-muted'>No courses found.</p>";
        }
        ?>
      </div>

    </div>
  </main>

  <!-- Scripts -->
  <script src='../../jquery.js/jquery-3.7.1.min.js'></script>
  <script src='../../js/bootstrap.bundle.min.js'></script>
  <script src='../../fontawesome-free-7.1.0-web/fontawesome-free-7.1.0-web/js/all.min.js'></script>
  <script src='../../libs/sweetalert2.all.min.js'></script>

  <script>
    $(function() {
      $(".nav-link").click(function(e) {
        e.preventDefault();
        var page = $(this).attr("href");
        if (page && page !== "#") {
          $("#main-content").load(page);
          $(".nav-link").removeClass("active");
          $(this).addClass("active");
        }
      });
    });
  </script>
</body>
</html>
