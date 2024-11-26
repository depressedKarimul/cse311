<!DOCTYPE html>
<html lang="en">
<head>
 <?php include('head_content.php') ?>
</head>
<body>

<?php
include('database.php');

// Query to get all courses with the forum post date
$query = "SELECT c.course_id, c.title, c.description, c.category, c.price, 
                 i.user_id AS instructor_id, u.firstName, u.lastName, u.profile_pic,
                 fp.post_date
          FROM Course c
          JOIN Instructor i ON c.instructor_id = i.instructor_id
          JOIN User u ON i.user_id = u.user_id
          LEFT JOIN Forum_Post fp ON c.course_id = fp.course_id
          WHERE c.status = 'active'"; // Optional: filter by active courses
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Initialize a counter to track the courses in each row
$counter = 0;

// Start a new row after every 3 cards
echo '<div class="flex flex-wrap">';

// Loop through all courses and display them
while ($course = $result->fetch_assoc()) {
    // Query to get video content for the course
    $query_video = "SELECT file_url FROM Course_Content WHERE course_id = ? AND type = 'video'";
    $stmt_video = $conn->prepare($query_video);
    $stmt_video->bind_param("i", $course['course_id']);
    $stmt_video->execute();
    $result_video = $stmt_video->get_result();
    $video_content = $result_video->fetch_assoc();
?>

  <!-- Course card HTML -->
  <div class="relative flex ml-5 flex-col my-6 bg-white shadow-sm border border-slate-200 rounded-lg w-96">
    <div class="relative h-56 m-2.5 overflow-hidden text-white rounded-md">
      <video class="h-full w-full rounded-lg" controls>
        <!-- Video fetched from Course_Content table -->
        <source src="<?php echo $video_content['file_url']; ?>" type="video/mp4" />
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="p-4">
      <!-- Title and description fetched from Course table -->
      <h6 class="mb-2 text-slate-800 text-xl font-semibold">
        <?php echo htmlspecialchars($course['title']); ?>
      </h6>
      <p class="text-slate-600 leading-normal font-light">
        <?php echo htmlspecialchars($course['description']); ?>
      </p>
      <p class="text-slate-600 leading-normal font-light">
        <h4 class="font-bold">Category: <?php echo htmlspecialchars($course['category']); ?></h4> 
      </p>
      <p class="text-slate-600 leading-normal font-light">

      <!-- show here course Enrolled date -->
        <h4 class="font-bold">Price: $<?php echo number_format($course['price'], 2); ?></h4> 
      </p>
    </div>
    <div class="flex items-center justify-between p-4">
      <div class="flex items-center">
        <!-- Instructor profile picture -->
        <img alt="<?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>"
             src="<?php echo $course['profile_pic']; ?>"
             class="relative inline-block h-8 w-8 rounded-full" />
        <div class="flex flex-col ml-3 text-sm">
          <span class="text-slate-800 font-semibold">
            <?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>
          </span>

          <!-- Retrieve post date from Forum_Post table -->
          <span class="text-slate-600">
            <?php echo date('F j, Y', strtotime($course['post_date'])); ?>
          </span>
        </div>
      </div>
    </div>

   
    
  

</div>

  </div> 

<?php
    // Increment the counter
    $counter++;

    // Close the row div after every 3 cards
    if ($counter % 3 == 0) {
        echo '</div><div class="flex flex-wrap">'; // Close the current row and start a new one
    }
} // End of while loop

// Close the last row div if there are fewer than 3 cards
if ($counter % 3 != 0) {
    echo '</div>'; // Close the remaining flex row div
}
?>

</body>
</html>
