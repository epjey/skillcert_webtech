<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");



// Get courses from DB
$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Available Courses</title>
  <link rel="stylesheet" href="../../fontawesome-free-7.1.0-web/css/all.min.css">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <script src="../../libs/sweetalert2.all.min.js"></script>
  <style>
    body {
      background: #f5f7fa;
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
    }

    .header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .header h1 {
      font-weight: 700;
      color: #222;
    }

    .header p {
      color: #666;
      font-size: 1rem;
    }

    .main-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
      max-width: 1800px;
      margin: auto;
    }

    .course-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      padding: 25px 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.25s ease-in-out;
    }

    .course-card:hover {
      transform: translateY(-6px);
      background: #fffdf3;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .course-icon {
      font-size: 3rem;
      color: #d4af37;
    }

    .course-title {
      font-weight: 600;
      margin-top: 12px;
      color: #222;
    }

    .course-title {
      font-weight: 600;
      margin-top: 12px;
      color: #222;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .course-desc {
      font-size: 0.95rem;
      color: #555;
      margin-top: 6px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 2; 
      -webkit-box-orient: vertical;
      min-height: 38px; 
    }

    .course-desc {
      font-size: 0.95rem;
      color: #555;
      margin-top: 6px;
    }

    .fade-in {
      opacity: 0;
      animation: fadeIn 0.5s ease-in-out forwards;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 991px) {
      .main-card {
        padding: 25px;
      }
    }
  </style>
</head>
<body>
  <main id="main-content" class="container-fluid my-5">
    <div class="main-card">
      <div class="header">
        <h1 style="text-align: left; font-size: 30px;">
         <i class="fa-solid fa-layer-group fa-xl" style="color: #daa520;"></i>   
        Available Courses</h1>
        <p style="text-align: left;">Select a course to view its lessons, quizzes, and exams.</p>
      </div>

      <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): 
          $courseId = $row['course_id'];
          $name = htmlspecialchars($row['course_name']);
          $desc = htmlspecialchars($row['description']);
          $icon = $iconHTML[$name] ?? '<i class="fa-solid fa-book fa-2xl" style="color: #daa520;"></i>';
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="course-card" onclick="openCourse(<?= $courseId ?>, '<?= $name ?>')">
              <?= $icon ?>
              <h5 class="course-title"><?= $name ?></h5>
              <p class="course-desc"><?= $desc ?></p>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </main>

  <script>
    function openCourse(courseId, name) {
      Swal.fire({
        title: name,
        text: "You’re about to view lessons and exams for this course.",
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "Proceed",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d4af37",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "course_management.php?course_id=" + courseId;
        }
      });
    }
  </script>
</body>
</html>
