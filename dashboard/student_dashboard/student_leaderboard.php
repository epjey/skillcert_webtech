<?php
include("../../config/db_conn.php");

include("../../authentication/auth_check.php");
requireRole("student");



// Fetch all students with role 'student' and active status
$studentsQuery = mysqli_query($conn, "
    SELECT user_id, first_name, last_name
    FROM users
    WHERE role = 'student' AND status = 'active'
");

$students = [];
while ($student = mysqli_fetch_assoc($studentsQuery)) {
    $user_id = $student['user_id'];

    // Total certifications
    $certQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_certs FROM certificates WHERE user_id = $user_id");
    $certData = mysqli_fetch_assoc($certQuery);
    $certificate_count = intval($certData['total_certs'] ?? 0);

    // Average score
    $avgQuery = mysqli_query($conn, "
        SELECT ROUND(AVG((er.score / e.total_items) * 100), 2) AS avg_percentage
        FROM exam_results AS er
        INNER JOIN exams AS e ON er.exam_id = e.exam_id
        WHERE er.user_id = $user_id
    ");
    $avgData = mysqli_fetch_assoc($avgQuery);
    $average_score = isset($avgData['avg_percentage']) && $avgData['avg_percentage'] !== null
        ? $avgData['avg_percentage']
        : 0;

    // Only include students who have at least one cert or at least one exam
    if ($certificate_count > 0 || $average_score > 0) {
        $students[] = [
            'name' => $student['first_name'] . ' ' . $student['last_name'],
            'cert_count' => $certificate_count,
            'avg_score' => $average_score
        ];
    }
}


// Sort by certificate count descending, then average score descending
usort($students, function($a, $b) {
    if ($b['cert_count'] == $a['cert_count']) {
        return $b['avg_score'] <=> $a['avg_score'];
    }
    return $b['cert_count'] <=> $a['cert_count'];
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Leaderboard</title>
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link href="../../fontawesome-free-7.1.0-web/css/all.min.css" rel="stylesheet">
<link href="../../DataTables/jquery.dataTables.min.css" rel="stylesheet">
<style>
body {
    min-height: 100vh;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

#main-content {
    padding-top: 80px; 
    padding-bottom: 40px;
}

.content-wrapper {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    max-width: 1800px;
    margin: 0 auto;
}

.leaderboard-header {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: flex-start;
}

.leaderboard-header i {
    color: #daa520;
    font-size: 34px;
}

.leaderboard-header h2 {
    margin: 0;
    font-weight: bold;
    color: #1b1e23;
}

.leaderboard-subtitle {
    color: #555;
    font-size: 15px;
    margin-top: 5px;
}

.search-bar {
    border: 1.5px solid #daa520;
    border-radius: 8px;
    padding: 10px 14px;
    width: 100%;
    font-size: 15px;
    margin: 15px 0 25px 0;
}

.table-responsive {
    overflow-x: auto;
}

#leaderboardTable {
    width: 100%;
    border-collapse: collapse;
    font-size: 16px;
    color: #1b1e23;
}

th {
    background-color: #1b1e23;
    color: #daa520;
}

th, td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
}

#leaderboardTable th:nth-child(2),
#leaderboardTable td:nth-child(2) {
    text-align: left;
    padding-left: 18px;
}

#leaderboardTable td i {
    margin-right: 6px;
    vertical-align: middle;
}

#leaderboardTable tbody tr:hover {
    font-weight: bold;
    cursor: pointer;
    transition: color 0.4s ease;
}

.dataTables_paginate {
    margin-top: 15px !important;
    text-align: right;
}

.dataTables_paginate a {
    border: 1px solid #daa520;
    border-radius: 4px;
    padding: 5px 9px;
    margin: 0 3px;
    color: #000 !important;
    text-decoration: none;
}

.dataTables_paginate a:hover,
.dataTables_paginate .current {
    background: #daa520;
    color: #fff !important;
}

.dataTables_length select {
    padding: 4px 8px;
    border: 1px solid #daa520;
    border-radius: 4px;
    background-color: #fff;
    color: #000;
}

@media (max-width: 992px) {
    #main-content {
        padding-top: 80px;
    }

    .content-wrapper {
        padding: 25px;
        margin: 20px;
    }

    .leaderboard-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .leaderboard-header i {
        font-size: 28px;
    }

    .leaderboard-header h2 {
        font-size: 22px;
    }

    #leaderboardTable {
        font-size: 15px;
    }
}

@media (max-width: 576px) {
    #main-content {
        padding-top: 70px;
    }

    .content-wrapper {
        width: 100%;
        margin: 0;
        border-radius: 10px;
        padding: 15px;
    }

    .leaderboard-header h2 {
        font-size: 20px;
    }

    .leaderboard-header i {
        font-size: 24px;
    }

    .search-bar {
        font-size: 14px;
        padding: 8px 10px;
    }

    th, td {
        padding: 8px;
        font-size: 13px;
    }

    #leaderboardTable {
        min-width: 500px;
    }
}
</style>
</head>
<body>
<main id="main-content" class="container-fluid my-5">
  <div class="content-wrapper card shadow-lg px-4 py-4">
    <div class="leaderboard-header mb-2">
      <i class="fa-solid fa-trophy fa-2xl"></i>
      <h2 class="fw-bold">Leaderboard</h2>
    </div>
    <p class="leaderboard-subtitle mb-4">See how you rank among other students.</p>

    <input type="text" id="searchInput" class="search-bar" placeholder="Search users...">

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="leaderboardTable">
        <thead>
          <tr>
            <th>Rank</th>
            <th>User</th>
            <th>Certifications</th>
            <th>Avg. Score</th>
          </tr>
        </thead>
        <tbody>
              <?php 
              $rank = 1;
              foreach ($students as $stu): ?>
                  <tr>
                      <td>
                        <span style="display: inline-flex; align-items: center; justify-content: center; gap: 4px;">
                          <?php 
                          if ($rank == 1) echo '<i class="fa-solid fa-trophy fa-beat fa-xl" style="color: #daa520;"></i>';
                          elseif ($rank == 2) echo '<i class="fa-solid fa-medal fa-xl fa-beat" style="color: #c0c0c0;"></i>';
                          elseif ($rank == 3) echo '<i class="fa-solid fa-medal fa-xl fa-beat" style="color: #cd7f32;"></i>';
                          else echo '<i style="width: 24px;"></i>'; 
                          ?>
                          #<?= $rank ?>
                        </span>
                      </td>

                      <td><?= htmlspecialchars($stu['name']); ?></td>
                      <td><i class="fa-solid fa-award fa-lg" style="color: #daa520;"></i> <?= $stu['cert_count'] ?></td>
                      <td><?= $stu['avg_score'] ?>%</td>
                  </tr>
              <?php $rank++; endforeach; ?>
          </tbody>
      </table>
    </div>
  </div>
</main>

<script src="../../jquery.js/jquery-3.7.1.min.js"></script>
<script src="../../DataTables/jquery.dataTables.min.js"></script>
<script>
$("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#leaderboardTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

$(document).ready(function () {
    if (!$.fn.DataTable.isDataTable('#leaderboardTable')) {
        $('#leaderboardTable').DataTable({
            paging: true,
            lengthMenu: [10, 15, 25, 50],
            searching: false,
            info: false,
            ordering: false,
        });
    }
});
</script>
</body>
</html>
