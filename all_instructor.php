<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('head_content.php')
 ?>

<body class="p-20">


<div  class="all-instructor mt-6">

<?php
include("database.php");

// Fetch all instructors
$sql = "SELECT user_id, firstName, lastName, email, profile_pic, bio FROM User WHERE role = 'instructor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="all-instructor flex flex-wrap justify-center gap-6">';  // Adjusted gap between cards
    
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Fetch uploaded courses for the instructor
        $course_sql = "
            SELECT c.title 
            FROM Course c
            JOIN Instructor i ON c.instructor_id = i.instructor_id
            WHERE i.user_id = ?
        ";
        $course_stmt = $conn->prepare($course_sql);
        $course_stmt->bind_param("i", $user_id);
        $course_stmt->execute();
        $course_result = $course_stmt->get_result();
        $courses = [];
        while ($course = $course_result->fetch_assoc()) {
            $courses[] = $course['title'];
        }
        $course_stmt->close();

        // Display the instructor card
        echo '<div class="bg-[#283747] p-6 shadow-xl w-full max-w-sm rounded-2xl font-sans overflow-hidden highlight">';
        echo '<div class="flex flex-col items-center">';
        echo '<div class="min-h-[110px]">';
        echo '<img src="' . htmlspecialchars($row["profile_pic"] ?: "default-profile.png") . '" class="w-28 h-28 rounded-full border-4 border-white" />';
        echo '</div>';
        echo '<div class="mt-4 text-center">';
        echo '<p class="text-lg text-white font-bold">' . htmlspecialchars($row["firstName"] . " " . $row["lastName"]) . '</p>';
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["email"]) . '</p>';
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["bio"]) . '</p>';
        echo '</div>';
        
        // Display the list of courses if available
        if (!empty($courses)) {
            echo '<div class="mt-4 text-white">';
            echo '<p class="font-bold text-lg mb-2">Courses:</p>';
            echo '<ul class="list-disc pl-5 space-y-2">';
            foreach ($courses as $course) {
                echo '<li class="text-sm">' . htmlspecialchars($course) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<p class="text-sm text-gray-400">No courses uploaded.</p>';
        }

        

        echo '</div>';  // Close the instructor card div
        echo '</div>';  // Close the all-instructor div
    }

    echo '</div>';  // Close the flex wrapper
} else {
    echo '<p class="text-center text-gray-500">No Instructors Found.</p>';
}

$conn->close();
?>


</div>


  
</body>
</html>