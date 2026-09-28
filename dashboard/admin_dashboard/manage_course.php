<?php 
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");
?>

<div class="card shadow-sm border-0 rounded-4">
  <div class="card-header text-white fs-3 fw-semibold" style="background-color: #daa520;">
    Manage Courses
  </div>

  <div class="card-body bg-light">
    <div class="table-responsive">
      <table id="courseTable" class="table table-bordered table-striped align-middle rounded-3 overflow-hidden">
        <thead class="table-dark">
          <tr>
            <th>Course ID</th>
            <th>Course Title</th>
            <th>Completion Rate</th>
            <th>Certificates Issued</th>
          </tr>
        </thead>
        <tbody>
          <?php
              $query = "
                SELECT 
                  c.course_id,
                  c.course_name,
                  COALESCE(
                    ROUND(
                      (
                        COUNT(DISTINCT CASE WHEN lp.status = 'completed' THEN CONCAT(lp.user_id, '-', lp.lesson_id) END)
                        / NULLIF(COUNT(DISTINCT CONCAT(lp.user_id, '-', l.lesson_id)), 0)
                      ) * 100,
                    2),
                  0) AS completion_rate,
                  COUNT(DISTINCT cert.certificate_id) AS cert_count
                FROM courses AS c
                LEFT JOIN lessons AS l ON l.course_id = c.course_id
                LEFT JOIN lesson_progress AS lp ON lp.lesson_id = l.lesson_id
                LEFT JOIN certificates AS cert ON cert.course_id = c.course_id
                GROUP BY c.course_id
                ORDER BY c.course_id DESC
            ";

          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
          ?>
              <tr>
                <td><?php echo $row['course_id']; ?></td>
                <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td><?php echo $row['completion_rate'] . '%'; ?></td>
                <td><?php echo $row['cert_count']; ?></td>
              </tr>
          <?php
            endwhile;
          else:
            echo "<tr><td colspan='4' class='text-center text-muted'>No courses found</td></tr>";
          endif;
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<style>
div.dt-buttons .btn {
  border-radius: 8px !important;
  margin: 3px !important;
  color: #fff !important;
  border: none !important;
  font-weight: 500;
  transition: background 0.2s ease;
}

div.dt-buttons .buttons-copy { background-color: #6c757d !important; }
div.dt-buttons .buttons-csv { background-color: #0d6efd !important; }
div.dt-buttons .buttons-excel { background-color: #198754 !important; }
div.dt-buttons .buttons-pdf { background-color: #dc3545 !important; }
div.dt-buttons .buttons-print { background-color: #ffc107 !important; color: #000 !important; }
</style>
<!-- CSS + JS -->
<script src="../../jquery.js/jquery-3.7.1.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="../../DataTables/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="../../DataTables/buttons.bootstrap5.min.css">
<script src="../../DataTables/jquery.dataTables.min.js"></script>
<script src="../../DataTables/dataTables.bootstrap5.min.js"></script>
<script src="../../libs/sweetalert2.all.min.js"></script>
<script src="../../DataTables/dataTables.buttons.min.js"></script>
<script src="../../DataTables/buttons.bootstrap5.min.js"></script>
<script src="../../DataTables/jszip.min.js"></script>
<script src="../../DataTables/pdfmake.min.js"></script>
<script src="../../DataTables/vfs_fonts.js"></script>
<script src="../../DataTables/buttons.html5.min.js"></script>
<script src="../../DataTables/buttons.print.min.js"></script>

  <script>
  $(document).ready(function () {
    $('#courseTable').DataTable({
      dom: 'Bfrtip',
      buttons: [
        { extend: 'copy', text: 'Copy' },
        { extend: 'csv', text: 'CSV' },
        { extend: 'excel', text: 'Excel' },
        { extend: 'pdf', text: 'PDF' },
        { extend: 'print', text: 'Print' }
      ],
      pageLength: 10,
      lengthMenu: [15, 20, 25, 50],
      responsive: true
    });
  });
  </script>
