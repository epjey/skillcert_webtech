<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");

$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Courses | SkillCert</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../../fontawesome-free-7.1.0-web/css/all.min.css">

  <style>
    /* ===== Base Style ===== */
    body {
      font-family: "Poppins", sans-serif;
      background: #f9fafc;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* ===== Container ===== */
    .main-card {
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
      padding: 35px 45px;
      max-width: 1800px;
      margin: 20px auto 40px;
      transition: 0.3s ease;
    }

    /* ===== Header ===== */
    .header {
      text-align: center;
      margin-bottom: 0px;
    }

    .header h1 {
      font-weight: 700;
      color: #222;
      font-size: 1.9rem;
    }

    .header i {
      color: #daa520;
      margin-right: 10px;
    }

    .header p {
      color: #666;
      font-size: 0.95rem;
      margin-top: 6px;
    }

    /* ===== Grid Layout ===== */
    .row.g-4 {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      justify-content: center;
    }

    .row.g-4 > [class*="col-"] {
      flex: 1 1 280px;
      max-width: 420px;
      display: flex;
    }

    /* ===== Course Card ===== */
    .course-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      padding: 10px 10px;
      text-align: center;
      display: flex;
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
      height: 240px; /* fixed height to keep rectangular shape */
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .course-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
      border: 1px solid rgba(218, 165, 32, 0.3);
    }

    /* ===== Action Buttons ===== */
    .action-buttons {
      position: absolute;
      top: 12px;
      right: 15px;
      z-index: 10;
    }

    .edit-btn,
    .delete-btn {
      border: none;
      background: none;
      font-size: 1rem;
      margin-left: 6px;
      cursor: pointer;
      color: #666;
      transition: color 0.2s ease;
    }

    .edit-btn:hover {
      color: #d4af37;
    }

    .delete-btn:hover {
      color: #d9534f;
    }

    /* ===== Course Content ===== */
    .course-card i.fa-book {
      font-size: 2rem;
      color: #daa520;
      margin-bottom: 15px;
    }

    .course-title {
      font-weight: 600;
      color: #222;
      font-size: 1.05rem;
      margin-bottom: 8px;
      padding: 0 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .course-desc {
      font-size: 0.9rem;
      color: #555;
      line-height: 1.4;
      padding: 0 10px;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }

    /* ===== Responsive ===== */
    @media (max-width: 992px) {
      .course-card {
        height: 220px;
      }
    }

    @media (max-width: 768px) {
      .row.g-4 {
        gap: 20px;
      }
      .course-card {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

  <main class="container-fluid mt-2 mb-5">
    <div class="main-card">
      <div class="header mb-4">
        <h1><i class="fa-solid fa-layer-group"></i> Available Courses</h1>
        <p>Select a course to view its lessons, quizzes, and exams.</p>
      </div>

      <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="col-md-6 col-lg-4 fade-in">
            <div class="course-card" data-id="<?php echo $row['course_id']; ?>">
              
              <div class="action-buttons">
                <button class="edit-btn" 
                        data-id="<?php echo $row['course_id']; ?>"
                        data-name="<?php echo htmlspecialchars($row['course_name']); ?>"
                        data-description="<?php echo htmlspecialchars($row['description']); ?>">
                  <i class="fa-solid fa-pen-to-square fa-lg"></i>
                </button>
                <button class="delete-btn" data-id="<?php echo $row['course_id']; ?>">
                  <i class="fa-solid fa-trash fa-lg"></i>
                </button>
              </div>

              <div onclick="window.location.href='lessons.php?course_id=<?php echo $row['course_id']; ?>'">
                <i class="fa-solid fa-book"></i>
                <h5 class="course-title"><?php echo htmlspecialchars($row['course_name']); ?></h5>
                <p class="course-desc"><?php echo htmlspecialchars($row['description']); ?></p>
              </div>

            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </main>

  <!-- ===== Edit Modal ===== -->
  <div class="modal fade" id="editCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editCourseForm">
          <div class="modal-header bg-warning text-white">
            <h5 class="modal-title">Edit Course</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="course_id" id="editCourseId">
            <div class="mb-3">
              <label class="form-label">Course Name</label>
              <input type="text" name="course_name" id="editCourseName" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" id="editCourseDescription" class="form-control" rows="3"></textarea>
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
  var editModal = new bootstrap.Modal(document.getElementById('editCourseModal'));

  $('.edit-btn').on('click', function(e) {
    e.stopPropagation();
    var id = $(this).data('id');
    var name = $(this).data('name');
    var desc = $(this).data('description');

    $('#editCourseId').val(id);
    $('#editCourseName').val(name);
    $('#editCourseDescription').val(desc);

    editModal.show();
  });

  $('#editCourseForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'update_course.php',
      type: 'POST',
      data: {
        course_id: $('#editCourseId').val(),
        course_name: $('#editCourseName').val(),
        description: $('#editCourseDescription').val()
      },
      dataType: 'json',
      success: function(res) {
        if (res.status == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: res.message,
            timer: 1200,
            showConfirmButton: false
          });

          var id = $('#editCourseId').val();
          var newName = $('#editCourseName').val();
          var newDesc = $('#editCourseDescription').val();

          var card = $(".course-card[data-id='" + id + "']");
          card.find('.course-title').text(newName);
          card.find('.course-desc').text(newDesc);

          editModal.hide();
        } else {
          Swal.fire('Error', res.message, 'error');
        }
      },
      error: function() {
        Swal.fire('Error', 'Server error occurred', 'error');
      }
    });
  });

  $('.delete-btn').on('click', function(e) {
    e.stopPropagation();
    var courseId = $(this).data('id');
    var card = $(this).closest('.col-md-6');

    Swal.fire({
      title: 'Are you sure?',
      text: 'This will delete the course and all related lessons.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      confirmButtonColor: '#d33'
    }).then(function(result) {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_course.php',
          type: 'POST',
          data: { course_id: courseId },
          dataType: 'json',
          success: function(res) {
            if (res.status == 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: res.message,
                timer: 1200,
                showConfirmButton: false
              });
              card.fadeOut(400, function() { card.remove(); });
            } else {
              Swal.fire('Error', res.message, 'error');
            }
          },
          error: function() {
            Swal.fire('Error', 'Server error occurred', 'error');
          }
        });
      }
    });
  });
  </script>

</body>
</html>
