<?php
// Include database connection
include('database.php');

// Check if the `id` parameter is set in the URL
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM Course WHERE course_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $course_id);

    if ($stmt->execute()) {
        // Redirect back with a success message
        header('Location: instructor.php?delete_msg=Course successfully deleted');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
}
?>
