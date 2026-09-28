<body style="background-color: #f8f9fa; font-family: 'Poppins', sans-serif;">
  <div class="container mt-5">
    <div class="card shadow-lg p-5" style="border-radius: 20px; border: none;">
      <h3 class="mb-4" style="color: #d4af37; font-weight: 600;"><i class="fa-solid fa-book fa-2xl" style="color: #daa520;"></i> Add New Course</h3>

      <form id="courseForm">
        <div class="mb-4">
          <label class="form-label fw-semibold text-dark">Course Name</label>
          <input type="text" name="course_name" class="form-control"
                 placeholder="Enter course name"
                 style="border-radius: 10px; border: 1px solid #ddd; transition: 0.3s;" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold text-dark">Course Description</label>
          <textarea name="description" class="form-control" rows="4"
                    placeholder="Brief description of the course"
                    style="border-radius: 10px; border: 1px solid #ddd; transition: 0.3s;"></textarea>
        </div>

        <button type="submit" 
                class="btn w-100 py-2"
                style="background-color: #d4af37; color: #fff; font-weight: 500; border-radius: 10px; transition: 0.3s;">
          Course Added
        </button>
      </form>
    </div>
  </div>


  <script src="../../jquery.js/jquery-3.7.1.min.js"></script>
  <script src="../../libs/sweetalert2.all.min.js"></script>

  <script>
    
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
      input.addEventListener('focus', () => {
        input.style.borderColor = '#d4af37';
        input.style.boxShadow = '0 0 5px rgba(212,175,55,0.4)';
      });
      input.addEventListener('blur', () => {
        input.style.borderColor = '#ddd';
        input.style.boxShadow = 'none';
      });
    });

   
    $('#courseForm').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: 'save_course.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
          Swal.fire({
            icon: response.status,
            title: response.status === 'success' ? 'Added!' : 'Error',
            text: response.message,
            confirmButtonColor: '#d4af37'
          });

          if (response.status === 'success') {
            $('#courseForm')[0].reset();
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong with the request.',
            confirmButtonColor: '#d4af37'
          });
        }
      });
    });
  </script>
</body>