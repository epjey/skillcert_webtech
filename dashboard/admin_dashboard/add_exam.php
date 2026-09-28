<?php
include("../../config/db_conn.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exam_title'])) {
  $exam_title = mysqli_real_escape_string($conn, $_POST['exam_title']);

    if (isset($_POST['course_id'])) {
      $course_id = $_POST['course_id'];
      $course_id = (int)$course_id;
  } else {
      $course_id = 0;
  }

  if (isset($_POST['module_id'])) {
      $module_id = $_POST['module_id'];
      $module_id = (int)$module_id;
  } else {
      $module_id = 0;
  }


  $insert = "INSERT INTO exams (exam_title, course_id, module_id) 
             VALUES ('$exam_title', $course_id, $module_id)";
  mysqli_query($conn, $insert);
  $new_exam_id = mysqli_insert_id($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Exam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>

  <style>
    body {
      background: #f5f7fa;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }

    .exam-container {
      max-width: 1100px;
      margin: 40px auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 40px 50px;
    }

    .exam-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .exam-header i {
      color: #daa520;
      font-size: 40px;
    }

    .exam-header h3 {
      margin-top: 10px;
      font-weight: 700;
      color: #222;
    }

    label.form-label {
      font-weight: 600;
      color: #333;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      border: 1px solid #ddd;
      transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
    }

    .btn-primary {
        background-color: #000;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 10px 30px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: goldenrod;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-success {
      border-radius: 10px;
      padding: 10px 25px;
      font-weight: 600;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    table.dataTable {
      border-radius: 10px;
      overflow: hidden;
    }

    hr {
      margin: 40px 0;
      border-top: 2px solid #eee;
    }

    .btn-back {
    background-color: goldenrod;
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    padding: 12px 0;
    width: 100%;
    text-align: center;
    display: block;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .btn-back:hover {
    background-color: #000;
    color: #fff;
    transform: translateY(-2px);
  }

    @media (max-width: 768px) {
      .exam-container {
        padding: 25px 20px;
      }
    }
  </style>
<body class="bg-light">

<div class="exam-container">
  <div class="exam-header">
    <i class="fa-regular fa-pen-to-square"></i>
    <h3>Add Exam</h3>
    <p style="color:#666;">Create a new exam and attach it to a course and module</p>
  </div>

  <!-- Add Exam Form -->
  <form method="POST" enctype="multipart/form-data" id="examForm">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Exam Title</label>
        <input type="text" name="exam_title" class="form-control" required>
      </div>

      <div class="col-md-3">
        <label class="form-label">Course</label>
        <select name="course_id" id="courseSelect" class="form-select" required>
          <option value="">-- Select Course --</option>
          <?php
              $query = "SELECT * FROM courses ORDER BY course_name ASC";
              $courses = mysqli_query($conn, $query);
              if ($courses) {
                while ($c = mysqli_fetch_assoc($courses)) {
                  echo "<option value='{$c['course_id']}'>{$c['course_name']}</option>";
                }
              } else {
                echo "<option disabled>Error loading courses</option>";
              }
          ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Module</label>
        <select name="module_id" id="moduleSelect" class="form-select" required>
          <option value="">-- Select Module --</option>
        </select>
      </div>
    </div>

    <div class="mt-4 text-center">
      <button type="submit" class="btn btn-primary px-4"><i class="fas fa-plus me-2"></i>Create Exam</button>
    </div>
  </form>
      <?php if (isset($new_exam_id)): ?>
        <a href="lessons.php?course_id=<?= $course_id ?>" class="btn btn-back mb-4 mt-4">
          ← Back to Lessons
        </a>
      <?php endif; ?>
  <hr>

  <!-- Upload CSV -->
  <?php if (isset($new_exam_id)): ?>
  <div class="card p-4 mt-4">
    <h5 class="mb-3"><i class="fa-solid fa-upload fa-xl" style="color: #daa520;"></i> Upload CSV for: <?= htmlspecialchars($_POST['exam_title']) ?></h5>
    <form method="POST" enctype="multipart/form-data" id="csvUploadForm">
      <input type="hidden" name="exam_id" value="<?= $new_exam_id ?>">
      <div class="mb-3">
        <input type="file" name="csv_file" accept=".csv" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success"><i class="fas fa-file-upload me-2"></i>Upload CSV</button>
    </form>
    <div id="csvMessage" class="mt-3"></div>
  </div>

  <div class="mt-4">
    <h5><i class="fa-regular fa-file-lines fa-xl" style="color: #daa520;"></i> Exam Questions</h5>
    <table class="table table-bordered" id="questionsTable">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Question</th>
          <th>A</th>
          <th>B</th>
          <th>C</th>
          <th>D</th>
          <th>Correct</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<script>
$(document).ready(function() {

 
  $('#courseSelect').on('change', function() {


    var courseID = $(this).val();


    if (courseID === '') {
      $('#moduleSelect').html('<option value="">-- Select Module --</option>');
      return; 
    }

    // Send AJAX request 
    $.ajax({
      url: 'fetch_modules.php', // mag bibigay ng module
      type: 'GET',          
      data: {
        course_id: courseID,    
        format: 'dropdown'     
      },
      success: function(data) {
        // Fill the module dropdown with the data returned by PHP
        $('#moduleSelect').html(data);
      },
      error: function() {
        alert('Failed to load modules.');
      }
    });
  });


  // Handle the CSV upload form submission
  $('#csvUploadForm').on('submit', function(event) {

    event.preventDefault();


    var formData = new FormData(this);

    // Get the exam ID from a hidden input field
    var examID = $('input[name="exam_id"]').val();


    $.ajax({
      url: 'upload_exam_csv.php?exam_id=' + $('input[name=exam_id]').val(), // Pass exam ID in URL
      type: 'POST',         
      data: formData,        
      processData: false,     
      contentType: false,   
      success: function(response) {
        
        $('#csvMessage').html(response);

     
        loadQuestions();
      },
      error: function() {
      
        alert('Error uploading CSV file.');
      }
    });
  });


  
  function loadQuestions() {
    var examID = $('input[name="exam_id"]').val();

    
    $.ajax({
      url: 'fetch_exam_questions.php', 
      type: 'GET',                  
      data: { exam_id: examID },     
      success: function(data) {
        
        $('#questionsTable tbody').html(data);

        $('#questionsTable').DataTable();
      },
      error: function() {
        alert('Error loading questions.');
      }
    });
  }


  if (typeof new_exam_id !== 'undefined' && new_exam_id !== null) {
    loadQuestions();
  }

});

</script>

</body>
</html>