<?php
include("../../config/db_conn.php");


if (isset($_GET['code'])) {
  $cert_code = mysqli_real_escape_string($conn, $_GET['code']);

  // Find certificate using code
  $certQuery = mysqli_query($conn, "
    SELECT c.*, u.first_name, u.last_name, cr.course_name
    FROM certificates c
    JOIN users u ON c.user_id = u.user_id
    JOIN courses cr ON c.course_id = cr.course_id
    WHERE c.certificate_code = '$cert_code'
    LIMIT 1
  ");

  // If no certificate found
  if (!$certQuery || mysqli_num_rows($certQuery) == 0) {
    die("<div class='error-box' style='text-align:center;margin-top:50px;color:goldenrod;'>
    <h1>Certificate Not Recognized</h1>
    <p style='font-size:20px; color: black'>The certificate code you entered does not exist in our system.</p>
  </div>");
  }

  // Get user and course info
  $cert = mysqli_fetch_assoc($certQuery);
  $user = [
    'first_name' => $cert['first_name'],
    'last_name' => $cert['last_name']
  ];
  $course = [
    'course_name' => $cert['course_name']
  ];
  $course_id = $cert['course_id'];

} else {
  // Fallback: Access by logged in user + course_id
  $user_id = $_SESSION['user_id'] ?? 0;

  if (!isset($_GET['course_id'])) {
    die("Missing course_id");
  }

  $course_id = intval($_GET['course_id']);
  $auto_issue = isset($_GET['auto_issue']) ? true : false;

  // Get user info
  $userQuery = mysqli_query($conn, "SELECT first_name, last_name FROM users WHERE user_id = $user_id");
  $user = mysqli_fetch_assoc($userQuery);

  // Get course info
  $courseQuery = mysqli_query($conn, "SELECT course_name FROM courses WHERE course_id = $course_id");
  $course = mysqli_fetch_assoc($courseQuery);

  // Check if a certificate already exists
  $certQuery = mysqli_query($conn, "
    SELECT certificate_code, issued_date 
    FROM certificates 
    WHERE user_id = $user_id AND course_id = $course_id
    LIMIT 1
  ");

  // If no certificate and auto_issue=1 → issue a new one
  if ((!$certQuery || mysqli_num_rows($certQuery) == 0) && $auto_issue) {
    $certificate_code = strtoupper(uniqid('CERT-'));
    $issued_date = date("Y-m-d");

    $insertCert = mysqli_query($conn, "
      INSERT INTO certificates (user_id, course_id, status, issued_date, certificate_code)
      VALUES ($user_id, $course_id, 'issued', '$issued_date', '$certificate_code')
    ");

    if (!$insertCert) {
      die("<h3 style='text-align:center;margin-top:50px;color:red;'>Failed to issue certificate: " . mysqli_error($conn) . "</h3>");
    }
    
    // Update certificate count
    $updateCount = mysqli_query($conn, "
      UPDATE users 
      SET certificate_count = certificate_count + 1 
      WHERE user_id = $user_id
    ");

    if (!$updateCount) {
      error_log('Failed to update certificate count for user_id ' . $user_id . ': ' . mysqli_error($conn));
    }
  
    
    // Fetch the new certificate
    $certQuery = mysqli_query($conn, "
      SELECT certificate_code, issued_date  
      FROM certificates 
      WHERE user_id = $user_id AND course_id = $course_id
      LIMIT 1
    ");
  }

  if (!$certQuery || mysqli_num_rows($certQuery) == 0) {
    die("<h3 style='text-align:center; margin-top:50px;'>No certificate available yet. Please complete the course first.</h3>");
  }

  $cert = mysqli_fetch_assoc($certQuery);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Certificate</title>
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    body {
      background-color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-family: 'Times New Roman', serif;
      margin: 0;
      padding: 30px;
    }
    .certificate-container {
      background: #fff;
      padding: 60px 80px;
      border: 8px double #d4af37;
      border-radius: 20px;
      width: 100%;
      max-width: 950px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }
    .certificate-header {
      font-size: 48px;
      font-weight: 700;
      color: #1b1e23;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .certificate-subtitle {
      font-size: 18px;
      color: #6b6b6b;
      margin-bottom: 40px;
      font-style: italic;
    }
    .certificate-body {
      font-size: 22px;
      color: #333;
      line-height: 1.8;
    }
    .certificate-body strong {
      color: #d4af37;
      font-size: 26px;
    }
    .signature {
      margin-top: 70px;
      font-size: 18px;
      color: #444;
    }
    .signature-line {
      width: 220px;
      height: 2px;
      background-color: #000;
      margin: 0 auto 10px;
    }
    .date {
      margin-top: 30px;
      font-size: 16px;
      color: #555;
    }
  </style>
</head>
<body>

  <button class="btn mb-3" style="border: 2px solid #d4af37;" onclick="window.location.href='student_dashboard.php'">
      <i class="fa-solid fa-arrow-left"></i> back to certificates
  </button>

<div class="certificate-container" id="certificate">
  <div class="certificate-header fs-1">Certificate of Completion</div>
  <div class="certificate-subtitle">This certificate is proudly presented to</div>

  <div class="certificate-body">
    <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></strong><br>
    for successfully completing the course<br>
    <strong><?= htmlspecialchars($course['course_name']); ?></strong>
  </div>

  <div class="signature">
    <span><strong>SkillCert Team</strong></span><br><br>
    <span>Certificate ID: <strong><?= htmlspecialchars($cert['certificate_code']); ?></strong></span><br>
    <span class="date">Issued on <?= date("F d, Y", strtotime($cert['issued_date'])); ?></span>
  </div>

  <div class="mt-5">
    <label for="verifyLink" class="fw-semibold">Verify this certificate at</label>
    <div class="input-group" style="max-width: 550px; margin: 0 auto;">
      <input type="text" 
            id="verifyLink" 
            class="form-control text-center border-0" 
            value="http://localhost/skillcertsystem/dashboard/student_dashboard/view_certificate.php?code=<?= urlencode($cert['certificate_code']); ?>" 
            readonly>
      <button class="btn " id="copyLinkBtn" style="border: 2px solid #daa520;">Copy</button>
    </div>
  </div>
</div>

<div class="download-btns mt-4">
  <button class="btn btn-danger" id="download-pdf"><i class="fa-solid fa-file-pdf fa-lg"></i> Download PDF</button>
  <button class="btn btn-secondary" id="download-img"><i class="fa-solid fa-image fa-lg"></i> Download Image</button>
</div>

<script>
document.getElementById("download-pdf").addEventListener("click", async () => {
  const { jsPDF } = window.jspdf;
  const pdf = new jsPDF("landscape", "pt", "a4");
  const element = document.getElementById("certificate");
  const canvas = await html2canvas(element, { scale: 2 });
  const imgData = canvas.toDataURL("image/png");
  const pdfWidth = pdf.internal.pageSize.getWidth();
  const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
  pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
  pdf.save("Certificate.pdf");
});

document.getElementById("download-img").addEventListener("click", async () => {
  const element = document.getElementById("certificate");
  const canvas = await html2canvas(element, { scale: 2 });
  const link = document.createElement("a");
  link.download = "Certificate.png";
  link.href = canvas.toDataURL("image/png");
  link.click();
});

document.getElementById("copyLinkBtn").addEventListener("click", () => {
  const linkInput = document.getElementById("verifyLink");
  linkInput.select();
  document.execCommand("copy");
});
</script>

</body>
</html>
