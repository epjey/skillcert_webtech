<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");

$sql = "
SELECT u.*, IFNULL(SUM(sl.warning_count), 0) AS tab_switch_count
FROM users u
LEFT JOIN security_logs sl ON u.user_id = sl.user_id
WHERE u.role='student'
GROUP BY u.user_id
";

$result = mysqli_query($conn, $sql);
?>
<style>

body {
  background: #f9fafc;
  font-family: "Poppins", sans-serif;
  color: #333;
}


.card {
  border: none;
  border-radius: 16px;
  box-shadow: 0 6px 16px rgba(0,0,0,0.08);
  overflow: hidden;
  background: #fff;
}

.card-header {
  background: goldenrod;
  color: #fff;
  font-weight: 600;
  border: none;
  padding: 1rem 1.5rem;
}

.card-header h5 {
  font-weight: 700;
  font-size: 1.4rem;
  margin: 0;
}


.table {
  border-radius: 10px;
  overflow: hidden;
}

.table thead {
  background: rgba(218,165,32,0.9);
  color: #fff;
  text-transform: uppercase;
  font-size: 0.9rem;
}

.table tbody tr {
  transition: all 0.2s ease;
}

.table tbody tr:hover {
  background: rgba(218,165,32,0.05);
}


.btn {
  border-radius: 8px !important;
  font-weight: 500;
  transition: all 0.25s ease;
}

.btn-warning {
  background: goldenrod !important;
  border: none !important;
  color: #fff !important;
}

.btn-warning:hover {
  background: #e6b800 !important;
  color: #fff !important;
}

.btn-danger {
  background: #dc3545 !important;
  border: none !important;
}

.btn-danger:hover {
  background: #bb2d3b !important;
}

.btn-secondary {
  background: #6c757d !important;
  border: none !important;
}

.btn-success {
  background: #198754 !important;
  border: none !important;
}


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

.modal-content {
  border-radius: 16px;
  overflow: hidden;
  border: none;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.modal-header {
  background: goldenrod;
  color: #fff;
  font-weight: 600;
  border: none;
}

.modal-body {
  background: #fff;
  padding: 2rem;
}

.modal-footer {
  background: #f8f9fa;
  border-top: 1px solid #eee;
  padding: 1rem 1.5rem;
}


.form-label {
  font-weight: 600;
  color: #333;
}

.form-control {
  border-radius: 10px;
  border: 1px solid #ccc;
  padding: 0.6rem 1rem;
  transition: border 0.2s ease;
}

.form-control:focus {
  border-color: goldenrod;
  box-shadow: 0 0 0 0.15rem rgba(218,165,32,0.25);
}


@media (max-width: 768px) {
  .card-header h5 {
    font-size: 1.1rem;
  }
  .btn {
    font-size: 0.85rem;
    padding: 4px 8px;
  }
  .table {
    font-size: 0.9rem;
  }
}
</style>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white" style="background: rgb(218, 165, 32);">
        <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="editForm">
        <div class="modal-body">
          <input type="hidden" name="student_id" id="student_id">

          <div>
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-control" id="status" name="status" required>
                <option value="active">Active</option>
                <option value="banned">Banned</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Student Table -->
<div class="card shadow-lg mt-5">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <h5 class="head mb-0 fw-semibold" style="font-size: 35px;">Registered Users</h5>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="studentTable" class="table table-bordered table-striped align-middle w-100">
        <thead class="table-dark">
          <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Tab Switch Count</th>
            <th>Actions</th>

          </tr>
        </thead>
        <tbody id="studentBody">
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr id="row-<?= $row['user_id'] ?>">
                <td>STU-<?= str_pad($row['user_id'], 3, '0', STR_PAD_LEFT) ?></td>
                <td class="col-first_name"><?= htmlspecialchars($row['first_name']) ?></td>
                <td class="col-last_name"><?= htmlspecialchars($row['last_name']) ?></td>
                <td class="col-email"><?= htmlspecialchars($row['email']) ?></td>
                <td class="col-status">
                  <?php if ($row['status'] === "active"): ?>
                    <span class="badge bg-success">Active</span>
                  <?php elseif ($row['status'] === "banned"): ?>
                    <span class="badge bg-danger">Banned</span>
                  <?php endif; ?>
                </td>
                <td><?= $row['tab_switch_count'] ?></td>

                <td>
                  <button class="btn btn-sm btn-warning editBtn"
                    data-id="<?= $row['user_id'] ?>"
                    data-first_name="<?= htmlspecialchars($row['first_name']) ?>"
                    data-last_name="<?= htmlspecialchars($row['last_name']) ?>"
                    data-email="<?= htmlspecialchars($row['email']) ?>"
                    data-status="<?= $row['status'] ?>">
                    Edit
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center">No students found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

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

<style>

@media (max-width: 768px) {
  .card-header h5 {
    font-size: 1.2rem;
  }
  .btn {
    font-size: 0.85rem;
    padding: 4px 8px;
  }
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

table.dataTable td, table.dataTable th {
  vertical-align: middle;
}

.table-responsive {
  overflow-x: auto;
}
</style>

<script>
$(document).ready(function () {
  if (!$.fn.DataTable.isDataTable('#studentTable')) {
    $('#studentTable').DataTable({
      dom: '<"d-flex flex-wrap justify-content-between align-items-center mb-2"Bf>rtip',
      buttons: [
        { extend: 'copy', text: 'Copy' },
        { extend: 'csv', text: 'CSV' },
        { extend: 'excel', text: 'Excel' },
        { extend: 'pdf', text: 'PDF' },
        { extend: 'print', text: 'Print' }
      ],
      responsive: true,
      pageLength: 10,
      lengthMenu: [10, 20, 30, 50]
    });
  }

  // Open Edit Modal
  $('.editBtn').on('click', function() {
    $('#student_id').val($(this).data('id'));
    $('#first_name').val($(this).data('first_name'));
    $('#last_name').val($(this).data('last_name'));
    $('#email').val($(this).data('email'));
    $('#status').val($(this).data('status'));
    $('#editModal').modal('show');
  });

  // Edit Submit
  $('#editForm').on('submit', function(e) {
    e.preventDefault();
    $.post("update_student.php", $(this).serialize(), function(response) {
      if (response.trim() === "success") {
        var id = $('#student_id').val();
        var row = $('#row-' + id);
        row.find('.col-first_name').text($('#first_name').val());
        row.find('.col-last_name').text($('#last_name').val());
        row.find('.col-email').text($('#email').val());
        row.find('.col-status').html($('#status').val() === 'active' ? 
          "<span class='badge bg-success'>Active</span>" : 
          "<span class='badge bg-danger'>Banned</span>");
        $('#editModal').modal('hide');
        Swal.fire("Updated!", "Student updated successfully.", "success");
      } else {
        Swal.fire("Error", response, "error");
      }
    });
  });
});
</script>