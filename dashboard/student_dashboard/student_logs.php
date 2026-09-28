<?php 
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");



?>

<style>
  body {
    background-color: #fff;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  main {
    padding: 40px 30px;
    transition: margin-left 0.3s ease;
  }

  @media (max-width: 991px) {
    main {
      margin-left: 0;
      padding: 110px 20px 40px; 
    }
  }

  .content-wrapper {
    border-radius: 20px;
    max-width: 1800px;
    margin: 0 auto;
  }


  .card {
    border: none;
    border-radius: 20px;
    box-shadow: 1px 2px 8px rgba(0,0,0,0.1);
    
  }

  .table thead {
    background-color: #1b1e23;
    color: #DAA520;
  }

  .table tbody tr:hover {
    background-color: #fff3b0;
    transition: background-color 0.3s ease-in;
  }

  h4, h5 {
    color: #1b1e23;
  }

  .fw-bold {
    color: #1b1e23;
  }

  @media (max-width: 576px) {
    .content-wrapper {
      padding: 10px;
    }

    h4.fw-bold i,
    h5.fw-bold i {
      font-size: 1.3rem;
    }

    .table th,
    .table td {
      font-size: 0.9rem;
      white-space: nowrap;
    }
  }
</style>
<main id="main-content" class="container-fluid my-5">
  <div class="content-wrapper card shadow-lg px-4 py-4">
    <h4 class="fw-bold mb-4">
      <i class="fa-solid fa-eye-low-vision fa-2xl" style="color: #daa520;"></i> My Assessment Log
    </h4>
    <p class="text-muted mb-4">Track your tab switch counts logs.</p>



    <!-- Table -->
    <div class="card shadow-sm p-4">
      <h5 class="fw-bold mb-3">
        <i class="fa-solid fa-file-circle-exclamation fa-beat fa-2xl" style="color: #daa520;"></i> Assessment Details
      </h5>
      <div class="table-responsive">
        <table class="table table-striped align-middle mb-0" id="logTable">
          <thead>
            <tr>
              <th>Assessment</th>
              <th>Date Taken</th>
              <th>Tab Switch Count</th>
            </tr>
          </thead>
          <tbody>
              <?php
              include("../../config/db_conn.php");
              $user_id = $_SESSION['user_id'] ?? 0;

              $query = mysqli_query($conn, "
                SELECT e.exam_title, sl.warning_count, er.taken_at
                FROM security_logs sl
                JOIN exams e ON e.exam_id = sl.exam_id
                LEFT JOIN exam_results er ON er.exam_id = sl.exam_id AND er.user_id = sl.user_id
                WHERE sl.user_id = $user_id
                ORDER BY er.taken_at DESC
              ");

              if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                  $badgeClass = $row['warning_count'] >= 3 ? 'bg-danger' : ($row['warning_count'] == 2 ? 'bg-warning text-dark' : 'bg-success');
                  echo "
                  <tr>
                    <td>".htmlspecialchars($row['exam_title'])."</td>
                    <td>".($row['taken_at'] ? date('m/d/Y', strtotime($row['taken_at'])) : 'N/A')."</td>
                    <td><span class='badge $badgeClass'>{$row['warning_count']}</span></td>
                  </tr>";
                }
              } else {
                echo "<tr><td colspan='3' class='text-center'>No security logs found.</td></tr>";
              }
              ?>
              </tbody>

        </table>
      </div>
    </div>
  </div>
</main>