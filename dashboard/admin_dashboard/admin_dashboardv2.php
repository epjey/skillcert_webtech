<?php
include("../../config/db_conn.php");
include("../../authentication/auth_check.php");
requireRole("admin");

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    // Kick if not student
    header("Location: ../../authentication/login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../../included/student_dashboard.css">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <link href="../../libs/sweetalert2.min.css" rel="stylesheet">

</head>
<body>

  <!-- Mobile Navbar -->
  <div class="mobile-nav">
    <a href="student_dashboard.php"><img src="../../assets/pp.svg" alt="SkillCert Logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>

  <!-- Offcanvas Menu -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
      <h5>SkillCert</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <li><a href="student_overview.php" class="nav-link"><i class="fa-solid fa-gauge fa-xl"></i>Overview</a></li>
      <a href="student_courses.php" class="nav-link"><i class="fa-solid fa-layer-group"></i> Courses</a>
      <a href="student_leaderboard.php" class="nav-link"><i class="fa-solid fa-trophy"></i> Leaderboard</a>
      <a href="student_certificates.php" class="nav-link"><i class="fa-solid fa-ribbon"></i> Certificates</a>
      <a href="student_logs.php" class="nav-link"><i class="fa-solid fa-eye"></i> Logs</a>
      <hr>
      <img src="../../assets/maltese-portrait.jpg" width="70" height="70" class="rounded-circle border border-warning mb-2">
      <div><strong>Perez Renz E.</strong></div>
      <hr>
      <a href="student_profile.php" class="nav-link"><i class="fa-solid fa-user"></i> Profile</a>
      <a href="#" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
    </div>
  </div>

  <!-- Sidebar -->
  <nav class="sidebar">
    <div>
      <div class="brand">
        <a href="student_dashboard.php"><img src="../../assets/pp.svg" alt="Logo" style="margin-bottom: 50px; width: 200px;"></a>
      </div>
        <ul>
          <li><a href="admin_overview.php" class="nav-link"><i class="fa-solid fa-gauge fa-xl"></i>Overview</a></li>
          <li><a href="admin_registered_users.php" class="nav-link"><i class="fa-solid fa-layer-group fa-xl"></i>Registered Users</a></li>
          <li><a href="manage_course.php" class="nav-link"><i class="fa-solid fa-trophy fa-xl"></i>Course Reports</a></li>
          <li><a href="manage_certificate.php" class="nav-link"><i class="fa-solid fa-ribbon fa-xl"></i> Certificate Management</a></li>
          <li><a href="course_list.php" class="nav-link"><i class="fa-solid fa-eye fa-xl"></i>Courses</a></li>
          <li><a href="add_course.php" class="nav-link"><i class="fa-solid fa-gear fa-xl"></i> Add Course</a></li>
          <li><a href="modules.php" class="nav-link"><i class="fa-solid fa-eye fa-xl"></i>Modules</a></li>
          <li><a href="admin_exams.php" class="nav-link"><i class="fa-solid fa-gear fa-xl"></i>Add Exams</a></li>
          <li><a href="upload_exam_csv.php" class="nav-link"><i class="fa-solid fa-gear fa-xl"></i>Upload csv exam</a></li>
          <li><a href="view_exam_questions.php" class="nav-link"><i class="fa-solid fa-gear fa-xl"></i> view exams</a></li>
        </ul>
    </div>
    <div>
      <div class="user-section">
        <img src="../../assets/maltese-portrait.jpg" alt="Profile" style="width: 100px; height: 80px;">
        <div class="user-name"><strong>Renz Perez</strong></div>
      </div>
      <div class="user-links">
        <a href="student_profile.php" class="nav-link " style="font-size: 18px;"><i class="fa-solid fa-user fa-xl"></i> Profile</a>
        <a href="../../authentication/logout.php" class="nav-link logout"><i class="fa-solid fa-right-from-bracket fa-xl"></i> Log out</a>
      </div>
    </div>
  </nav>


  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 mt-5" id="main-content">

  </main>


  
  <div class="bg-light d-flex justify-content-center align-items-center mt-5">
    <div class="text-center">
      <h4 class="big-date" id="dateDisplay"></h4>
    </div>
  </div>


  
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../fontawesome-free-7.1.0-web/js/all.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>


<script>
$(document).ready(function() {

  var dateElement = document.getElementById('dateDisplay');
  var today = new Date();
  var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateElement.textContent = today.toLocaleDateString('en-US', options);

  // Sidebar click event for dynamic content loading
  $('.sidebar-link').click(function(event) {
    var page = $(this).attr('data-page');
    var href = $(this).attr('href');

    // Allow normal navigation for logout
    if (href && href.indexOf("logout.php") !== -1) {
      return;
    }

    event.preventDefault();

    if (page) {
      // Save last visited page
      localStorage.setItem('lastPage', page);

      // Load page into main content
      $('#main-content').load(page, function(response, status) {
        if (status === "error") {
          $('#main-content').html("Sorry, content could not be loaded.");
        }
      });

      // Highlight active link
      $('.sidebar-link').removeClass('active fw-bold');
      $(this).addClass('active fw-bold');
    }
  });

  // Load last visited page on refresh/ checks din if there is a last visited page
  var lastPage = localStorage.getItem('lastPage');
  if (lastPage) {
    $('#main-content').load(lastPage, function(response, status) {
      if (status === "error") {
        $('#main-content').html("Sorry, content could not be loaded.");
      }
    });

    // Highlight the correct link // kinocompare ung data page sa last page so if match sila, 
    // mag active ung link sa navigation if hindi edi hindi
    $('.sidebar-link').each(function() {
      if ($(this).attr('data-page') === lastPage) {
        $(this).addClass('active fw-bold');
      } else {
        $(this).removeClass('active fw-bold');
      }
    });
  }

});
</script>


</body>
</html>