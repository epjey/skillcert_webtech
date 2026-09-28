<?php
include("../../config/db_conn.php");

$course_id = isset($_GET['course_id']) && $_GET['course_id'] !== '' ? intval($_GET['course_id']) : null;

//etect if the request is for a dropdown instead of cards
$isDropdown = isset($_GET['format']) && $_GET['format'] === 'dropdown';

$query = "SELECT m.*, c.course_name 
          FROM modules m
          JOIN courses c ON m.course_id = c.course_id";

if ($course_id) {
  $query .= " WHERE m.course_id = $course_id";
}

$query .= " ORDER BY c.course_name, m.module_order ASC";

$result = mysqli_query($conn, $query);


if ($isDropdown) {
  if (mysqli_num_rows($result) > 0) {
    echo '<option value="">-- Select Module --</option>';
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<option value="' . $row['module_id'] . '">' . htmlspecialchars($row['module_title']) . '</option>';
    }
  } else {
    echo '<option value="">No modules found</option>';
  }
  exit; 
}


if (mysqli_num_rows($result) > 0): ?>
  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="col-md-4 mb-4">
      <div class="card module-card position-relative shadow-sm p-3">
        <div class="module-actions">
          <button 
            class="btn btn-sm btn-outline-warning edit-module"
            data-id="<?= $row['module_id'] ?>"
            data-title="<?= htmlspecialchars($row['module_title']) ?>"
            data-order="<?= $row['module_order'] ?>"
            data-course="<?= $row['course_id'] ?>"
          >
            Edit
          </button>
          <button 
            class="btn btn-sm btn-outline-danger delete-module"
            data-id="<?= $row['module_id'] ?>"
          >
            Delete
          </button>
        </div>
        <h5 class="text-warning mb-2"><?= htmlspecialchars($row['module_title']) ?></h5>
        <p class="mb-1"><strong>Course:</strong> <?= htmlspecialchars($row['course_name']) ?></p>
        <p class="mb-0"><strong>Order:</strong> <?= $row['module_order'] ?></p>
      </div>
    </div>
  <?php endwhile; ?>
<?php else: ?>
  <div class="col-12">
    <div class="alert alert-info text-center">No modules found.</div>
  </div>
<?php endif; ?>
