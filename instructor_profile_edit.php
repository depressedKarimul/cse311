<?php
include("database.php");
session_start();

// Assuming the user is logged in and the user_id is stored in the session
$user_id = $_SESSION['user_id'];

// Check if the user already has expertise in the Instructor table
$query = "SELECT expertise FROM Instructor WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // If expertise is already filled, redirect to instructor_profile.php
    header("Location: instructor_profile.php");
    exit();
}

// Process form submission for expertise
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expertise = mysqli_real_escape_string($conn, $_POST['expertise']);

    // Insert the new expertise into the Instructor table
    $insert_query = "
        INSERT INTO Instructor (user_id, expertise, total_courses)
        VALUES ($user_id, '$expertise', 0)
    ";

    if (mysqli_query($conn, $insert_query)) {
        // Successfully inserted, redirect to the profile page
        header("Location: instructor_profile.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_content.php'); ?>
</head>
<body>

<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Edit Your Expertise</h2>
        
        <form method="POST" action="instructor_profile_edit.php" class="space-y-4">
            <!-- Expertise input field -->
            <div>
                <label for="expertise" class="block text-sm font-medium text-gray-700">Expertise</label>
                <input type="text" name="expertise" id="expertise" required 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                    placeholder="Enter your expertise" />
            </div>
            
            <!-- Submit button -->
            <div class="flex justify-center">
                <button type="submit" 
                    class="w-full bg-green-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Save Expertise
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
