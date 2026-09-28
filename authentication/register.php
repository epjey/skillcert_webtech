<?php
include("../config/db_conn.php");
$alert = "";
$alertSuccess = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name  = $_POST["last_name"];
    $email      = $_POST["email"];
    $password   = $_POST["password"];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result && $result->num_rows > 0) {
        $alert = "<div class='text-danger'>Email Already Registered!</div>";
    } else {
        $user_role   = "student";
        $user_status = "active"; 

        $insertUser = "INSERT INTO users (first_name, last_name, email, password, status, certificate_count) 
                       VALUES ('$first_name', '$last_name', '$email', '$password', '$user_status', 0)";
        
        if ($conn->query($insertUser) === TRUE) {
            $alertSuccess = true;
        } else {
            $alert = "<div class='text-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <script src="../libs/sweetalert2.min.css"></script>
  <title>Register Page</title>

  <style>
    body {
      transition: background-color 0.4s, color 0.4s;
    }

    .form-select:focus, .form-control:focus {
      border-color: goldenrod;
      box-shadow: 0 0 0 0.25rem rgba(218, 165, 32, 0.4);
    }
    .form-check-input:checked {
      background-color: goldenrod;
      border-color: goldenrod;
    }

    .btn-golden {
      background-color: goldenrod;
      border-color: goldenrod;
      color: #1f1f1f;
      box-shadow: 0 4px 10px rgba(218,165,32,0.6);
      border-radius: 10px;
      font-weight: 600;
      padding: 12px;
    }
    .btn-golden:hover {
      background-color: #caa000;
      color: white;
    }
    .btn-outline-golden {
      border: 2px solid goldenrod;
      border-radius: 10px;
      color: goldenrod;
      font-weight: 600;
      padding: 10px;
    }
    .btn-outline-golden:hover {
      background-color: goldenrod;
      color: white;
    }
    .link-golden {
      color: goldenrod;
      font-weight: 600;
      padding: 4px 8px;
      text-decoration: none;
    }
    .link-golden:hover {
      color: #caa000;
      text-decoration: underline;
    }
    .btn-outline-warning {
      border-color: goldenrod !important;
      color: goldenrod !important;
      font-weight: 600;
    }
    .btn-outline-warning:hover {
      background-color: goldenrod !important;
      color: white !important;
    }

    /* DARK MODE STYLES */
    body.dark-mode {
      background-color: #121212 !important;
      color: #e4e4e4 !important;
    }

    body.dark-mode .bg-white {
      background-color: #1f1f1f !important;
    }

    body.dark-mode .bg-light {
      background-color: #2b2b2b !important;
    }

    body.dark-mode .form-control {
      background-color: #2b2b2b !important;
      color: white !important;
      border-color: #555;
    }

    body.dark-mode .form-control:focus {
      background-color: #333 !important;
      color: white !important;
      border-color: goldenrod;
      box-shadow: 0 0 0 0.25rem rgba(218, 165, 32, 0.4);
    }

    body.dark-mode .text-muted {
      color: #bbbbbb !important;
    }

    body.dark-mode .btn-outline-warning {
      border-color: goldenrod !important;
      color: goldenrod !important;
    }

    #darkModeToggle {
      position: absolute;
      top: 20px;
      right: 30px;
      background-color: transparent;
      border: 2px solid goldenrod;
      color: goldenrod;
      border-radius: 8px;
      padding: 5px 12px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }
    #darkModeToggle:hover {
      background-color: goldenrod;
      color: white;
    }
  </style>
</head>

<body class="bg-white text-dark" style="font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;">



