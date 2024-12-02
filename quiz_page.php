<?php
// Include database configuration
include('database.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Check if course_id is provided
if (!isset($_GET['course_id'])) {
    echo "No course selected.";
    exit();
}

$course_id = intval($_GET['course_id']);

// Fetch quiz details
$query_quiz = "SELECT * FROM Quiz WHERE course_id = ?";
$stmt_quiz = $conn->prepare($query_quiz);
$stmt_quiz->bind_param("i", $course_id);
$stmt_quiz->execute();
$result_quiz = $stmt_quiz->get_result();

$quiz = $result_quiz->fetch_assoc();
$quiz_exists = $quiz ? true : false;
$quiz_id = $quiz_exists ? $quiz['quiz_id'] : null;
$total_questions = $quiz_exists ? $quiz['total_questions'] : 0;

$results = [];
$all_correct = true;

// Handle form submission if quiz exists
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $quiz_exists) {
    $answers = $_POST['answers'] ?? [];

    $query_questions = "SELECT * FROM Question WHERE quiz_id = ?";
    $stmt_questions = $conn->prepare($query_questions);
    $stmt_questions->bind_param("i", $quiz_id);
    $stmt_questions->execute();
    $result_questions = $stmt_questions->get_result();

    while ($question = $result_questions->fetch_assoc()) {
        $question_id = $question['question_id'];
        $correct_answer = $question['answer'];
        $user_answer = $answers[$question_id] ?? null;

        $is_correct = (strcasecmp($user_answer, $correct_answer) == 0);
        $results[$question_id] = $is_correct;

        if (!$is_correct) {
            $all_correct = false;
        }
    }

    if ($all_correct) {
        $query_certificate = "INSERT INTO Certificate (user_id, course_id, issue_date) VALUES (?, ?, NOW())";
        $stmt_certificate = $conn->prepare($query_certificate);
        $stmt_certificate->bind_param("ii", $user_id, $course_id);
        $stmt_certificate->execute();

        $success_message = "Congratulations! You are ready for certification. You will receive your certificate soon.";
    }
}

// Fetch questions again for display if quiz exists
if ($quiz_exists) {
    $query_questions = "SELECT * FROM Question WHERE quiz_id = ?";
    $stmt_questions = $conn->prepare($query_questions);
    $stmt_questions->bind_param("i", $quiz_id);
    $stmt_questions->execute();
    $result_questions = $stmt_questions->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_content.php'); ?>
</head>
<body class="bg-[#283747] p-8">
    <div class="max-w-4xl mx-auto bg-[#1C2833] p-8 rounded-lg shadow-lg text-white">
        <h1 class="text-3xl font-bold text-center">Quiz for Course #<?php echo $course_id; ?></h1>

        <?php if (!$quiz_exists) { ?>
            <p class="mt-4 text-lg text-center text-red-500">No quiz available for this course.</p>
        <?php } else { ?>
            <p class="mt-4 text-lg">Total Questions: <?php echo $total_questions; ?></p>

            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
                <h2 class="mt-4 text-xl font-bold">Results:</h2>
                <?php
                $question_number = 1;
                foreach ($results as $question_id => $is_correct) {
                    $status = $is_correct ? "Correct ✅" : "Wrong ❌";
                    echo "<p class='mt-2'>Q{$question_number}: {$status}</p>";
                    $question_number++;
                }
                ?>
                <?php if ($all_correct && isset($success_message)) { ?>
                    <p class="mt-6 text-green-400 font-semibold"><?php echo $success_message; ?></p>
                <?php } ?>
            <?php } else { ?>
                <form action="quiz_page.php?course_id=<?php echo $course_id; ?>" method="POST" class="mt-6 space-y-6">
                    <?php
                    $question_number = 1;
                    while ($question = $result_questions->fetch_assoc()) {
                        $question_id = $question['question_id'];
                        $question_text = htmlspecialchars($question['question_text']);
                        $question_type = $question['question_type'];
                        ?>
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold">
                                Q<?php echo $question_number++; ?>. <?php echo $question_text; ?>
                            </h2>

                            <?php if ($question_type == 'multiple_choice') { ?>
                                <label class="block mt-2">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="A" required> Option A
                                </label>
                                <label class="block">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="B"> Option B
                                </label>
                                <label class="block">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="C"> Option C
                                </label>
                                <label class="block">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="D"> Option D
                                </label>
                            <?php } elseif ($question_type == 'true_false') { ?>
                                <label class="block mt-2">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="true" required> True
                                </label>
                                <label class="block">
                                    <input type="radio" name="answers[<?php echo $question_id; ?>]" value="false"> False
                                </label>
                            <?php } elseif ($question_type == 'short_answer') { ?>
                                <input type="text" name="answers[<?php echo $question_id; ?>]" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <button type="submit" class="w-full bg-green-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-600 transition">Submit Quiz</button>
                </form>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>
