<?php
// Include database configuration
include('database.php');
session_start();

// Assuming the user is logged in, and the user_id is stored in the session
$user_id = $_SESSION['user_id'];

$query = "
    SELECT i.instructor_id 
    FROM Instructor i
    WHERE i.user_id = $user_id
";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$instructor_id = $row['instructor_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handling form submission
    $course_title = $_POST['course_title'];
    $course_description = $_POST['course_description'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Insert course details into Course table
    $insert_course_query = "
        INSERT INTO Course (instructor_id, title, description, category, difficulty, price, status)
        VALUES ('$instructor_id', '$course_title', '$course_description', '$category', '$difficulty', '$price', '$status')
    ";
    if (mysqli_query($conn, $insert_course_query)) {
        $course_id = mysqli_insert_id($conn); // Get the last inserted course_id

        // Handle course content upload
        if (isset($_FILES['content_file'])) {
            $content_type = $_POST['content_type'];
            $content_title = $_POST['content_title'];
            $content_duration = $_POST['content_duration'];

            // File upload logic
            $target_dir = "C:/xampp/htdocs/cse311/Upload Course/";
            $target_file = $target_dir . basename($_FILES["content_file"]["name"]);
            $upload_ok = 1;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if file is a valid format
            if ($file_type != "mp4" && $file_type != "pdf" && $file_type != "docx" && $file_type != "jpg") {
                echo "Sorry, only MP4, PDF, DOCX & JPG files are allowed.";
                $upload_ok = 0;
            }

            if ($upload_ok == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["content_file"]["tmp_name"], $target_file)) {
                    // Insert course content into Course_Content table
                    $insert_content_query = "
                        INSERT INTO Course_Content (course_id, type, title, file_url, content_duration)
                        VALUES ('$course_id', '$content_type', '$content_title', '$target_file', '$content_duration')
                    ";
                    if (mysqli_query($conn, $insert_content_query)) {
                        echo "Course content uploaded successfully!";
                    } else {
                        echo "Error uploading course content: " . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Add category if it doesn't already exist in the Category table
        $category_query = "SELECT * FROM Category WHERE category_name = '$category'";
        $category_result = mysqli_query($conn, $category_query);
        if (mysqli_num_rows($category_result) == 0) {
            // Insert new category into the Category table if it doesn't exist
            $insert_category_query = "
                INSERT INTO Category (category_name)
                VALUES ('$category')
            ";
            mysqli_query($conn, $insert_category_query);
        }

        // Post to the forum once the course is created
        // Assuming post_text comes from the form (you can modify as needed)
        $post_text = "Discussion for course: " . $course_title;
        $post_date = date('Y-m-d');
        $insert_post_query = "
            INSERT INTO Forum_Post (course_id, user_id, post_text, post_date)
            VALUES ('$course_id', '$user_id', '$post_text', '$post_date')
        ";
        if (mysqli_query($conn, $insert_post_query)) {
            echo "Course created and forum post added!";
        } else {
            echo "Error posting to forum: " . mysqli_error($conn);
        }

    } else {
        echo "Error inserting course: " . mysqli_error($conn);
    }
}
?>

<!-- HTML form for uploading the course -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Upload Course Content</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <!-- Course Details -->
            <div class="space-y-4">
                <div>
                    <label for="course_title" class="block text-gray-600">Course Title</label>
                    <input type="text" id="course_title" name="course_title" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label for="course_description" class="block text-gray-600">Course Description</label>
                    <textarea id="course_description" name="course_description" class="w-full p-3 border border-gray-300 rounded-lg" rows="4" required></textarea>
                </div>

                <div>
                    <label for="category" class="block text-gray-600">Category</label>
                    <select id="category" name="category" class="w-full p-3 border border-gray-300 rounded-lg" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Development">Development</option>
                        <option value="IT and Software">IT and Software</option>
                        <option value="Design">Design</option>
                    </select>
                </div>

                <div>
                    <label for="difficulty" class="block text-gray-600">Difficulty</label>
                    <select id="difficulty" name="difficulty" class="w-full p-3 border border-gray-300 rounded-lg" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>

                <div>
                    <label for="price" class="block text-gray-600">Price</label>
                    <input type="number" step="0.01" id="price" name="price" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label for="status" class="block text-gray-600">Status</label>
                    <select id="status" name="status" class="w-full p-3 border border-gray-300 rounded-lg" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <h2 class="text-xl font-semibold text-gray-700 mt-8 mb-4">Upload Course Content</h2>

                <div>
                    <label for="content_type" class="block text-gray-600">Content Type</label>
                    <select id="content_type" name="content_type" class="w-full p-3 border border-gray-300 rounded-lg" required>
                        <option value="video">Video</option>
                        <option value="article">Article</option>
                        <option value="quiz">Quiz</option>
                    </select>
                </div>

                <div>
                    <label for="content_title" class="block text-gray-600">Content Title</label>
                    <input type="text" id="content_title" name="content_title" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label for="content_duration" class="block text-gray-600">Content Duration (e.g., 01:30:00)</label>
                    <input type="time" id="content_duration" name="content_duration" class="w-full p-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label for="content_file" class="block text-gray-600">Content File</label>
                    <input type="file" id="content_file" name="content_file" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>
            </div>

            <button type="submit" class="w-full mt-6 py-3 bg-green-600 text-white font-semibold rounded-lg">Upload Course</button>
        </form>
    </div>

</body>
</html>
