<?php
include("../../config/db_conn.php");

$code = $_GET['code'] ?? '';

// If no code provided, just show input form
if (!$code) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificate Verifier</title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
      padding: 40px;
      text-align: center;
    }
    .verifier-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: 0 auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input {
      padding: 10px;
      width: 80%;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #d4af37;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="verifier-box">
  <h2>🔍 Certificate Verifier</h2>
  <form method="GET">
    <input type="text" name="code" placeholder="Enter certificate code..." required>
    <br>
    <button type="submit">Verify</button>
  </form>
</div>

</body>
</html>
<?php
  exit;
}

// Validate certificate code
$safe_code = mysqli_real_escape_string($conn, $code);
$query = mysqli_query($conn, "
  SELECT c.certificate_code, c.course_id, c.user_id
  FROM certificates c
  WHERE c.certificate_code = '$safe_code'
  LIMIT 1
");

if (mysqli_num_rows($query) > 0) {
  // Certificate exists — redirect to view_certificate
  $cert = mysqli_fetch_assoc($query);
  header("Location: view_certificate.php?course_id={$cert['course_id']}&verified=1");
  exit;
} else {
  // Certificate not found — redirect to invalid page
  header("Location: invalid_certificate.php");
  exit;
}
?>
