<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('database.php');

// Check if review_id is set
if (isset($_POST['review_id'])) {
    $review_id = $_POST['review_id'];

    // Prepare the delete query to delete the comment based on review_id
    $sql = "DELETE FROM course_reviews WHERE review_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter and execute query
        $stmt->bind_param("i", $review_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Comment deleted successfully.'); window.location.href = 'instructor.php';</script>";
        } else {
            echo "<script>alert('Error: Unable to delete the comment.'); window.location.href = 'instructor.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error.'); window.location.href = 'instructor.php';</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'instructor.php';</script>";
}
?>
