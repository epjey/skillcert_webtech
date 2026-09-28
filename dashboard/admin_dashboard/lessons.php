<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("admin");

// Validate course_id
if (!isset($_GET['course_id'])) {
    die("<h4 class='text-danger text-center mt-5'>Missing course_id in URL!</h4>");
}

$course_id = intval($_GET['course_id']);

// Fetch course info
$course_query = mysqli_query($conn, "SELECT * FROM courses WHERE course_id = $course_id");
$course = mysqli_fetch_assoc($course_query);
if (!$course) {
    die("<h4 class='text-danger text-center mt-5'>Course not found!</h4>");
}

// Fetch modules and related lessons + exams
$modules = [];
$modules_query = mysqli_query($conn, "SELECT * FROM modules WHERE course_id = $course_id ORDER BY module_order ASC");

while ($m = mysqli_fetch_assoc($modules_query)) {
    // Fetch lessons
    $lessons = [];
    $lesson_query = mysqli_query($conn, "SELECT * FROM lessons WHERE module_id = {$m['module_id']} ORDER BY lesson_id ASC");
    while ($l = mysqli_fetch_assoc($lesson_query)) {
        $lessons[] = $l;
    }
    $m['lessons'] = $lessons;

    // Fetch exams
    $exams = [];
    $exam_query = mysqli_query($conn, "SELECT * FROM exams WHERE module_id = {$m['module_id']} ORDER BY exam_id ASC");
    while ($e = mysqli_fetch_assoc($exam_query)) {
        $exams[] = $e;
    }
    $m['exams'] = $exams;

    $modules[] = $m;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($course['course_name']) ?> | Modules, Lessons & Exams</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
<script src="../../jquery.js/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
  background: #f5f7fa;
  font-family: "Poppins", sans-serif;
}
.header {
  margin-bottom: 2rem;
}
.header h3 {
  font-weight: 700;
  color: #222;
}
.header p {
  color: #666;
}
.module-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  padding: 30px;
  margin-bottom: 40px;
  transition: all 0.25s ease-in-out;
}

