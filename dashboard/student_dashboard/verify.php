<?php
include("../../../config/db_conn.php");

// Extract the certificate code from the URL
$requestedUri = $_SERVER['REQUEST_URI'];

// Example: /skillcertsystem/dashboard/student_dashboard/verify/CERT-66F5B7A3A6
$parts = explode('/', $requestedUri);
$certificate_code = end($parts);


$certificate_code = strtok($certificate_code, '?');

// Fetch certificate
$stmt = mysqli_prepare($conn, "
  SELECT c.certificate_code, c.issued_date, u.first_name, u.last_name, cs.course_name
  FROM certificates c
  JOIN users u ON c.user_id = u.user_id
  JOIN courses cs ON c.course_id = cs.course_id
  WHERE c.certificate_code = ?
  LIMIT 1
");
mysqli_stmt_bind_param($stmt, "s", $certificate_code);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
  echo "
  <div style='text-align:center;margin-top:100px;font-family:sans-serif;'>
    <h2 style='color:red;'> Certificate Code Not Recognized</h2>
    <p>This certificate code <b>$certificate_code</b> does not exist in our system.</p>
    <a href='/skillcertsystem/' style='color:#d4af37;text-decoration:none;'>Go back to homepage</a>
  </div>";
  exit;
}

$cert = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verified Certificate</title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .verified-box {
      background: #fff;
      border: 2px solid #d4af37;
      border-radius: 20px;
      padding: 50px;
      text-align: center;
      width: 700px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h1 {
      color: #1b1e23;
      margin-bottom: 20px;
    }
    .code {
      font-weight: bold;
      color: #d4af37;
      font-size: 20px;
    }
  </style>
</head>
<body>
  <div class="verified-box">
    <h1> Certificate Verified</h1>
    <p>This certificate belongs to:</p>
    <h3><?= htmlspecialchars($cert['first_name'] . ' ' . $cert['last_name']); ?></h3>
    <p>for successfully completing:</p>
    <h4><?= htmlspecialchars($cert['course_name']); ?></h4>
    <p>Issued on: <?= date("F d, Y", strtotime($cert['issued_date'])); ?></p>
    <p class="code">Certificate Code: <?= htmlspecialchars($cert['certificate_code']); ?></p>
  </div>
</body>
</html>
