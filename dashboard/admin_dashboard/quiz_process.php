<?php
include("../../config/db_conn.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;
if ($user_id == 0) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}


if (!isset($_POST['exam_id']) || !isset($_POST['answers'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing exam data.']);
    exit;
}

$exam_id = intval($_POST['exam_id']);
$answers = $_POST['answers']; 

// Fetch exam info
$exam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT exam_id, course_id, module_id, passing_score, total_items FROM exams WHERE exam_id = $exam_id"));
if (!$exam) {
    echo json_encode(['status' => 'error', 'message' => 'Exam not found.']);
    exit;
}

$passing_score = $exam['passing_score'];
$total_items = $exam['total_items'];

// Fetch correct answers
$questions = mysqli_query($conn, "SELECT question_id, correct_answer FROM questions WHERE exam_id = $exam_id");

$correct_count = 0;
$wrong_answers = [];

while ($q = mysqli_fetch_assoc($questions)) {
    $qid = $q['question_id'];
    $correct = strtoupper(trim($q['correct_answer']));
    $user_answer = isset($answers[$qid]) ? strtoupper(trim($answers[$qid])) : null;

    if ($user_answer === $correct) {
        $correct_count++;
    } else {
        $wrong_answers[] = [
            'question_id' => $qid,
            'your_answer' => $user_answer ?: 'No Answer',
            'correct_answer' => $correct
        ];
    }
}

$percentage = ($correct_count / $total_items) * 100;
$passed = $percentage >= $passing_score ? 1 : 0;


$stmt = $conn->prepare("INSERT INTO exam_results (exam_id, user_id, score, percentage, passed) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiidi", $exam_id, $user_id, $correct_count, $percentage, $passed);
$stmt->execute();
$stmt->close();


if ($passed) {
    
    $next_module = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT module_id 
        FROM modules 
        WHERE course_id = {$exam['course_id']} AND module_order > (
            SELECT module_order FROM modules WHERE module_id = {$exam['module_id']}
        ) 
        ORDER BY module_order ASC LIMIT 1
    "));

    if ($next_module) {
        
        mysqli_query($conn, "
            INSERT INTO module_progress (user_id, module_id, unlocked) 
            SELECT $user_id, {$next_module['module_id']}, 1 
            WHERE NOT EXISTS (
                SELECT 1 FROM module_progress WHERE user_id = $user_id AND module_id = {$next_module['module_id']}
            )
        ");
    }
}


mysqli_query($conn, "
    INSERT INTO module_progress (user_id, module_id, unlocked, completed) 
    VALUES ($user_id, {$exam['module_id']}, 1, $passed)
    ON DUPLICATE KEY UPDATE completed=$passed, unlocked=1
");


$response = [
    'status' => 'success',
    'message' => 'Quiz processed successfully.',
    'score' => $correct_count,
    'total' => $total_items,
    'percentage' => round($percentage, 2),
    'passed' => $passed,
    'wrong_answers' => $wrong_answers
];

echo json_encode($response);
exit;
