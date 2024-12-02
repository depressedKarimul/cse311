<?php
// Ensure the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('database.php');

// Check if course_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);

    // Delete course query
    $sql = "DELETE FROM Course WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);

    if ($stmt->execute()) {
        header("Location: edit_course.php?message=Course+deleted+successfully");
    } else {
        echo "Error deleting course.";
    }
} else {
    echo "Invalid request.";
}
?>
