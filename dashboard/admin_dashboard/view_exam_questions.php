<?php
include("../../config/db_conn.php");



if (!isset($_GET['exam_id'])) {
  die("Missing exam_id in URL.");
}

$exam_id = intval($_GET['exam_id']);
$sql = "SELECT * FROM exam_questions WHERE exam_id = $exam_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Exam Questions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <h3 class="mb-4 text-center">📄 Exam Questions</h3>

  <a href="admin_exams.php" class="btn btn-secondary mb-3">← Back to Exams</a>

  <table class="table table-bordered table-hover align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>#</th>
        <th>Question</th>
        <th>Option A</th>
        <th>Option B</th>
        <th>Option C</th>
        <th>Option D</th>
        <th>Correct Answer</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (mysqli_num_rows($result) > 0):
        $no = 1;
        while ($q = mysqli_fetch_assoc($result)):
      ?>
          <tr>
            <td class="text-center"><?= $no++; ?></td>
            <td><?= htmlspecialchars($q['question_text']); ?></td>
            <td><?= htmlspecialchars($q['option_a']); ?></td>
            <td><?= htmlspecialchars($q['option_b']); ?></td>
            <td><?= htmlspecialchars($q['option_c']); ?></td>
            <td><?= htmlspecialchars($q['option_d']); ?></td>
            <td class="text-center fw-bold text-success"><?= htmlspecialchars($q['correct_answer']); ?></td>
          </tr>
      <?php
        endwhile;
      else:
        echo "<tr><td colspan='7' class='text-center'>No questions found.</td></tr>";
      endif;
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
