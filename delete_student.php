<?php
// Include the database configuration
include('database.php');
session_start();

// Check if the required data is received
if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];

    // Prepare the delete query to remove the student from the course in the Enrollment table
    $delete_enrollment_query = "
        DELETE FROM Enrollment 
        WHERE user_id = '$student_id' AND course_id = '$course_id'
    ";

    if (mysqli_query($conn, $delete_enrollment_query)) {
        // Redirect or show a success message
        $_SESSION['message'] = "Student removed from the course successfully.";
        header('Location: instructor.php'); // Change to the appropriate page
    } else {
        // Error message in case of failure
        $_SESSION['message'] = "Error removing student from course: " . mysqli_error($conn);
        header('Location: instructor.php'); // Change to the appropriate page
    }
} else {
    // If the required data is not received, redirect with an error message
    $_SESSION['message'] = "Invalid request.";
    header('Location: instructor.php'); // Change to the appropriate page
}
?>
