<?php
// Include database configuration
include('database.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

$user_id = $_POST['user_id'];  // User ID from request
$course_id = $_POST['course_id'];  // Course ID from request

// Get the current date for the issue_date
$issue_date = date('Y-m-d');

// Check if the user has already received a certificate for this course
$query = "SELECT * FROM Certificate WHERE user_id = ? AND course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "You already have a certificate for this course.";
} else {
    // Insert a new certificate record
    $insert_query = "INSERT INTO Certificate (user_id, course_id, issue_date) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($insert_query);
    $stmt_insert->bind_param("iis", $user_id, $course_id, $issue_date);
    
    if ($stmt_insert->execute()) {
        echo "Certificate successfully applied.";
    } else {
        echo "Error applying for certificate.";
    }
}

$stmt->close();
$stmt_insert->close();
$conn->close();
?>
