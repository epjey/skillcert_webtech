<?php include("../../config/db_conn.php");




?>

<h4 class="mb-3">Settings</h4>

<!-- Profile Settings Card -->
<div class="card shadow-sm mb-4">
  <div class="card-header">
    <h5 class="mb-0">Edit Profile</h5>
  </div>
  <div class="card-body">
    <form>
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" placeholder="Enter your first name">
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" placeholder="Enter your last name">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" placeholder="Enter your email">
      </div>

      <div class="mb-3">
        <label class="form-label">Profile Picture</label>
        <input type="file" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  </div>
</div>

<!-- Change Password Card -->
<div class="card shadow-sm mb-4">
  <div class="card-header">
    <h5 class="mb-0">Change Password</h5>
  </div>
  <div class="card-body">
    <form>
      <div class="mb-3">
        <label class="form-label">Current Password</label>
        <input type="password" class="form-control" placeholder="Enter current password">
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" class="form-control" placeholder="Enter new password">
      </div>
      <div class="mb-3">
        <label class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" placeholder="Confirm new password">
      </div>
      <button type="submit" class="btn btn-danger">Update Password</button>
    </form>
  </div>
</div>
