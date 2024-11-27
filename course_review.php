<?php
// Database connection
$conn = new mysqli("localhost", "username", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session to get user_id
session_start();
$user_id = $_SESSION['user_id']; // Assume user_id is stored in session during login

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validate inputs
    if (!empty($course_id) && !empty($rating) && !empty($comment)) {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO course_reviews(course_id, rating, comment, review_date) VALUES (?, ?, ?, CURDATE())");
        $stmt->bind_param("iis", $course_id, $rating, $comment);

        if ($stmt->execute()) {
            // Redirect to student_profile.php after review submission
            header("Location: student_profile.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}
?>
