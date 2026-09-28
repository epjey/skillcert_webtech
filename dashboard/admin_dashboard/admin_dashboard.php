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
  <link rel="stylesheet" href="../../included/admin_dashboard.css">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <link href="../../libs/sweetalert2.min.css" rel="stylesheet">

</head>
<body>


  <div class="mobile-nav">
    <a  class="nav-link sidebar-link text-dark" href="#" data-page="admin_overview.php"><img src="../../assets/pp.svg" alt="SkillCert Logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>


  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
      <h5>SkillCert</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav flex-column mb-auto">
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="admin_overview.php"><i class="fa-solid fa-gauge-high fa-2xl" style="color: #daa520;"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="admin_registered_users.php"><i class="fa-solid fa-users fa-2xl" style="color: #daa320;"></i> Registered Users</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="manage_course.php"><i class="fa-solid fa-layer-group fa-2xl" style="color: #daa520;"></i> Course Reports</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="manage_certificate.php"><i class="fa-solid fa-ribbon fa-2xl" style="color: #daa520;"></i> Certificate Management</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="course_list.php"><i class="fa-solid fa-table-list fa-2xl" style="color: #daa520;"></i> Course List</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="add_course.php"><i class="fa-solid fa-plus fa-2xl" style="color: #daa520;"></i> Add Course</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="modules.php"><i class="fa-solid fa-book-open-reader fa-2xl" style="color: #daa520;"></i> Modules</a></li>
        <hr>
        <li class="nav-item"><a class="nav-link text-danger fw-bold" href="../../authentication/logout.php"><i class="fa-solid fa-right-from-bracket fa-2xl" style="color: #daa520;"></i> Logout</a></li>
      </ul>

      <hr>
      <img src="../../assets/maltese-portrait.jpg" width="70" height="70" class="rounded-circle border border-warning mb-2">
      <div><strong></strong></div>
    </div>
  </div>


  <!-- Sidebar -->
  <nav class="sidebar">
    <div>
      <div class="brand">
        <a class="nav-link sidebar-link text-dark" href="#" data-page="admin_overview.php">
          <img src="../../assets/pp.svg" alt="Logo" style="margin-bottom: 50px; width: 200px;">
        </a>
      </div>

      <!-- Navigation -->
      <ul class="nav flex-column mb-auto">
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="admin_overview.php"><i class="fa-solid fa-gauge-high fa-2xl" style="color: #daa520;"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="admin_registered_users.php"><i class="fa-solid fa-users fa-2xl" style="color: #daa320;"></i> Registered Users</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="manage_course.php"><i class="fa-solid fa-layer-group fa-2xl" style="color: #daa520;"></i> Course Reports</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="manage_certificate.php"><i class="fa-solid fa-ribbon fa-2xl" style="color: #daa520;"></i> Certificate Reports</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="course_list.php"><i class="fa-solid fa-table-list fa-2xl" style="color: #daa520;"></i> Course List</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="add_course.php"><i class="fa-solid fa-plus fa-2xl" style="color: #daa520;"></i> Add Course</a></li>
        <li class="nav-item"><a class="nav-link sidebar-link text-dark" href="#" data-page="modules.php"><i class="fa-solid fa-book-open-reader fa-2xl" style="color: #daa520;"></i> Modules</a></li>
        <hr>
        <li class="nav-item"><a class="nav-link text-black fw-bold" href="../../authentication/logout.php"><i class="fa-solid fa-right-from-bracket fa-2xl" style="color: #daa520;"></i> Logout</a></li>
      </ul>
    </div>

    <div class="user-section text-center border-top pt-3">
      <img src="../../assets/maltese-portrait.jpg" alt="Profile" style="width: 100px; height: 80px;" class="rounded-circle border border-warning mb-2">
      <div class="user-name"><strong>Admin Log</strong></div>
    </div>
  </nav>

  <main id="main-content"></main>


  <!-- Scripts -->
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../js/bootstrap.bundle.min.js"></script>
  <script src="../../fontawesome-free-7.1.0-web/js/all.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>

<script>
  $(document).ready(function() {

    // Function to load a page into #main-content
    function loadPage(page) {
      $('#main-content').load(page, function(response, status) {
        if (status === "error") {
          $('#main-content').html("<div class='text-center mt-5 text-danger'>⚠️ Sorry, content could not be loaded.</div>");
        }
      });
    }

    // Sidebar click event
    $('.sidebar-link').on('click', function(event) {
      const page = $(this).attr('data-page');
      const href = $(this).attr('href');

      if (href && href.includes("logout.php")) return; // allow logout

      event.preventDefault();
      if (page) {
        localStorage.setItem('lastPage', page);
        loadPage(page);

        // Highlight the active link
        $('.sidebar-link').removeClass('active fw-bold');
        $(this).addClass('active fw-bold');
      }
    });

    // Load last page or default dashboard
    const lastPage = localStorage.getItem('lastPage') || 'admin_overview.php';
    loadPage(lastPage);

    // Highlight correct link
    $('.sidebar-link').each(function() {
      if ($(this).attr('data-page') === lastPage) {
        $(this).addClass('active fw-bold');
      }
    });
  });
  </script>

</body>
</html>