<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");


$user_id = intval($_SESSION['user_id']);

//  Total certificates
$certQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_certs FROM certificates WHERE user_id = $user_id");
$certData = mysqli_fetch_assoc($certQuery);
$certificate_count = $certData['total_certs'] ?? 0;


$testQuery = mysqli_query($conn, "
  SELECT er.exam_id, e.total_items, er.score
  FROM exam_results AS er
  JOIN exams AS e ON er.exam_id = e.exam_id
  WHERE er.user_id = $user_id
");
if (!$testQuery) {
  die("Query failed: " . mysqli_error($conn));
}

//  Calculate proper average
$avgQuery = mysqli_query($conn, "
  SELECT 
    ROUND(AVG((er.score / e.total_items) * 100), 2) AS avg_percentage
  FROM exam_results AS er
  INNER JOIN exams AS e ON er.exam_id = e.exam_id
  WHERE er.user_id = $user_id
");

$avgData = mysqli_fetch_assoc($avgQuery);
$average_score = isset($avgData['avg_percentage']) && $avgData['avg_percentage'] !== null
  ? $avgData['avg_percentage']
  : 0;



//  Certificate list
$certListQuery = mysqli_query($conn, "
  SELECT c.certificate_code, c.issued_date, c.course_id, co.course_name
  FROM certificates AS c
  LEFT JOIN courses AS co ON c.course_id = co.course_id
  WHERE c.user_id = $user_id
  ORDER BY c.issued_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>My Certifications</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
  <style>

  #main-content {
    width: 100%;
    padding-top: 10px;
    display: flex;
    justify-content: center;
  }

  .certifications-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px;
    box-sizing: border-box;
  }

  .certifications-card h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    color: #1b1e23;
    margin-bottom: 10px;
  }
  .certifications-card h4 i { 
    color: #daa520; 
  }
  .certifications-card p.text-muted { 
    font-size: 16px; 
    margin-bottom: 25px; 
  }
  .cert-stats .card {
    border: 1px solid #f1f1f1;
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .cert-stats .card:hover { 
    transform: translateY(-3px); 
    box-shadow: 0 6px 18px rgba(0,0,0,0.08); 
  }
  .cert-item { 
    border-radius: 10px; 
    transition: transform 0.3s ease; 
  }
  .cert-item:hover { 
    transform: scale(1.01); 
  }
  .cert-item .d-flex i { 
    color: #daa520; 
  }
  .cert-item p { 
    font-size: 15px; 
  }

  /* Responsive */
  @media (max-width: 992px) {
    .certifications-card { 
      padding: 25px; 
      max-width: 95%; 
    }
    .cert-stats .card { 
      padding: 15px; 
    }
  }
  @media (max-width: 576px) {
    body { 
      padding: 80px 0 30px; 
    }
    .certifications-card { 
      padding: 20px; 
      border-radius: 10px; 
      width: 100%; 
      margin: 0; 
      box-shadow: none; 
    }
    .cert-item { 
      padding: 15px; 
    }
    .certifications-card h4 { 
      font-size: 18px; }
    .certifications-card p.text-muted { 
      font-size: 14px; }
  }
  body {
    background: #fff;
    min-height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 90px 10px 50px;
    box-sizing: border-box;
  }
  </style>
</head>
<body>
<main id="main-content"  class="container-fluid my-5">
  <div class="certifications-card shadow-lg">
    <h4><i class="fa-solid fa-code fa-2xl"></i> My Certifications</h4>
    <p class="text-muted">View and manage your earned certifications</p>

    <!-- Stats -->
    <div class="row justify-content-center g-4 mb-4 cert-stats">
      <div class="col-10 col-md-5 col-lg-4">
        <div class="card shadow-sm p-3 h-100 text-center">
          <h6 class="fw-bold">Total Certifications</h6>
          <h3 class="fw-bold"><?php echo intval($certificate_count); ?></h3>
          <small class="text-muted">Successfully completed certifications</small>
        </div>
      </div>

      <div class="col-10 col-md-5 col-lg-4">
        <div class="card shadow-sm p-3 h-100 text-center">
          <h6 class="fw-bold">Average Score</h6>
          <h3 class="fw-bold text-black"><?php echo htmlspecialchars($average_score); ?>%</h3>
          <small class="text-muted">Overall Avg Scores</small>
        </div>
      </div>
    </div>

    <!-- Certificate List -->
    <h5 class="fw-bold mb-3">Earned Certificates</h5>

    <?php if ($certListQuery && mysqli_num_rows($certListQuery) > 0): ?>
      <?php while ($cert = mysqli_fetch_assoc($certListQuery)): ?>
        <div class="card shadow-sm p-3 mb-3 cert-item">
          <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
              <i class="fa-solid fa-award fa-2xl"></i>
              <h5 class="fw-bold"><?php echo htmlspecialchars($cert['course_name']); ?></h5>
            </div>

            <span class="badge bg-success">Completed</span>
          </div>

          <p class="text-muted mt-5">
            Certificate Code: <b><?php echo htmlspecialchars($cert['certificate_code']); ?></b><br>
            Issued on: <?php echo htmlspecialchars(date("F d, Y", strtotime($cert['issued_date']))); ?>
          </p>

          <div class="text-end">
            <a href="view_certificate.php?course_id=<?php echo intval($cert['course_id']); ?>&certificate_code=<?php echo urlencode($cert['certificate_code']); ?>" class="btn btn-outline-success btn-sm">View Certificate</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="alert alert-warning text-center">You haven't earned any certificates yet.</div>
    <?php endif; ?>
  </div>
</main>

<script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
