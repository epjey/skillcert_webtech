<?php
include("../../config/db_conn.php");



if (!isset($_GET['exam_id'])) {
  die("<h4 class='text-danger text-center mt-5'>Missing exam_id!</h4>");
}

$exam_id = intval($_GET['exam_id']);
$user_id = $_SESSION['user_id'] ?? 0;

// Get exam info
$examQuery = mysqli_query($conn, "SELECT * FROM exams WHERE exam_id = $exam_id");
$exam = mysqli_fetch_assoc($examQuery);
if (!$exam) die("<h4 class='text-danger text-center mt-5'>Exam not found!</h4>");
$course_id = $exam['course_id'];

// Get questions
$questionsQuery = mysqli_query($conn, "SELECT * FROM exam_questions WHERE exam_id = $exam_id ORDER BY question_id ASC");
$questions = [];
while ($row = mysqli_fetch_assoc($questionsQuery)) $questions[] = $row;
$total = count($questions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($exam['exam_title']); ?> | Exam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
body {
  background: linear-gradient(to bottom right, #fff, #f9f9f9);
  font-family: 'Inter', sans-serif;
  padding: 40px 20px;
}
.exam-container {
  max-width: 700px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
  padding: 40px 30px;
  margin: auto;
}
.exam-header {
  border-bottom: 2px solid #f1c40f;
  padding-bottom: 10px;
  margin-bottom: 25px;
}
.exam-header h3 {
  color: #d4af37;
  font-weight: 700;
}
.exam-progress {
  height: 8px;
  border-radius: 8px;
  background: #eee;
  overflow: hidden;
  margin-bottom: 20px;
}
.exam-progress .bar {
  background: #d4af37;
  height: 100%;
  width: 0%;
  transition: width 0.3s;
}
.option-btn {
  width: 100%;
  text-align: left;
  border: 2px solid #ddd;
  border-radius: 10px;
  padding: 12px 16px;
  background: #fff;
  margin-bottom: 12px;
  transition: all 0.25s ease;
  font-weight: 500;
}
.option-btn:hover {
  border-color: #d4af37;
  background: #fff7dc;
}
.option-btn.active {
  border-color: #d4af37;
  background: #fdf4c5;
}
.btn-gold {
  background-color: #d4af37;
  color: #000;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
}
.btn-gold:hover {
  background-color: #c19e34;
  color: #000;
}
.nav-btns {
  display: flex;
  justify-content: space-between;
  margin-top: 25px;
}
.small-info {
  text-align: right;
  color: #777;
  font-size: 0.9rem;
}
</style>
</head>
<body>

<div class="exam-container">
  <div class="exam-header">
    <h3><?= htmlspecialchars($exam['exam_title']); ?></h3>
    <p class="small-info">Question <span id="currentNum">1</span> of <?= $total ?></p>
    <div class="exam-progress">
      <div class="bar" id="progressBar"></div>
    </div>
  </div>

  <div id="questionContainer"></div>

  <div class="nav-btns">
    <button id="prevBtn" class="btn btn-outline-secondary" disabled>← Previous</button>
    <button id="nextBtn" class="btn btn-gold">Next →</button>
  </div>

  
</div>

<script>
const questions = <?= json_encode($questions) ?>;
let current = 0;
let answers = {};

function escapeHTML(text) {
  if (!text) return '';
  return text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function renderQuestion() {
  const q = questions[current];
  let html = `<h5 class="mb-3">${escapeHTML(q.question_text)}</h5>`;
  
  ["A", "B", "C", "D"].forEach(letter => {
    const option = q[`option_${letter.toLowerCase()}`];
    if (option) {
      html += `
        <button class="option-btn ${answers[q.question_id]===letter?"active":""}" 
          onclick="selectOption('${letter}', ${q.question_id}, this)">
          ${escapeHTML(option)}
        </button>`;
    }
  });
  
  document.getElementById("questionContainer").innerHTML = html;
  document.getElementById("prevBtn").disabled = current === 0;
  document.getElementById("nextBtn").innerText = current === questions.length - 1 ? "Submit Exam" : "Next →";
  updateProgress();
}

function selectOption(value, qid, btn) {
  answers[qid] = value;
  document.querySelectorAll(".option-btn").forEach(b => b.classList.remove("active"));
  btn.classList.add("active");
}

function updateProgress() {
  const percent = Math.round(((current + 1) / questions.length) * 100);
  document.getElementById("progressBar").style.width = percent + "%";
  document.getElementById("currentNum").innerText = current + 1;
}

document.getElementById("nextBtn").addEventListener("click", () => {
  if (!answers[questions[current].question_id]) {
    Swal.fire({ icon: 'warning', title: 'Please select an answer' });
    return;
  }
  if (current < questions.length - 1) {
    current++;
    renderQuestion();
  } else {
    submitExam();
  }
});

document.getElementById("prevBtn").addEventListener("click", () => {
  if (current > 0) {
    current--;
    renderQuestion();
  }
});

/*  UPDATED SUBMIT FUNCTION  */
function submitExam(dismissed = false) {
  Swal.fire({
    title: dismissed ? 'Submitting due to rule violation...' : 'Submitting your exam...',
    text: 'Please wait a moment.',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  fetch('submit_exam.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      exam_id: <?= $exam_id ?>,
      answers: answers,
      dismissed: dismissed
    })
  })
  .then(res => res.json())
  .then(data => {
    if (dismissed) {
      Swal.fire({
        icon: 'error',
        title: 'You have been dismissed!',
        text: 'Your exam was automatically submitted due to rule violation.',
        confirmButtonColor: '#d4af37'
      }).then(() => {
        window.location.href = 'course_management.php?course_id=<?= $course_id ?>';
      });
      return;
    }

    if (data.status === 'success' && data.redirect) {
      window.location.href = data.redirect;
    } else if (data.status === 'already_passed') {
      Swal.fire({
        icon: 'info',
        title: 'Exam already passed!',
        text: 'You have already passed this exam.',
        confirmButtonColor: '#d4af37'
      }).then(() => {
        window.location.href = 'course_management.php?course_id=<?= $course_id ?>';
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.message || 'Something went wrong. Please try again.',
        confirmButtonColor: '#d4af37'
      });
    }
  })
  .catch(err => {
    console.error('Error submitting exam:', err);
    Swal.fire({
      icon: 'error',
      title: 'Submission Failed',
      text: 'Please try again later.',
      confirmButtonColor: '#d4af37'
    });
  });
}


let warningCount = 0;
const user_id = <?= $user_id ?>;
const exam_id = <?= $exam_id ?>;


function saveWarningToDB() {
  fetch("save_security_log.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ user_id, exam_id, warning_count: warningCount })
  });
}

function handleViolation(type) {
  warningCount++;
  console.log("Violation detected:", type, new Date(), "(Total warnings: " + warningCount + ")");

  let warningText = `(${warningCount}/3 warnings)`;
  if (type === "tab") warningText = `You switched tabs/window! ${warningText}`;
  else if (type === "resize") warningText = `You resized/minimized the window! ${warningText}`;
  else if (type === "shortcut") warningText = `You used restricted keys! ${warningText}`;

  if (warningCount < 3) {
    Swal.fire({ icon: 'warning', title: 'Warning!', text: warningText, confirmButtonColor: '#d4af37' });
    saveWarningToDB();
  } else {
    saveWarningToDB();
    Swal.fire({
      icon: 'error',
      title: 'Exam Dismissed!',
      text: 'You violated the rules 3 times. Your exam will now be submitted.',
      confirmButtonColor: '#d4af37'
    }).then(() => { submitExam(true); });
  }
}

/*  Tab / Window Focus Detection */
let focusTimer;
window.addEventListener("blur", () => {
  focusTimer = setTimeout(() => handleViolation("tab"), 0.5); 
});
window.addEventListener("focus", () => {
  clearTimeout(focusTimer); 
});

/*  Window Resize Detection  */
let lastWidth = window.innerWidth;
let lastHeight = window.innerHeight;
let resizeTimer;

window.addEventListener("resize", () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(() => {
    const newWidth = window.innerWidth;
    const newHeight = window.innerHeight;

 
    if (Math.abs(newWidth - lastWidth) > 50 || Math.abs(newHeight - lastHeight) > 50) {
      handleViolation("resize");
    }

    lastWidth = newWidth;
    lastHeight = newHeight;
  }, 500);
});

