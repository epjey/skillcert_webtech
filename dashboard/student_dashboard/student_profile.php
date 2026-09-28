<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");



?>

<style>
.card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    max-width: 1800px;
    margin: 3rem auto;
    text-align: center;
    }
    .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      margin: 1.5rem auto;
      display: block;
    }
    .form-control {
      border-radius: 0.5rem;
      padding: 0.6rem 0.8rem;
    }
    .btn-primary {
      border-radius: 0.5rem;
      padding: 0.5rem 1.25rem;
      font-weight: 500;
    }
    .btn-outline-secondary {
      border-radius: 0.5rem;
    }
  </style>
 <main id="main-content" class="container-fluid">
    <div class="container">
    <div class="card shadow-lg p-4">
      <form id="updateForm" action="update_account.php" method="POST" enctype="multipart/form-data">
        <!-- Avatar -->
        <img src="../../assets/maltese-portrait.jpg" alt="Avatar" id="avatarPreview" class="profile-img">
        <div>
          <label for="avatar" class="change-avatar-btn mt-2">Change Avatar</label>
          <input type="file" id="avatar" name="avatar" accept="image/*" hidden>
        </div>

        <h4 class="mb-1 mt-3" id="profileName">Your Name</h4>
        <p class="text-muted mb-4" id="userEmailPreview">user@example.com</p>
        <hr>

        <h5 class="mb-3">Account Settings</h5>
        <div class="row g-3 text-start px-2">
          <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" id="firstName" name="first_name" class="form-control" placeholder="First name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" id="lastName" name="last_name" class="form-control" placeholder="Last name" required>
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required>
          </div>
          <div class="col-12">
            <label class="form-label">Old Password</label>
            <input type="password" id="oldPassword" name="old_password" class="form-control" placeholder="Current password" required>
          </div>
          <div class="col-12">
            <label class="form-label">New Password</label>
            <input type="password" id="newPassword" name="new_password" class="form-control" placeholder="New password">
          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end">
          <button type="reset" class="btn btn-outline-secondary me-2">Cancel</button>
          <button type="submit" class="btn btn-warning">Save Changes</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Click avatar or label to open file picker
    document.getElementById('avatarPreview').addEventListener('click', () => {
      document.getElementById('avatar').click();
    });

    // Preview new avatar
    document.getElementById('avatar').addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (evt) => {
          document.getElementById('avatarPreview').src = evt.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>
 </main>