<div class="container my-5" style="max-width:1000px;">
  <div class="row shadow-lg rounded-4 overflow-hidden" style="min-height:600px;">
    
    <div class="col-md-6 d-none d-md-flex flex-column align-items-center justify-content-center bg-light text-center p-4">
      <img src="../assets/skillcert_logo.png" alt="Skillcert Logo" style="max-width:280px; margin-bottom:2rem;">
      <p class="fst-italic text-muted" style="max-width:350px;">"Love what you learn and knowledge will follow"</p>
      <footer class="fst-italic text-secondary">-Skillcert Team-</footer>
    </div>

    <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
      <h2 class="fw-bold text-center mb-2">Create your account</h2>
      <p class="text-muted text-center mb-4">Join Skillcert and start your free learning journey</p>

      <form action="register.php" method="POST">
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <input type="text" name="first_name" class="form-control form-control-lg" placeholder="First Name"
              value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
          </div>
          <div class="col-md-6">
            <input type="text" name="last_name" class="form-control form-control-lg" placeholder="Last Name"
              value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <input type="email" name="email" class="form-control form-control-lg" placeholder="Email address"
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
          <?php if (!empty($alert)) echo $alert; ?>
        </div>

        <div class="input-group mb-3">
          <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" minlength="8" required>
          <button class="btn btn-outline-warning" type="button" id="togglePassword">👁</button>
        </div>

        <!-- Terms -->
        <div class="form-check mb-4">
          <input type="checkbox" class="form-check-input" id="terms" required>
          <label for="terms" class="form-check-label">
            I agree to the <a href="#" id="showTerms" class="link-golden">Terms and Agreement</a>
          </label>
        </div>

        <button type="submit" class="btn btn-lg w-100 fw-bold btn-golden">Create Account</button>

        <div class="text-center mt-4">
          <small class="text-muted fw-semibold">Already have an account?</small><br>
          <a href="login.php" class="btn mt-2 w-100 btn-outline-golden">Sign in instead</a>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="termsModal" style="display:none;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">SkillCert Terms and Agreement</h5>
        <button type="button" class="btn-close" id="closeTerms"></button>
      </div>
      <div class="modal-body" style="text-align: justify;">
        <p>Welcome to <strong>SkillCert</strong>. By creating an account, enrolling in courses, or using our services, you agree to comply with the following Terms and Agreement.</p>
        <h6>1. Acceptance of Terms</h6>
        <p>By registering on SkillCert, you confirm that you have read, understood, and agreed to these terms.</p>
        <h6>2. User Roles and Responsibilities</h6>
        <ul>
          <li><strong>Admin</strong>: Manages users, creates courses, assigns instructors, and oversees certificates.</li>
          <li><strong>Instructor</strong>: Creates lessons, uploads content, prepares exams, and monitors performance.</li>
          <li><strong>Student</strong>: Enrolls in courses, completes lessons, takes exams, and earns certificates.</li>
        </ul>
        <h6>3. Certificates and Examination Rules</h6>
        <ul>
          <li>All exams are auto-graded, and certificates are generated instantly upon passing.</li>
          <li>Copy-paste is disabled during exams, and tab switching is monitored. Three (3) violations will dismiss the exam.</li>
        </ul>
        <h6>4. Gamification Features</h6>
        <p>XP, stamina, and leaderboards are included for engagement but do not replace exam grading.</p>
        <h6>5. Academic Integrity</h6>
        <p>Cheating, sharing answers, or misuse will result in suspension or certificate revocation.</p>
        <h6>6. Privacy and Data Usage</h6>
        <p>Your personal data is securely stored and only used within SkillCert. No third-party sharing.</p>
        <h6>7. Limitation of Liability</h6>
        <p>SkillCert is an educational project. We are not liable for downtime, technical issues, or misuse.</p>
        <h6>8. Agreement</h6>
        <p>By checking the box during registration, you agree to all the above terms.</p>
      </div>
    </div>
  </div>
</div>

<script src="../jquery.js/jquery-3.7.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../libs/sweetalert2.all.min.js"></script>

<script>
$(document).ready(function() {
  $("#togglePassword").on("click", function() {
    let passwordField = $("#password");
    if(passwordField.attr("type") === "password") {
      passwordField.attr("type", "text");
      $(this).html("👁️‍🗨️");
    } else {
      passwordField.attr("type", "password");
      $(this).html("👁");
    }
  });

  //  8 chaaractyer password
  $("#password").on("input", function() {
    let password = $(this).val();
    if (password.length < 8) {
      $(this).removeClass("is-valid").addClass("is-invalid");
    } else {
      $(this).removeClass("is-invalid").addClass("is-valid");
    }
  });

  //  Show/Hide Terms
  $("#showTerms").click(function(e) {
    e.preventDefault();
    $("#termsModal").fadeIn();
  });
  $("#closeTerms").click(function() {
    $("#termsModal").fadeOut();
  });

  // uto capitalize first/last name
  $("input[name='first_name'], input[name='last_name']").on("input", function () {
    let value = $(this).val();
    if (value.length > 0) {
      $(this).val(value.charAt(0).toUpperCase() + value.slice(1).toLowerCase());
    }
  });

 
  <?php if ($alertSuccess === true): ?>
  Swal.fire({
    icon: "success",
    title: "Registration Successful!",
    text: "You can now log in to your account.",
    confirmButtonColor: "goldenrod",
    confirmButtonText: "Go to Login"
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = "login.php";
    }
  });
  <?php endif; ?>
});
</script>
</body>
</html>
