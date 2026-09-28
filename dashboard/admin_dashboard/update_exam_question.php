<?php
include("../../config/db_conn.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $question_id = intval($_POST['question_id']);
    $question_text = mysqli_real_escape_string($conn, trim($_POST['question_text']));
    $choice_a = mysqli_real_escape_string($conn, trim($_POST['choice_a']));
    $choice_b = mysqli_real_escape_string($conn, trim($_POST['choice_b']));
    $choice_c = mysqli_real_escape_string($conn, trim($_POST['choice_c']));
    $choice_d = mysqli_real_escape_string($conn, trim($_POST['choice_d']));
    $correct_answer = mysqli_real_escape_string($conn, trim($_POST['correct_answer']));

    if($question_id && $question_text && $choice_a && $choice_b && $choice_c && $choice_d && $correct_answer){
        $query = "UPDATE exam_questions SET 
                    question_text='$question_text',
                    choice_a='$choice_a',
                    choice_b='$choice_b',
                    choice_c='$choice_c',
                    choice_d='$choice_d',
                    correct_answer='$correct_answer'
                  WHERE question_id=$question_id";

        if(mysqli_query($conn, $query)){
            echo json_encode(['status'=>'success','message'=>'Question updated successfully']);
        } else {
            echo json_encode(['status'=>'error','message'=>'Database error: '.mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status'=>'error','message'=>'Please fill all fields']);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}
?>
