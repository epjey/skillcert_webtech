<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");
?>

<style>
body, .card, .table {
  font-family: "Poppins", sans-serif;
  color: #333;
}
.card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  background: #fff;
}
.card-header {
  background: rgb(218,165,32);
  color: white;
  padding: 1rem 1.5rem;
  font-weight: 600;
  border-bottom: 3px solid #b8860b;
}
.card-body {
  padding: 1.5rem;
  background: #f8f9fa;
}
.table {
  background: white;
  border-radius: 12px;
  overflow: hidden;
}
.table th {
  background-color: #343a40 !important;
  color: white !important;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.5px;
}
.table td {
  vertical-align: middle;
  font-size: 0.95rem;
}
div.dt-buttons .btn {
  border-radius: 6px !important;
  margin: 3px !important;
  color: white !important;
  border: none !important;
  font-weight: 500;
}
div.dt-buttons .buttons-copy { background-color: #6c757d !important; }
div.dt-buttons .buttons-csv { background-color: #0d6efd !important; }
div.dt-buttons .buttons-excel { background-color: #198754 !important; }
div.dt-buttons .buttons-pdf { background-color: #dc3545 !important; }
div.dt-buttons .buttons-print { background-color: #ffc107 !important; color: #000 !important; }
@media (max-width: 768px) {
  .card-header h5 {
    font-size: 1.25rem;
  }
  .btn {
    font-size: 0.85rem;
    padding: 4px 8px;
  }
}
</style>

<!-- Card Wrapper -->
<div class="card shadow-sm mt-5">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-semibold fs-1">Certificates</h5>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="certificateTable" class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>Certificate ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Course Title</th>
            <th>Date Issued</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "
            SELECT 
              cert.certificate_id,
              u.first_name,
              u.last_name,
              c.course_name,
              cert.issued_date
            FROM certificates AS cert
            JOIN users AS u ON u.user_id = cert.user_id
            JOIN courses AS c ON c.course_id = cert.course_id
            GROUP BY cert.certificate_id
            ORDER BY cert.issued_date DESC
          ";

          $result = mysqli_query($conn, $query);

          if (!$result) {
            die('SQL Error: ' . mysqli_error($conn));
          }

          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>CERT-{$row['certificate_id']}</td>
                      <td>{$row['first_name']}</td>
                      <td>{$row['last_name']}</td>
                      <td>{$row['course_name']}</td>
                      <td>{$row['issued_date']}</td>
                    </tr>";
            }
          } else {
            echo '<tr><td colspan="5" class="text-center text-muted">No certificates found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

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
  $('#certificateTable').DataTable({
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