/* Disable Right-Click */
document.addEventListener("contextmenu", e => {
  e.preventDefault();
  Swal.fire({ icon: 'warning', title: 'Action Blocked!', text: 'Right-click is disabled during the exam.', confirmButtonColor: '#d4af37' });
});

/* Disable Copy/Paste/Select */
['copy', 'cut', 'paste', 'selectstart'].forEach(evt => document.addEventListener(evt, e => e.preventDefault()));

/* Shortcut Detection*/
document.addEventListener("keydown", e => {
  if (
    e.key === "F12" ||
    (e.ctrlKey && ["u", "U", "c", "v", "x"].includes(e.key)) ||
    (e.ctrlKey && e.shiftKey && ["I", "i"].includes(e.key))
  ) {
    e.preventDefault();
    handleViolation("shortcut");
  }
});



window.onload = () => {
  Swal.fire({
    icon: 'info',
    title: 'Exam Security Notice',
    html: `
      <div style="text-align:left;">
        <b>Rules:</b><br><br>
        • No tab switching or minimizing.<br>
        • No right-click, copy/paste, or shortcuts.<br>
        • 3 violations = auto exam submission.<br><br>
        <b>Good luck!</b>
      </div>
    `,
    confirmButtonColor: '#d4af37'
  });
};

renderQuestion();
</script>
</body>
</html>
