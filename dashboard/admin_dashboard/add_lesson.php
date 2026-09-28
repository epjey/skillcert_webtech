<?php
include("../../config/db_conn.php");

if (!isset($_GET['module_id'])) {
  die("<h4 class='text-danger text-center mt-5'>Missing module_id in URL!</h4>");
}


$module_id = intval($_GET['module_id']);
$module = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM modules WHERE module_id = $module_id"));
if (!$module) die("<h4 class='text-danger text-center mt-5'>Module not found!</h4>");

$course_id = $module['course_id'];
$course = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM courses WHERE course_id = $course_id"));
$modules_result = mysqli_query($conn, "SELECT * FROM modules WHERE course_id = $course_id ORDER BY module_order ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Lesson | SkillCert</title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>

  <style>
    body {
      background: #f5f7fa;
      font-family: "Poppins", sans-serif;
      min-height: 100vh;
      margin: 0;
      padding: 40px 20px;
    }

    .main-wrapper {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      width: 100%;
    }

    .card {
      background: #ffffff;
      border-radius: 20px;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 2rem 3rem;
      width: 100%;
      max-width: 1100px;
      transition: all 0.3s ease;
    }

    h3 {
      color: #c99700;
      font-weight: 700;
    }

    .btn-back {
      background-color: #000;
      color: #fff;
      border-radius: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-back:hover {
      background-color: #f4c542;
      transform: translateY(-2px);
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .form-select,
    .form-control {
      border: 2px solid #f4c542;
      border-radius: 10px;
      padding: 10px;
      transition: 0.2s;
    }

    .form-select:focus,
    .form-control:focus {
      border-color: #e0b134;
      box-shadow: 0 0 6px rgba(244, 197, 66, 0.4);
    }

    .btn-warning {
      background-color: #f4c542;
      color: #000;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      transition: 0.3s;
      padding: 10px;
    }

    .btn-warning:hover {
      background-color: #000000ff;
      transform: translateY(-2px);
      color: white;
    }

    @media (max-width: 768px) {
      .card {
        padding: 1.5rem;
      }

      h3 {
        font-size: 1.4rem;
        text-align: center;
      }

      .btn-back {
        width: 100%;
        text-align: center;
      }
    }
  </style>
</head>

<body>
  <div class="main-wrapper">
    <div class="card">
      <h3 class="mb-4 text-center">Add New Lesson to <?= htmlspecialchars($course['course_name']) ?></h3>

      <a href="lessons.php?course_id=<?= $course_id ?>" class="btn btn-back mb-4">
        ← Back to Lessons
      </a>

      <form id="lessonForm">
        <div class="mb-3">
          <label class="form-label">Select Module</label>
          <select name="module_id" class="form-select" required>
            <option value="">Select Module</option>
            <?php
            while ($m = mysqli_fetch_assoc($modules_result)) {
              $selected = $m['module_id'] == $module_id ? "selected" : "";
              echo "<option value='{$m['module_id']}' {$selected}>" . htmlspecialchars($m['module_title']) . "</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Lesson Title</label>
          <input type="text" name="lesson_title" class="form-control" placeholder="Enter lesson title..." required>
        </div>

        <div class="mb-3">
          <label class="form-label">Lesson Description</label>
          <textarea name="lesson_description" class="form-control" rows="3" placeholder="Lesson description..."></textarea>
        </div>

        <button type="submit" class="btn btn-warning w-100">Add Lesson</button>
      </form>
    </div>
  </div>

  <script>
    $('#lessonForm').on('submit', function(event) {
      event.preventDefault();

      $.ajax({
        url: 'save_lesson.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          var result = typeof response === 'string' ? JSON.parse(response) : response;

          if (result.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Saved!',
              text: result.message
            });
            $('#lessonForm')[0].reset();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: result.message
            });
          }
        },
        error: function() {
          Swal.fire('Error', 'Something went wrong', 'error');
        }
      });
    });
  </script>
</body>
</html>