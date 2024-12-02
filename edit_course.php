<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include('head_content.php'); ?>
</head>
<body>


 <!-- All Courses -->
 <section>
  <h2 class="text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">Your All Courses</h2>

  <?php
  // Ensure the user is logged in
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
  }

  // Fetch the logged-in user ID
  $user_id = $_SESSION['user_id'];

  // Database connection
  include('database.php');

  // Get the instructor ID of the logged-in user
  $query_instructor = "SELECT instructor_id FROM Instructor WHERE user_id = ?";
  $stmt_instructor = $conn->prepare($query_instructor);
  $stmt_instructor->bind_param("i", $user_id);
  $stmt_instructor->execute();
  $result_instructor = $stmt_instructor->get_result();
  $instructor = $result_instructor->fetch_assoc();

  if (!$instructor) {
    echo "No instructor profile found.";
    exit();
  }

  $instructor_id = $instructor['instructor_id'];

  // Query to fetch courses with their course_id and video content
  $sql = "
  SELECT 
      Course.course_id,
      Course.title AS course_title, 
      Course.description, 
      Course.category, 
      Course.price, 
      Course_Content.file_url 
  FROM 
      Course 
  LEFT JOIN 
      Course_Content ON Course.course_id = Course_Content.course_id 
  WHERE 
      Course_Content.type = 'video' 
      AND Course.instructor_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $instructor_id);
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <div class="flex flex-wrap justify-center">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $course_id = htmlspecialchars($row['course_id']);
    ?>
        <div class="card bg-base-100 w-96 shadow-xl m-4">
          <video class="h-full w-full rounded-lg" controls>
            <source src="<?php echo htmlspecialchars($row['file_url']); ?>" type="video/mp4" />
            Your browser does not support the video tag.
          </video>
          <div class="card-body">
            <h2 class="card-title"><?php echo htmlspecialchars($row['course_title']); ?></h2>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <p>Category: <?php echo htmlspecialchars($row['category']); ?></p>
            <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
            <p><strong>Course ID:</strong> <?php echo $course_id; ?></p>
            <div class="flex justify-between mt-4">
              <!-- Edit Button -->
              <a href="edit_course.php?course_id=<?php echo $course_id; ?>" class="btn btn-primary w-32">Edit</a>
              <!-- Delete Button -->
              <form action="delete_course.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                <button type="submit" class="btn bg-[red] w-32">Delete</button>
              </form>
            </div>
          </div>
        </div>
    <?php
      }
    } else {
      echo '<p>No courses available.</p>';
    }
    ?>
  </div>
</section>

    
</body>
</html>