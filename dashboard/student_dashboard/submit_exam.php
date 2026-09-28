<?php
include("../../config/db_conn.php");

$data = json_decode(file_get_contents("php://input"), true);
$exam_id = intval($data['exam_id']);
$user_id = $_SESSION['user_id'] ?? 0;
$answers = $data['answers'] ?? [];

if (!$exam_id || !$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// 1. Check if user already passed this exam before
$checkPassed = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT * FROM exam_results
    WHERE user_id = $user_id AND exam_id = $exam_id AND status = 'passed'
    LIMIT 1
"));
if ($checkPassed) {
    echo json_encode([
        'status' => 'already_passed',
        'message' => 'You already passed this exam. No need to retake it.'
    ]);
    exit;
}

// 2. Get all questions and calculate score
$qQuery = mysqli_query($conn, "SELECT question_id, correct_answer FROM exam_questions WHERE exam_id = $exam_id");
$total = mysqli_num_rows($qQuery);
$score = 0;
$questionDetails = [];

while ($q = mysqli_fetch_assoc($qQuery)) {
    $qid = $q['question_id'];
    $correct = strtoupper(trim($q['correct_answer']));
    $userAnswer = strtoupper(trim($answers[$qid] ?? ''));
    $isCorrect = ($userAnswer === $correct);

    if ($isCorrect) {
        $score++;
    }

    $questionDetails[] = [
        'question_id' => $qid,
        'your_answer' => $userAnswer ?: 'None',
        'correct_answer' => $correct,
        'is_correct' => $isCorrect
    ];
}

//  Calculate percentage & passing status
$percentage = ($total > 0) ? floor(($score / $total) * 100) : 0;
$status = ($percentage >= 75) ? 'passed' : 'failed';


$query = "
    INSERT INTO exam_results (exam_id, user_id, score, percentage, status, taken_at)
    VALUES ($exam_id, $user_id, $score, $percentage, '$status', NOW())
";

if (mysqli_query($conn, $query)) {
    $result_id = mysqli_insert_id($conn);

    // 5. Insert each answer into exam_answers table
    foreach ($questionDetails as $qd) {
        $qid = $qd['question_id'];
        $ua = ($qd['your_answer'] === 'None') ? null : $qd['your_answer'];
        $isCorrect = $qd['is_correct'] ? 1 : 0;

        mysqli_query($conn, "
            INSERT INTO exam_answers (result_id, question_id, selected_answer, is_correct)
            VALUES ($result_id, $qid, " . ($ua ? "'$ua'" : "NULL") . ", $isCorrect)
        ");
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Exam submitted successfully!',
        'redirect' => "exam_result.php?result_id=$result_id"
    ]);

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to save exam result: ' . mysqli_error($conn)
    ]);
}
?>