.module-title {
  font-size: 1.4rem;
  font-weight: 600;
  color: goldenrod;
}
.lesson-card, .quiz-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  padding: 20px;
  transition: all 0.2s ease-in-out;
  margin-bottom: 20px;
}
.lesson-card:hover, .quiz-card:hover {
  transform: translateY(-5px);
  background: #fffdf3;
}
.lesson-card h5, .quiz-card h5 {
  font-weight: 600;
  color: #222;
}
.lesson-actions, .quiz-actions {
  text-align: right;
}
.lesson-actions button, .quiz-actions button {
  border-radius: 8px;
  margin-left: 5px;
}
.back-btn {
  background: linear-gradient(135deg, #daa520, #b8860b);
  border: none;
  border-radius: 12px;
  padding: 10px 22px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
  display: inline-block;
}
.back-btn a {
  color: white;
  text-decoration: none;
  font-weight: 600;
  font-size: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.back-btn:hover {
  background: linear-gradient(135deg, #b8860b, #daa520);
  transform: translateY(-2px);
}
.fade-in {
  opacity: 0;
  animation: fadeIn 0.5s ease-in-out forwards;
}
@keyframes fadeIn {
  from {opacity:0; transform:translateY(10px);}
  to {opacity:1; transform:translateY(0);}
}
</style>
</head>
<body>

<div class="container my-5 fade-in">
  <div class="header">
    <h3>
      <i class="fa-brands fa-html5 fa-2xl" style="color: goldenrod;"></i>
      <?= htmlspecialchars($course['course_name']) ?>
    </h3>
    <p><?= htmlspecialchars($course['description']) ?></p>
    <button class="back-btn">
      <a href="admin_dashboard.php">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
      </a>
    </button>
  </div>

  <?php if (count($modules) > 0): ?>
    <?php foreach ($modules as $module): ?>
      <div class="module-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="module-title">
            <i class="fa-solid fa-book-open-reader" style="color: goldenrod;"></i>
            <?= htmlspecialchars($module['module_title']) ?>
          </div>
        </div>

        <!-- Add Buttons -->
        <a href="add_lesson.php?module_id=<?= $module['module_id'] ?>" class="btn btn-warning me-2" style="border:1px solid black">
          <i class="fa-solid fa-plus fa-lg"></i> Add Lesson
        </a>
        <a href="add_exam.php?module_id=<?= $module['module_id'] ?>" class="btn btn-success" style="border:1px solid black">
          <i class="fa-solid fa-brain fa-lg"></i> Add Exam
        </a>

        <!-- Lessons Section -->
        <?php if (count($module['lessons']) > 0): ?>
          <h6 class="mt-4 mb-3 text-dark">
            <i class="fa-solid fa-chalkboard-user fa-lg" style="color: goldenrod;"></i> Lessons
          </h6>
          <div class="row">
            <?php foreach ($module['lessons'] as $lesson): ?>
              <div class="col-md-4">
                <div class="lesson-card">
                  <div class="lesson-actions">
                    <button class="btn btn-sm edit-lesson"
                      data-id="<?= $lesson['lesson_id'] ?>"
                      data-title="<?= htmlspecialchars($lesson['lesson_title']) ?>"
                      data-desc="<?= htmlspecialchars($lesson['lesson_description']) ?>">
                      <i class="fa-solid fa-pen-to-square fa-2xl"></i>
                    </button>
                    <button class="btn btn-sm delete-lesson" data-id="<?= $lesson['lesson_id'] ?>">
                      <i class="fa-solid fa-trash-can fa-2xl"></i>
                    </button>
                  </div>
                  <h5><?= htmlspecialchars($lesson['lesson_title']) ?></h5>
                  <p><?= htmlspecialchars($lesson['lesson_description']) ?></p>
                  <a href="lessons_view.php?lesson_id=<?= $lesson['lesson_id'] ?>" class="btn btn-warning w-100 mb-2" style="border:1px solid black">
                    <i class="fa-solid fa-eye fa-xl"></i> View Topics
                  </a>
                  <a href="add_topic.php?lesson_id=<?= $lesson['lesson_id'] ?>" class="btn btn-outline-dark w-100">
                    <i class="fa-solid fa-gear fa-xl"></i> Manage Topics
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Exams Section -->
        <?php if (count($module['exams']) > 0): ?>
          <h6 class="mt-4 mb-3 text-dark">
            <i class="fa-solid fa-question-circle fa-lg" style="color: goldenrod;"></i> Exams
          </h6>
          <div class="row">
            <?php foreach ($module['exams'] as $exam): ?>
              <div class="col-md-4">
                <div class="quiz-card">
                  <div class="quiz-actions">
                    <button class="btn btn-sm view-questions" data-id="<?= $exam['exam_id'] ?>">
                      <i class="fa-solid fa-eye fa-xl"></i>
                    </button>
                    <button class="btn btn-sm delete-quiz" data-id="<?= $exam['exam_id'] ?>">
                      <i class="fa-solid fa-trash fa-xl"></i>
                    </button>
                  </div>
                  <h5><?= htmlspecialchars($exam['exam_title']) ?></h5>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="alert alert-info text-center">No modules added yet for this course.</div>
  <?php endif; ?>
</div>

<!--Exam Modal -->
<div class="modal fade" id="quizModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color: #daa520;">
        <h5 class="modal-title">Exam Questions</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){

  
  $('.delete-lesson').on('click', function(){
    const id = $(this).data('id');
    const card = $(this).closest('.col-md-4'); 

    Swal.fire({
      title: 'Delete this lesson?',
      text: 'This will delete all its topics.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it'
    }).then(res=>{
      if(res.isConfirmed){
        $.post('delete_lesson.php', {lesson_id:id}, function(r){
          const data = JSON.parse(r);
          if(data.status === 'success'){
            Swal.fire('Deleted!', data.message, 'success');
            card.fadeOut(400, function(){ $(this).remove(); });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        }).fail(()=>{
          Swal.fire('Error', 'Failed to delete lesson.', 'error');
        });
      }
    });
  });

  //  EDIT LESSON (still works the same)
  $('.edit-lesson').on('click', function(){
    const id = $(this).data('id');
    const title = $(this).data('title');
    const desc = $(this).data('desc');

    Swal.fire({
      title: 'Edit Lesson',
      html: `
        <input id="lessonTitle" class="swal2-input" value="${title}">
        <textarea id="lessonDesc" class="swal2-textarea">${desc}</textarea>
      `,
      showCancelButton: true,
      confirmButtonColor: '#d4af37',
      preConfirm: () => ({
        title: $('#lessonTitle').val(),
        desc: $('#lessonDesc').val()
      })
    }).then(result=>{
      if(result.isConfirmed){
        $.post('update_lesson.php', {
          lesson_id: id,
          lesson_title: result.value.title,
          lesson_description: result.value.desc
        }, function(r){
          const data = JSON.parse(r);
          if(data.status === 'success'){
            Swal.fire('Updated!', data.message, 'success');
            // Update text dynamically
            card.find('h5').text(result.value.title);
            card.find('p').text(result.value.desc);
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        });
      }
    });
  });

  //  VIEW EXAM QUESTIONS Di PA NAGANA
  $('.view-questions').on('click', function(){
    const examId = $(this).data('id');
    $('#quizModal .modal-body').html('<div class="text-center text-muted">Loading...</div>');
    $.get('fetch_exam_questions.php', { exam_id: examId }, function(data){
      $('#quizModal .modal-body').html(data);
      $('#quizModal').modal('show');
    }).fail(()=>{
      Swal.fire('Error', 'Failed to load questions.', 'error');
    });
  });

  //  DELETE EXAM — no page reload
  $('.delete-quiz').on('click', function(){
    const examId = $(this).data('id');
    const card = $(this).closest('.col-md-4'); 

    Swal.fire({
      title: 'Delete this exam?',
      text: 'All its questions will be permanently removed.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it'
    }).then(result=>{
      if(result.isConfirmed){
        $.post('delete_exam.php', { exam_id: examId }, function(r){
          const data = JSON.parse(r);
          if(data.status === 'success'){
            Swal.fire('Deleted!', data.message, 'success');
            card.fadeOut(400, function(){ $(this).remove(); });
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        }).fail(()=>{
          Swal.fire('Error', 'Failed to delete exam.', 'error');
        });
      }
    });
  });

});
</script>

</body>
</html>