<?php
include("../config/db_conn.php");

$emailAlert = "";
$passAlert  = "";

if (isset($_POST["email"])) {
    $email = $_POST["email"];
} else {
    $email = "";
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
} else {
    $password = "";
}

if (!empty($email) && !empty($password)) {
    $checkEmail = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = $conn->query($checkEmail);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password === $row["password"]) {

            if ($row["status"] !== "active") {
                if ($row["status"] === "banned") {
                    $emailAlert = "<div class='text-danger mb-2'>
                        Your account has been <b>banned</b>. Please contact support.
                    </div>";
                } else {
                    $emailAlert = "<div class='text-danger mb-2'>
                        Your account is not active. You cannot log in.
                    </div>";
                }
            } else {
                
                if (!empty($row["session_token"])) {
                    $emailAlert = "<div class='text-danger mb-2'>
                        You are already logged in on another device/browser.
                    </div>";
                } else {
                    session_regenerate_id(true);
                    $token = bin2hex(random_bytes(32));

                    $_SESSION["user_id"] = $row["user_id"];
                    $_SESSION["email"]   = $row["email"];
                    $_SESSION["role"]    = $row["role"];
                    $_SESSION["session_token"] = $token;

                    $_SESSION["first_name"] = $row["first_name"];
                    $_SESSION["last_name"]  = $row["last_name"];


                    $updateToken = "UPDATE users SET session_token = '$token' WHERE user_id = " . $row["user_id"];
                    $conn->query($updateToken);

                    if ($row["role"] === "student") {
                        header("Location: ../dashboard/student_dashboard/student_dashboard.php");
                        exit();
                    } elseif ($row["role"] === "admin") {
                        header("Location: ../dashboard/admin_dashboard/admin_dashboard.php");
                        exit();
                    }
                }
            }

        } else {
            $passAlert = "<div class='text-danger mb-2'>Incorrect password!</div>";
        }
    } else {
        $emailAlert = "<div class='text-danger mb-2'>No account found with that email.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <title>Login Page</title>

  <style>
    body {
      transition: background-color 0.4s, color 0.4s;
    }

    .form-check-input:checked {
      background-color: goldenrod;
      border-color: goldenrod;
    }
    .form-control:focus {
      border-color: goldenrod;
      box-shadow: 0 0 0 0.25rem rgba(218, 165, 32, 0.4);
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

    .link-golden {
      color: goldenrod;
      font-weight: 600;
      padding: 6px 10px;
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

    /* toggle button */
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
      <h2 class="fw-bold text-center mb-2">Welcome Back</h2>
      <p class="text-muted text-center mb-4">Let's start learning</p>

      <form action="login.php" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Enter your email"
            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
          <?php if(!empty($emailAlert)) echo $emailAlert; ?>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" minlength="8"
              value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required>
            <button class="btn btn-outline-warning" type="button" id="togglePassword">👁</button>
          </div>
          <?php if (!empty($passAlert)) echo $passAlert; ?>
        </div>

        <button type="submit" class="btn btn-lg w-100 fw-bold mt-4 btn-golden">Log In</button>
      </form>

      <div class="text-center mt-4">
        <a href="../landing/landing.php" class="link-golden">Back to main page</a> |
        <a href="register.php" class="link-golden">Create an account</a>
      </div>
    </div>
  </div>
</div>

<script src="../jquery.js/jquery-3.7.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  // Password show/hide
  $("#togglePassword").on("click", function() {
    let passwordField = $("#password");
    if (passwordField.attr("type") === "password") {
      passwordField.attr("type", "text");
      $(this).html("👁️‍🗨️");
    } else {
      passwordField.attr("type", "password");
      $(this).html("👁");
    }
  });

  

  localStorage.removeItem("lastPage");
});
</script>

</body>
</html>



