<?php
include('../../config/db_conn.php');

include("../../authentication/auth_check.php");
requireRole("admin");

?>

<style>
body {
  background-color: #ffffffff;
}

.dashboard-wrapper {
  font-family: "Poppins", sans-serif;
  color: #333;
  padding: 1rem;
}

.dashboard-wrapper h4 {
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 1.5rem;
  text-align: left;
}


.dashboard-card {
  background: #ffffffff;
  border-radius: 18px;
  padding: 2rem 1rem;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  text-align: center;
  transition: all 0.3s ease;
  border: 2px solid rgba(218,165,32,0.3);
}

.dashboard-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 22px rgba(0,0,0,0.12);
  background-color: rgba(218,165,32,0.3);
}


.dashboard-card i {
  display: block;
  font-size: 2.8rem;
  color: #d4af37;
  margin-bottom: 1rem;
  transition: transform 0.3s ease;
}

.dashboard-card:hover i {
  transform: scale(1.1);
}

/* Labels */
.dashboard-card h6 {
  font-weight: 600;
  font-size: 1rem;
  color: #444;
  margin-bottom: 0.5rem;
}

/* Numbers */
.dashboard-card h3 {
  font-size: 2.6rem;
  font-weight: 700;
  color: #111;
  margin: 0;
}

/* Responsive Layout */
@media (max-width: 992px) {
  .dashboard-card {
    padding: 1.8rem 1rem;
  }
  .dashboard-card h3 {
    font-size: 2rem;
  }
}

@media (max-width: 768px) {
  .dashboard-card {
    width: 80%;
    margin: 0 auto;
  }
}

</style>

<div class="dashboard-wrapper card shadow-lg mt-5" style="border-radius: 10px; padding: 40px 30px;">
  <h4 style="font-size: 40px;"><i class="fa-solid fa-gauge fa-2xl" style="color: #daa520;"></i> Dashboard Overview</h4>

  <div class="row g-4">

    <!-- Registered Users -->
    <div class="col-lg-4 col-md-6">
      <div class="dashboard-card">
        <i class="fa-solid fa-users"></i>
        <h6>Registered Users</h6>
        <h3>
          <?php 
            $student = "SELECT * FROM users WHERE role='student'";
            $result = mysqli_query($conn, $student);
            echo mysqli_num_rows($result);
          ?>
        </h3>
      </div>
    </div>

    <!-- Total Courses -->
    <div class="col-lg-4 col-md-6">
      <div class="dashboard-card">
        <i class="fa-solid fa-layer-group"></i>
        <h6>Total Courses</h6>
        <h3>
          <?php 
            $course = "SELECT * FROM courses";
            $result = mysqli_query($conn, $course);
            echo mysqli_num_rows($result);
          ?>
        </h3>
      </div>
    </div>

    <!-- Certificates Issued -->
    <div class="col-lg-4 col-md-6">
      <div class="dashboard-card">
        <i class="fa-solid fa-award"></i>
        <h6>Certificates Issued</h6>
        <h3>
          <?php
            $certificate = "SELECT * FROM certificates WHERE status='issued'";
            $result = mysqli_query($conn, $certificate);
            echo mysqli_num_rows($result);
          ?>
        </h3>
      </div>
    </div>
  </div>
</div>

<script>
// Display formatted current date
document.addEventListener("DOMContentLoaded", () => {
  const dateDisplay = document.getElementById("dateDisplay");
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateDisplay.textContent = new Date().toLocaleDateString('en-US', options);
});
</script>