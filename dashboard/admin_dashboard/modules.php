<?php
include("../../config/db_conn.php");
include("../../authentication/auth_check.php");
requireRole("admin");

// Fetch all courses for module filter and assignment
$courses = mysqli_query($conn, "SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Modules | SkillCert</title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
    body {
      background-color: #f5f7fa;
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
    }

    h3 {
      font-weight: 700;
      color: #d4af37;
    }

    .card {
      border: none;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .card h5 {
      font-weight: 600;
      color: #343a40;
    }

    .btn-warning {
      background-color: #d4af37;
      border: none;
      color: #fff;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-warning:hover {
      background-color: #b7952b;
      color: #fff;
    }

    .form-select,
    .form-control {
      border-radius: 10px;
      border: 1px solid #ddd;
      transition: 0.2s;
    }

    .form-select:focus,
    .form-control:focus {
      border-color: #d4af37;
      box-shadow: 0 0 5px rgba(212, 175, 55, 0.4);
    }

    .module-card {
      transition: all 0.25s ease;
      border-radius: 15px;
      cursor: pointer;
      border: 1px solid #eee;
      background-color: #fff;
      padding: 15px;
    }

    .module-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.12);
    }

    .module-actions {
      display: flex;
      gap: 8px;
      margin-bottom: 10px;
    }

    .module-actions .btn {
      border-radius: 8px;
      padding: 6px 10px;
      font-size: 16px;
      transition: all 0.2s ease;
    }

    .module-actions .btn i {
      font-size: 15px;
    }

    .module-actions .btn-outline-warning {
      color: #d4af37;
      border-color: #d4af37;
    }

    .module-actions .btn-outline-warning:hover {
      background-color: #d4af37;
      color: #fff;
    }

    .module-actions .btn-outline-danger {
      color: #dc3545;
      border-color: #dc3545;
    }

    .module-actions .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
    }

    .modal-header {
      background-color: #d4af37;
      color: #fff;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="fa-solid fa-book fa-lg me-2" style="color:#d4af37;"></i>Manage Modules</h3>
  </div>

  <!-- Filter by Course -->
  <div class="card shadow-sm p-3 mb-4">
    <label class="form-label fw-semibold text-dark">Filter by Course</label>
    <select id="filterCourse" class="form-select">
      <option value="">All Courses</option>
      <?php while($c = mysqli_fetch_assoc($courses)): ?>
        <option value="<?= $c['course_id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <!-- Add Module Form -->
  <div class="card shadow-lg p-4 mb-4">
    <h5 class="mb-3 text-dark"><i class="fa-solid fa-plus fa-lg me-2" style="color:#d4af37;"></i>Add New Module</h5>
    <form id="addModuleForm">
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label fw-semibold">Course</label>
          <select name="course_id" class="form-select" required>
            <option value="">Select a Course</option>
            <?php
            mysqli_data_seek($courses, 0); // reset pointer
            while($c = mysqli_fetch_assoc($courses)): ?>
              <option value="<?= $c['course_id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label fw-semibold">Module Title</label>
          <input type="text" name="module_title" class="form-control" placeholder="Enter module title" required>
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label fw-semibold">Module Order</label>
          <input type="number" name="module_order" class="form-control" placeholder="1, 2, 3..." required>
        </div>
      </div>
      <button type="submit" class="btn btn-warning w-100 py-2">
        <i class="fa-solid fa-circle-plus me-2"></i>Add Module
      </button>
    </form>
  </div>

  <!-- Modules List -->
  <div class="row" id="modulesContainer"></div>
</div>

<!-- Edit Module Modal -->
<div class="modal fade" id="editModuleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editModuleForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit Module</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="module_id" id="editModuleId">
          <div class="mb-3">
            <label class="form-label">Course</label>
            <select name="course_id" id="editCourseId" class="form-select" required>
              <?php
              mysqli_data_seek($courses, 0); // reset pointer
              while($c = mysqli_fetch_assoc($courses)): ?>
                <option value="<?= $c['course_id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Module Title</label>
            <input type="text" name="module_title" id="editModuleTitle" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Module Order</label>
            <input type="number" name="module_order" id="editModuleOrder" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>

<script>
function loadModules(course_id = '') {
  $.get('fetch_modules.php', { course_id }, function(data){
    $('#modulesContainer').html(data);
  });
}

loadModules();

$('#filterCourse').on('change', function(){
  const course_id = $(this).val();
  loadModules(course_id);
});

// ADD MODULE
$('#addModuleForm').on('submit', function(e){
  e.preventDefault();
  $.post('save_module.php', $(this).serialize(), function(response){
    let res = JSON.parse(response);
    if(res.status === 'success'){
      Swal.fire('Added!', res.message, 'success').then(()=>{
        const course_id = $('#filterCourse').val();
        loadModules(course_id);
      });
      $('#addModuleForm')[0].reset();
    } else {
      Swal.fire('Error', res.message, 'error');
    }
  });
});

// OPEN EDIT MODAL
$(document).on('click', '.edit-module', function(){
  $('#editModuleId').val($(this).data('id'));
  $('#editModuleTitle').val($(this).data('title'));
  $('#editModuleOrder').val($(this).data('order'));
  $('#editCourseId').val($(this).data('course'));
  new bootstrap.Modal('#editModuleModal').show();
});

// UPDATE MODULE
$('#editModuleForm').on('submit', function(e){
  e.preventDefault();
  $.post('update_module.php', $(this).serialize(), function(response){
    let res = JSON.parse(response);
    if(res.status === 'success'){
      Swal.fire('Updated!', res.message, 'success').then(()=>{
        const modal = bootstrap.Modal.getInstance(document.getElementById('editModuleModal'));
        modal.hide();
        const id = $('#editModuleId').val();
        const updatedTitle = $('#editModuleTitle').val();
        const updatedOrder = $('#editModuleOrder').val();
        const updatedCourse = $('#editCourseId').val();
        const card = $(`.edit-module[data-id="${id}"]`).closest('.card');
        card.find('h5').text(updatedTitle);
        card.find('p strong:contains("Order:")').parent().html(`<strong>Order:</strong> ${updatedOrder}`);
        card.find('.edit-module').data('title', updatedTitle);
        card.find('.edit-module').data('order', updatedOrder);
        card.find('.edit-module').data('course', updatedCourse);
      });
    } else {
      Swal.fire('Error', res.message, 'error');
    }
  });
});

// DELETE MODULE
$(document).on('click', '.delete-module', function(){
  const id = $(this).data('id');
  const card = $(this).closest('.col-md-4');

  Swal.fire({
    title: 'Delete this module?',
    text: 'This will delete the module and all related lessons/exams.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete'
  }).then((result)=>{
    if(result.isConfirmed){
      $.post('delete_module.php', { module_id: id }, function(response){
        let res = JSON.parse(response);
        if(res.status === 'success'){
          Swal.fire('Deleted!', res.message, 'success');
          card.fadeOut(300, function(){ $(this).remove(); });
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      });
    }
  });
});
</script>
</body>
</html>