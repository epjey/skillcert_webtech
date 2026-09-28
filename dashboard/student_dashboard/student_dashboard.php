<?php
include("../../config/db_conn.php");
include("../../authentication/auth_check.php");
requireRole("student");

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
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
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../../included/stud_dashboard.css">
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
      <a href="student_courses.php" class="nav-link"><i class="fa-solid fa-layer-group"></i> Courses</a>
      <a href="student_leaderboard.php" class="nav-link"><i class="fa-solid fa-trophy"></i> Leaderboard</a>
      <a href="student_certificates.php" class="nav-link"><i class="fa-solid fa-ribbon"></i> Certificates</a>
      <a href="student_logs.php" class="nav-link"><i class="fa-solid fa-eye"></i> Logs</a>
      <hr>
      <img src="../../assets/maltese-portrait.jpg" width="70" height="70" class="rounded-circle border border-warning mb-2">
      <div>
        <strong>
              <?php 
                  echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); 
              ?>
        </strong>
      </div>
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
          <li><a href="student_courses.php" class="nav-link"><i class="fa-solid fa-layer-group fa-xl"></i> Courses</a></li>
          <li><a href="student_leaderboard.php" class="nav-link"><i class="fa-solid fa-trophy fa-xl"></i> Leaderboard</a></li>
          <li><a href="student_certificate.php" class="nav-link"><i class="fa-solid fa-ribbon fa-xl"></i> Certificates</a></li>
          <li><a href="student_logs.php" class="nav-link"><i class="fa-solid fa-eye fa-xl"></i> Logs</a></li>
        </ul>
    </div>
    <div>
      <div class="user-section">
        <img src="../../assets/maltese-portrait.jpg" alt="Profile" style="width: 100px; height: 80px;">
        <div class="user-name">
          <strong>
              <?php 
                  echo htmlspecialchars($_SESSION["first_name"] . " " . $_SESSION["last_name"]); 
              ?>
          </strong>
        </div>
      </div>
      <div class="user-links">
        <a href="student_profile.php" class="nav-link " style="font-size: 18px;"><i class="fa-solid fa-user fa-xl"></i> Profile</a>
        <a href="../../authentication/logout.php" class="nav-link logout"><i class="fa-solid fa-right-from-bracket fa-xl"></i> Log out</a>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main id="main-content" style="background-color: white;">
    <div class="studash-dashboard-card shadow-lg" style="margin-top: 100px;">

  <h2 class="studash-title fw-bold mb-4 text-black">
    <i class="fa-solid fa-gauge-high fa-2xl" style="color: #daa520;"></i>Student Dashboard
  </h2>
  </div>
  </main>


  <!-- Scripts -->
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../fontawesome-free-7.1.0-web/js/all.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>

  <script>
$(document).ready(function () {

  // Handle sidebar & mobile nav clicks
  $(".nav-link").on("click", function (e) {
    const page = $(this).attr("href");

    // If it's logout, allow normal navigation
    if (page && page.includes("logout.php")) {
      return;
    }

    // Prevent default for internal links
    if (page && page !== "#" && page.endsWith(".php")) {
      e.preventDefault();

      // Load the target page inside main-content
      $("#main-content").load(page, function (response, status) {
        if (status === "error") {
          // Just silently fail, no ugly text
          console.error("Failed to load page:", page);
        }
      });

      // Store last visited page in localStorage
      localStorage.setItem("student_last_page", page);

      // Update active state
      $(".nav-link").removeClass("active fw-bold");
      $(this).addClass("active fw-bold");
    }
  });

  // Restore last visited page on reload
  const lastPage = localStorage.getItem("student_last_page");
  if (lastPage) {
    $("#main-content").load(lastPage, function (response, status) {
      if (status === "error") {
        console.error("Failed to reload last page:", lastPage);
      }
    });

    // Highlight correct nav link
    $(".nav-link").each(function () {
      if ($(this).attr("href") === lastPage) {
        $(this).addClass("active fw-bold");
      } else {
        $(this).removeClass("active fw-bold");
      }
    });
  }
  

});
</script>


</body>
</html>