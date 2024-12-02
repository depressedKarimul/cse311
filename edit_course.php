<?php
// Include database configuration
include('database.php');
session_start();

$message = ""; // For success/error messages

// Assuming the user is logged in, and the user_id is stored in the session
$user_id = $_SESSION['user_id'];

$query = "SELECT instructor_id FROM Instructor WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$instructor_id = $row['instructor_id'];

// Retrieve course details for editing
$course_id = $_GET['course_id']; // Course ID should be passed as a query parameter
$course_query = "SELECT * FROM Course WHERE course_id = '$course_id' AND instructor_id = '$instructor_id'";
$course_result = mysqli_query($conn, $course_query);
$course_data = mysqli_fetch_assoc($course_result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_title = $_POST['course_title'];
    $course_description = $_POST['course_description'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Update course information
    $update_course_query = "
        UPDATE Course
        SET 
            title = '$course_title',
            description = '$course_description',
            category = '$category',
            difficulty = '$difficulty',
            price = '$price',
            status = '$status'
        WHERE course_id = '$course_id' AND instructor_id = '$instructor_id'
    ";
    
    if (mysqli_query($conn, $update_course_query)) {
        $message = "Course updated successfully!";
    } else {
        $message = "Error updating course: " . mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
   <?php include('head_content.php') ?>
</head>
<body class="p-6">
    <div class="max-w-4xl mx-auto bg-[#283747] p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl text-center bg-[#1D232A] p-5 font-semibold text-white mb-6">Upload Course Content</h1>

        <form action="" method="post" enctype="multipart/form-data">
    <div class="space-y-4">
        <div>
            <label for="course_title" class="block text-white">Course Title</label>
            <input type="text" id="course_title" name="course_title" value="<?php echo htmlspecialchars($course_data['title']); ?>" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" required>
        </div>

        <div>
            <label for="course_description" class="block text-white">Course Description</label>
            <textarea id="course_description" name="course_description" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" rows="4" required><?php echo htmlspecialchars($course_data['description']); ?></textarea>
        </div>

        <div>
            <label for="category" class="block text-white">Category</label>
            <select id="category" name="category" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" required>
                <option value="Development" <?php echo $course_data['category'] == 'Development' ? 'selected' : ''; ?>>Development</option>
                <option value="IT and Software" <?php echo $course_data['category'] == 'IT and Software' ? 'selected' : ''; ?>>IT and Software</option>
                <option value="Design" <?php echo $course_data['category'] == 'Design' ? 'selected' : ''; ?>>Design</option>
            </select>
        </div>

        <div>
            <label for="difficulty" class="block text-white">Difficulty</label>
            <select id="difficulty" name="difficulty" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" required>
                <option value="beginner" <?php echo $course_data['difficulty'] == 'beginner' ? 'selected' : ''; ?>>Beginner</option>
                <option value="intermediate" <?php echo $course_data['difficulty'] == 'intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                <option value="advanced" <?php echo $course_data['difficulty'] == 'advanced' ? 'selected' : ''; ?>>Advanced</option>
            </select>
        </div>

        <div>
            <label for="price" class="block text-white">Price</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo $course_data['price']; ?>" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" required>
        </div>

        <div>
            <label for="status" class="block text-white">Status</label>
            <select id="status" name="status" class="w-full p-3 border rounded-lg bg-[#34495E] text-white" required>
                <option value="active" <?php echo $course_data['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo $course_data['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded m-10"><?php echo $message; ?></div>
    <?php endif; ?>

    <button type="submit" class="w-full mt-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-[black] hover:text-green-400">Update Course</button>
</form>

    </div>
</body>

</html>
