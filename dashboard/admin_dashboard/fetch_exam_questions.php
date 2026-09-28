<?php
include('../../config/db_conn.php');

if (!isset($_GET['exam_id'])) {
    echo "<div class='text-danger text-center mt-3'>Missing exam ID.</div>";
    exit;
}

$exam_id = intval($_GET['exam_id']);

// Fetch exam details (optional but nice to show)
$exam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM exams WHERE exam_id = $exam_id"));

$query = "SELECT * FROM exam_questions WHERE exam_id = $exam_id ORDER BY question_id ASC";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<div class='text-center text-muted mt-3'>No questions found for this exam.</div>";
    exit;
}
?>

<div class="container mt-3">
  <h5 class="text-center mb-3 text-warning">
    <i class="fa-solid fa-brain"></i>
    <?= htmlspecialchars($exam['exam_title']) ?>
  </h5>

  <table class="table table-bordered table-striped align-middle">
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
      $counter = 1;
      while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td class="text-center"><?= $counter++ ?></td>
          <td><?= htmlspecialchars($row['question_text']) ?></td>
          <td><?= htmlspecialchars($row['option_a']) ?></td>
          <td><?= htmlspecialchars($row['option_b']) ?></td>
          <td><?= htmlspecialchars($row['option_c']) ?></td>
          <td><?= htmlspecialchars($row['option_d']) ?></td>
          <td class="text-success fw-bold text-center"><?= htmlspecialchars($row['correct_answer']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>