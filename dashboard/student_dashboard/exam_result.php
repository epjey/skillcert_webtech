<?php
include("../../config/db_conn.php");

if (!isset($_GET['result_id'])) {
    die("<h4 class='text-danger text-center mt-5'>Missing result_id!</h4>");
}

$result_id = intval($_GET['result_id']);
$user_id = $_SESSION['user_id'] ?? 0;

// Fetch exam result
$resultQuery = mysqli_query($conn, "
    SELECT r.*, e.exam_title, e.course_id
    FROM exam_results r
    JOIN exams e ON e.exam_id = r.exam_id
    WHERE r.result_id = $result_id AND r.user_id = $user_id
    LIMIT 1
");

if (!$resultQuery || mysqli_num_rows($resultQuery) == 0) {
    die("<h4 class='text-danger text-center mt-5'>Exam result not found!</h4>");
}

$result = mysqli_fetch_assoc($resultQuery);

// Fetch all answers with question details
$answersQuery = mysqli_query($conn, "
    SELECT ea.*, 
           eq.question_text, eq.option_a, eq.option_b, eq.option_c, eq.option_d, eq.correct_answer
    FROM exam_answers ea
    JOIN exam_questions eq ON eq.question_id = ea.question_id
    WHERE ea.result_id = $result_id
    ORDER BY eq.question_id ASC
");

$answers = [];
while ($row = mysqli_fetch_assoc($answersQuery)) {
    $answers[] = $row;
}

$totalQuestions = count($answers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Result | <?= htmlspecialchars($result['exam_title']); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body {
  background: #f4f4f8;
  font-family: 'Poppins', sans-serif;
  color: #333;
  padding: 40px 10px;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}
.result-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  padding: 40px 35px;
  width: 100%;
  max-width: 950px;
}
.result-card h2 {
  color: #d4af37;
  font-weight: 700;
}
.status-passed { color: #27ae60; font-weight: bold; font-size: 1.3rem; }
.status-failed { color: #e74c3c; font-weight: bold; font-size: 1.3rem; }
.summary {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  margin-bottom: 30px;
}
.summary div {
  margin: 10px 0;
  text-align: center;
}
.answer-row {
  background: #fff7e6;
  padding: 20px;
  border-radius: 15px;
  margin-bottom: 20px;
  border: 1px solid #ffd70033;
  transition: all 0.3s;
}
.answer-row:hover {
  background: #fff4cc;
  transform: translateY(-2px);
}
.answer-row p { margin-bottom: 8px; }
.correct { color: #27ae60; font-weight: bold; }
.wrong { color: #e74c3c; font-weight: bold; }
.btn-gold {
  background: linear-gradient(135deg, #d4af37, #f7d774);
  color: #000;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 12px 25px;
  transition: all 0.3s ease;
}
.btn-gold:hover {
  background: linear-gradient(135deg, #c19e34, #f5c94a);
  transform: translateY(-2px);
}
h4.summary-title {
  margin-bottom: 20px;
  color: #d4af37;
  font-weight: 600;
  border-bottom: 2px solid #ffd70066;
  padding-bottom: 5px;
}
</style>
</head>
<body>

<div class="result-card">
  <h2 class="text-warning mb-3"><i class="fa-solid fa-certificate"></i> <?= htmlspecialchars($result['exam_title']); ?></h2>

  <div class="summary">
    <div><strong>Total Questions:</strong><br><?= $totalQuestions ?></div>
    <div><strong>Correct Answers:</strong><br><?= $result['score'] ?></div>
    <div><strong>Percentage:</strong><br><?= $result['percentage'] ?>%</div>
    <div class="<?= $result['status'] === 'passed' ? 'status-passed' : 'status-failed'; ?>">
      <?= strtoupper($result['status']); ?>
    </div>
  </div>

  <?php if (!empty($answers)): ?>
    <h4 class="summary-title"><i class="fa-solid fa-list-check"></i> Question Review</h4>
    <?php foreach ($answers as $ans): 
        $isCorrect = $ans['is_correct'] ? 'correct' : 'wrong';

        $options = [
            'A' => $ans['option_a'],
            'B' => $ans['option_b'],
            'C' => $ans['option_c'],
            'D' => $ans['option_d']
        ];

        $userAnswerLetter = $ans['selected_answer'] ?? '';
        $correctLetter = $ans['correct_answer'];

        $userAnswerText = $options[$userAnswerLetter] ?? 'No Answer';
        $correctAnswerText = $options[$correctLetter] ?? '';
    ?>
      <div class="answer-row">
        <p><strong>Q:</strong> <?= htmlspecialchars($ans['question_text']); ?></p>
        <p><strong>Your Answer:</strong> <span class="<?= $isCorrect ?>"><?= htmlspecialchars($userAnswerText); ?></span></p>
        <p><strong>Correct Answer:</strong> <span class="correct"><?= htmlspecialchars($correctAnswerText); ?></span></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="text-center mt-4">
    <button class="btn btn-gold" onclick="window.location.href='course_management.php?course_id=<?= $result['course_id']; ?>'">
      <i class="fa-solid fa-arrow-left"></i> Back to Course
    </button>
  </div>
</div>

</body>
</html>
