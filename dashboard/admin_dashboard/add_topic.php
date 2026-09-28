<?php
include("../../config/db_conn.php");

if (!isset($_GET['lesson_id'])) {
  die("Missing lesson_id");
}


if (isset($_GET['lesson_id'])) {
  
  // Get the value from the URL
  $lesson_id_value = $_GET['lesson_id'];

  $lesson_id = intval($lesson_id_value);

} else {

  $lesson_id = 0;
}

$lesson = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lessons WHERE lesson_id = $lesson_id"));
if (!$lesson) die("Lesson not found");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Topics | <?= htmlspecialchars($lesson['lesson_title']) ?></title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <link href="../../summernote/summernote-lite.min.css" rel="stylesheet">
  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../summernote/summernote-lite.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>
</head>
<style>
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
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
}

.back-btn a:hover {
  color: #fff;
} 
</style>

<body class="bg-light">

<div class="container mt-5">
          <button class="back-btn" onclick="window.location.href='lessons.php?course_id=<?= $lesson['course_id'] ?>'">
            <i class="fa-solid fa-arrow-left"></i> Back to Lessons
          </button>

  <div class="card shadow-lg p-4 w-50 mx-auto">
    <h3 class="text-warning mb-4">Manage Topics for: <?= htmlspecialchars($lesson['lesson_title']) ?></h3>
    
    <form id="topicForm" enctype="multipart/form-data">
      <input type="hidden" name="lesson_id" value="<?= $lesson_id ?>">

      <div class="mb-3">
        <label class="form-label">Topic Title</label>
        <input type="text" name="topic_title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Topic Content</label>
        <textarea id="summernote" name="topic_content"></textarea>
      </div>

      <button type="submit" class="btn btn-warning w-100">Add Topic</button>
    </form>

    <hr>

    <h5>Existing Topics</h5>
    <ul class="list-group">
      <?php
      $topics = mysqli_query($conn, "SELECT * FROM lesson_topics WHERE lesson_id = $lesson_id ORDER BY topic_order ASC");
      while ($t = mysqli_fetch_assoc($topics)) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
          <span>" . htmlspecialchars($t['topic_title']) . "</span>
          <div>
            <button class='btn btn-sm btn-outline-primary edit-topic-btn'
                    data-id='{$t['topic_id']}'
                    data-title='" . htmlspecialchars($t['topic_title'], ENT_QUOTES) . "'
                    data-content='" . htmlspecialchars($t['topic_content'], ENT_QUOTES) . "'>
              Edit
            </button>
            <button class='btn btn-sm btn-outline-danger delete-topic-btn' 
                    data-id='{$t['topic_id']}' data-lesson='{$lesson_id}'>Delete</button>
          </div>
        </li>";
      }
      ?>
    </ul>
  </div>
</div>

<!-- EDIT TOPIC MODAL -->
<div class="modal fade" id="editTopicModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editTopicForm">
        <div class="modal-header">
          <h5 class="modal-title text-warning">Edit Topic</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="topic_id" id="edit_topic_id">

          <div class="mb-3">
            <label class="form-label">Topic Title</label>
            <input type="text" name="topic_title" id="edit_topic_title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Topic Content</label>
            <textarea id="edit_summernote" name="topic_content"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning">Update Topic</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../../js/bootstrap.bundle.min.js"></script>

<script>

function initSummernote(selector) {

  $(selector).summernote({
    placeholder: 'Write your topic content...',
    tabsize: 2,
    height: 250,

    // W
    callbacks: {
      onImageUpload: function (files) {
       
        for (var i = 0; i < files.length; i++) {
          uploadImage(files[i], this); // mag sesend ng file sa uploadiamage
        }
      }
    }
  });
}


function uploadImage(file, editor) {
  
  var data = new FormData();
  data.append('file', file); // attach the file with key 'file'

  // Send the file to PHP using AJAX
  $.ajax({
    url: 'upload_image.php',  
    method: 'POST',
    data: data,               // the FormData object
    contentType: false,        // do not set content type automatically
    processData: false,        // do not try to convert the FormData to text
    success: function (url) {
      // If upload is successful, insert the image into Summernote editor
      $(editor).summernote('insertImage', url);
    },
    error: function (xhr, status, error) {
      
      Swal.fire('Upload Failed', 'Could not upload image: ' + xhr.responseText, 'error');
    }
  });
}


initSummernote('#summernote');
initSummernote('#edit_summernote');




$('#topicForm').on('submit', function (e) {
  e.preventDefault(); 

  var formData = $(this).serialize(); // get all form inputs

  $.ajax({
    url: 'save_topic.php', 
    type: 'POST',
    data: formData, 
    success: function (response) {
      var res = JSON.parse(response); 
      if (res.status === 'success') {
        Swal.fire('Success', res.message, 'success').then(function () {
          location.reload();
        });
      } else {
        Swal.fire('Error', res.message, 'error');
      }
    },
    error: function () {
      Swal.fire('Error', 'Failed to save topic', 'error');
    }
  });
});




$('.edit-topic-btn').on('click', function () {

  var id = $(this).data('id');
  var title = $(this).data('title');
  var content = $(this).data('content');

  $('#edit_topic_id').val(id);
  $('#edit_topic_title').val(title);
  $('#edit_summernote').summernote('code', content);


  var modalElement = document.getElementById('editTopicModal');
  var modal = new bootstrap.Modal(modalElement);
  modal.show();
});




$('#editTopicForm').on('submit', function (e) {
  e.preventDefault();

  var formData = $(this).serialize(); // collect form inputs

  $.ajax({
    url: 'update_topic.php', 
    type: 'POST',
    data: formData,
    success: function (response) {
      var res = JSON.parse(response);
      if (res.status === 'success') {
        Swal.fire('Updated!', res.message, 'success').then(function () {
          location.reload();
        });
      } else {
        Swal.fire('Error', res.message, 'error');
      }
    },
    error: function () {
      Swal.fire('Error', 'Failed to update topic', 'error');
    }
  });
});




$(document).on('click', '.delete-topic-btn', function (e) {
  e.preventDefault();

  var button = $(this); 
  var topicId = button.data('id'); 

  Swal.fire({
    title: 'Are you sure?',
    text: 'This topic will be permanently deleted.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then(function (result) {
    if (result.isConfirmed) {
      $.ajax({
        url: 'delete_topic.php',
        type: 'POST',
        data: { topic_id: topicId },
        dataType: 'json',
        success: function (res) {
          if (res.status === 'success') {
         
            button.closest('li').fadeOut(400, function () {
              $(this).remove();
            });

            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: res.message,
              timer: 1000,
              showConfirmButton: false
            });
          } else {
            Swal.fire('Error', res.message, 'error');
          }
        },
        error: function () {
          Swal.fire('Error', 'Failed to delete topic', 'error');
        }
      });
    }
  });
});


</script>

</body>
</html>