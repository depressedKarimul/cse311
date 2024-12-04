<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the profile picture from session
$profilePic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default_profile.jpg'; // Set a default image if not available
?>

<?php


// Get the course ID from the form submission
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    
    // Ensure that the course exists and is active
    $query = "SELECT * FROM Course WHERE course_id = ? AND status = 'active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Logic for enrolling the student in the course
        $user_id = $_SESSION['user_id'];
        $query_enroll = "INSERT INTO Enrollments (user_id, course_id) VALUES (?, ?)";
        $stmt_enroll = $conn->prepare($query_enroll);
        $stmt_enroll->bind_param("ii", $user_id, $course_id);
        if ($stmt_enroll->execute()) {
            // Redirect or show success message
            echo "Successfully enrolled in the course!";
        } else {
            // Error enrolling
            echo "Failed to enroll in the course.";
        }
    } else {
        // Course does not exist or is not active
        echo "Course not found or unavailable.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
 <?php
  include('head_content.php')
 ?>


</head>
<body>


<header>
      <!-- Navigation -->
      <nav id="navigation">
        <div class="navbar bg-black">
          <div class="navbar-start">
            <!-- Dropdown menu -->
            <div class="dropdown">
              <div tabindex="0" role="button" class="hidden btn btn-ghost btn-circle">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h7"
                  />
                </svg>
              </div>
              <ul
                tabindex="0"
                class="hidden menu menu-sm dropdown-content bg-black rounded-box z-[1] mt-3 w-52 p-2 shadow"
              >
                <li><a>Homepage</a></li>
                <li><a>Portfolio</a></li>
                <li><a>About</a></li>
              </ul>
            </div>
          </div>

          <div class="navbar-center">
            <a class="btn btn-ghost text-xl">SkillPro</a>
          </div>

          <div class="navbar-end">
            <!-- Search button and input field -->
           
  <!-- Search form with button and input field -->
  <form action="search.php" method="GET" class="relative">
    <button
      id="search-btn"
      type="button"
      class="btn btn-ghost btn-circle"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
        />
      </svg>
    </button>
    <input
      id="search-input"
      type="text"
      name="query"
      placeholder="Search..."
      class="hidden absolute right-0 bg-black text-white rounded-md p-2 mt-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 ease-in-out"
      style="width: 150px"
    />
  </form>
</div>

<script>
  // Toggle visibility of the search input when the search button is clicked
  document.getElementById("search-btn").addEventListener("click", function () {
    const searchInput = document.getElementById("search-input");
    searchInput.classList.toggle("hidden");
    searchInput.focus();
  });

  // Handle Enter key press for submitting the search form
  document.getElementById("search-input").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
      // Trigger form submission when Enter is pressed
      event.preventDefault(); // Prevents the default action (form submission if any)
      document.querySelector("form").submit(); // Manually submit the form
    }
  });
</script>


            <!-- Notification button -->
            <button class="btn btn-ghost btn-circle">
              <div class="indicator">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                  />
                </svg>
                <span
                  class="badge badge-xs badge-primary indicator-item"
                ></span>
              </div>
            </button>
          </div>
        </div>

       

        <div class="navbar relative z-50">
          <div class="navbar-start">
            <!-- Dropdown menu and brand -->
            <div class="dropdown">
              <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h8m-8 6h16"
                  />
                </svg>
              </div>
              <ul
                tabindex="0"
                class="menu menu-sm dropdown-content rounded-box z-[1] mt-3 w-52 p-2 shadow bg-black text-white"
              >
                <li><a>Home</a></li>

                <li>
                  <a>Development</a>
                  
                </li>

                <li>
                  <a>IT & Software</a>
                  
                </li>

                <li>
                  <a>Design</a>
                  
                </li>

                <li><a>Instructors</a></li>
                <li><a href="FreeCourses.html">Free Courses</a></li>
                
              </ul>
            </div>

            <label class="flex cursor-pointer gap-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <circle cx="12" cy="12" r="5" />
                <path
                  d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"
                />
              </svg>
              <input
                type="checkbox"
                value="synthwave"
                class="toggle theme-controller"
              />
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="20"
                height="20"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path
                  d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"
                ></path>
              </svg>
            </label>
          </div>

          <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
              <li class="mark"><a>Home</a></li>
              <li>
                <a href="">Development</a>
              </li>
              <li>
               <a href=""> IT & Software</a>
              </li>

              <li>
               <a href=""> Design</a>
                 
              </li>

              <li><a>Instructors</a></li>
              <li><a href="FreeCourses.html">Free Courses</a></li>
            </ul>
          </div>

          
  <!-- Profile Image Button -->
  <div class="navbar-end">
                <!-- Profile Image Button -->
                <button id="profile-btn" class="rounded-full w-10 h-10 mr-10 overflow-hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile" class="w-full h-full object-cover" />
                </button>

  <!-- Dropdown Menu -->
  <div
    id="dropdown-menu"
    class="hidden absolute right-0 mt-2 w-40 bg-[#021e3b] rounded-md shadow-lg z-10"
  >
    <ul class="py-2 text-sm text-gray-100">
      <li>
        <a href="student_profile.php" class="block px-4 py-2 hover:bg-[#01797a]">Profile</a>
      </li>
      <li>
        <a href="student_settings.php" class="block px-4 py-2 hover:bg-[#01797a]">Settings</a>
      </li>
      <li>
        <a href="logout.php" class="block px-4 py-2 text-red-500 hover:bg-[#01797a]">Log Out</a>
      </li>


 

    </ul>
  </div>
</div>



        </div>
      </nav>
    </header>

    <mian>
      <!-- All search  development course -->
      <section>
      <h2 class="mt-5 text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">All Development Courses</h2>
      <?php
include('database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the search query from the form submission
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Query to fetch all development courses that match the search query
$query = "SELECT c.course_id, c.title, c.description, c.category, c.price, 
                 i.user_id AS instructor_id, u.firstName, u.lastName, u.profile_pic,
                 fp.post_date
          FROM Course c
          JOIN Instructor i ON c.instructor_id = i.instructor_id
          JOIN User u ON i.user_id = u.user_id
          LEFT JOIN Forum_Post fp ON c.course_id = fp.course_id
          WHERE c.status = 'active' AND c.category = 'Development'
          AND (c.title LIKE ? OR c.description LIKE ?)";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Check if any courses were found
if ($result->num_rows === 0) {
  echo '<p class="mt-5 text-center  text-white p-5 font-extrabold">No courses found.</p>';
} else {
    
    echo '<section class="lg:ml-32">';

    // Initialize a counter to track the courses in each row
    $counter = 0;

    // Loop through all matching courses and display them
    while ($course = $result->fetch_assoc()) {
        // Query to get video content for the course
        $query_video = "SELECT file_url FROM Course_Content WHERE course_id = ? AND type = 'video'";
        $stmt_video = $conn->prepare($query_video);
        $stmt_video->bind_param("i", $course['course_id']);
        $stmt_video->execute();
        $result_video = $stmt_video->get_result();
        $video_content = $result_video->fetch_assoc();

        // Start a new row after every 3 cards
        if ($counter % 3 == 0) {
            echo '<div class="flex flex-wrap">';
        }
        ?>
        <!-- Course card -->
        <div class="relative flex ml-5 flex-col my-6 text-white bg-[#283747] shadow-sm border border-slate-200 rounded-lg w-96">
          <div class="relative h-56 m-2.5 overflow-hidden text-white rounded-md">
            <video class="h-full w-full rounded-lg" id="video-<?php echo $course['course_id']; ?>" controls>
              <source src="<?php echo $video_content['file_url']; ?>" type="video/mp4" />
              Your browser does not support the video tag.
            </video>
            <div id="message-<?php echo $course['course_id']; ?>" class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 text-white text-xl font-bold hidden">
              Please buy the course first to play the video.
            </div>
          </div>
          <div class="p-4">
            <h6 class="mb-2 text-white text-xl font-semibold">
              <?php echo htmlspecialchars($course['title']); ?>
            </h6>
            <p class="text-white leading-normal font-light">
              <?php echo htmlspecialchars($course['description']); ?>
            </p>
            <h4 class="font-bold">Category: <?php echo htmlspecialchars($course['category']); ?></h4> 
            <h4 class="font-bold">Price: $<?php echo number_format($course['price'], 2); ?></h4> 
          </div>
          <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
              <img alt="<?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>"
                   src="<?php echo $course['profile_pic']; ?>"
                   class="relative inline-block h-8 w-8 rounded-full" />
              <div class="flex flex-col ml-3 text-sm">
                <span class="text-white font-semibold">
                  <?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>
                </span>
                <span class="text-white">
                  <?php echo date('F j, Y', strtotime($course['post_date'])); ?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php
        // Close the row after 3 cards
        $counter++;
        if ($counter % 3 == 0) {
            echo '</div>';  // Close the div for the row
        }
    } // End of while loop

    // If the last row has fewer than 3 cards, close the remaining row div
    if ($counter % 3 != 0) {
        echo '</div>';  // Close the div for the last row
    }
    echo '</section>';
}
?>

<script>
// JavaScript to handle video play, stop it, and show message
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.controls = false;
        video.addEventListener('play', function(event) {
            event.preventDefault();
            const courseId = video.id.split('-')[1];
            const messageDiv = document.getElementById('message-' + courseId);
            messageDiv.classList.remove('hidden');
            setTimeout(function() {
                messageDiv.classList.add('hidden');
            }, 3000);
        });
    });
});
</script>

      </section>






     
<!-- All Design Courses -->
<section>
  <h2 class="mt-5 text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">All Design Courses</h2>
  <?php
include('database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the search query from the form submission
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Query to fetch all design courses that match the search query
$query = "SELECT c.course_id, c.title, c.description, c.category, c.price, 
                 i.user_id AS instructor_id, u.firstName, u.lastName, u.profile_pic,
                 fp.post_date
          FROM Course c
          JOIN Instructor i ON c.instructor_id = i.instructor_id
          JOIN User u ON i.user_id = u.user_id
          LEFT JOIN Forum_Post fp ON c.course_id = fp.course_id
          WHERE c.status = 'active' AND c.category = 'Design'
          AND (c.title LIKE ? OR c.description LIKE ?)";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Check if any courses were found
if ($result->num_rows === 0) {
  echo '<p class="mt-5 text-center  text-white p-5 font-extrabold">No courses found.</p>';
} else {
    
    echo '<section class="lg:ml-32">';

    // Initialize a counter to track the courses in each row
    $counter = 0;

    // Loop through all matching courses and display them
    while ($course = $result->fetch_assoc()) {
        // Query to get video content for the course
        $query_video = "SELECT file_url FROM Course_Content WHERE course_id = ? AND type = 'video'";
        $stmt_video = $conn->prepare($query_video);
        $stmt_video->bind_param("i", $course['course_id']);
        $stmt_video->execute();
        $result_video = $stmt_video->get_result();
        $video_content = $result_video->fetch_assoc();

        // Start a new row after every 3 cards
        if ($counter % 3 == 0) {
            echo '<div class="flex flex-wrap">';
        }
        ?>
        <!-- Course card -->
        <div class="relative flex ml-5 flex-col my-6 text-white bg-[#283747] shadow-sm border border-slate-200 rounded-lg w-96">
          <div class="relative h-56 m-2.5 overflow-hidden text-white rounded-md">
            <video class="h-full w-full rounded-lg" id="video-<?php echo $course['course_id']; ?>" controls>
              <source src="<?php echo $video_content['file_url']; ?>" type="video/mp4" />
              Your browser does not support the video tag.
            </video>
            <div id="message-<?php echo $course['course_id']; ?>" class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 text-white text-xl font-bold hidden">
              Please buy the course first to play the video.
            </div>
          </div>
          <div class="p-4">
            <h6 class="mb-2 text-white text-xl font-semibold">
              <?php echo htmlspecialchars($course['title']); ?>
            </h6>
            <p class="text-white leading-normal font-light">
              <?php echo htmlspecialchars($course['description']); ?>
            </p>
            <h4 class="font-bold">Category: <?php echo htmlspecialchars($course['category']); ?></h4> 
            <h4 class="font-bold">Price: $<?php echo number_format($course['price'], 2); ?></h4> 
          </div>
          <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
              <img alt="<?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>"
                   src="<?php echo $course['profile_pic']; ?>"
                   class="relative inline-block h-8 w-8 rounded-full" />
              <div class="flex flex-col ml-3 text-sm">
                <span class="text-white font-semibold">
                  <?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>
                </span>
                <span class="text-white">
                  <?php echo date('F j, Y', strtotime($course['post_date'])); ?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php
        // Close the row after 3 cards
        $counter++;
        if ($counter % 3 == 0) {
            echo '</div>';  // Close the div for the row
        }
    } // End of while loop

    // If the last row has fewer than 3 cards, close the remaining row div
    if ($counter % 3 != 0) {
        echo '</div>';  // Close the div for the last row
    }
    echo '</section>';
}
?>

<script>
// JavaScript to handle video play, stop it, and show message
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.controls = false;
        video.addEventListener('play', function(event) {
            event.preventDefault();
            const courseId = video.id.split('-')[1];
            const messageDiv = document.getElementById('message-' + courseId);
            messageDiv.classList.remove('hidden');
            setTimeout(function() {
                messageDiv.classList.add('hidden');
            }, 3000);
        });
    });
});
</script>

</section>




<!-- All IT and Software Courses -->
<section>
  <h2 class="mt-5 text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">All IT and Software Courses</h2>
  <?php
include('database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the search query from the form submission
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Query to fetch all IT and Software courses that match the search query
$query = "SELECT c.course_id, c.title, c.description, c.category, c.price, 
                 i.user_id AS instructor_id, u.firstName, u.lastName, u.profile_pic,
                 fp.post_date
          FROM Course c
          JOIN Instructor i ON c.instructor_id = i.instructor_id
          JOIN User u ON i.user_id = u.user_id
          LEFT JOIN Forum_Post fp ON c.course_id = fp.course_id
          WHERE c.status = 'active' AND c.category = 'IT and Software'
          AND (c.title LIKE ? OR c.description LIKE ?)";

$stmt = $conn->prepare($query);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Check if any courses were found
if ($result->num_rows === 0) {
  echo '<p class="mt-5 text-center  text-white p-5 font-extrabold">No courses found.</p>';
} else {
    
    echo '<section class="lg:ml-32">';

    // Initialize a counter to track the courses in each row
    $counter = 0;

    // Loop through all matching courses and display them
    while ($course = $result->fetch_assoc()) {
        // Query to get video content for the course
        $query_video = "SELECT file_url FROM Course_Content WHERE course_id = ? AND type = 'video'";
        $stmt_video = $conn->prepare($query_video);
        $stmt_video->bind_param("i", $course['course_id']);
        $stmt_video->execute();
        $result_video = $stmt_video->get_result();
        $video_content = $result_video->fetch_assoc();

        // Start a new row after every 3 cards
        if ($counter % 3 == 0) {
            echo '<div class="flex flex-wrap">';
        }
        ?>
        <!-- Course card -->
        <div class="relative flex ml-5 flex-col my-6 text-white bg-[#283747] shadow-sm border border-slate-200 rounded-lg w-96">
          <div class="relative h-56 m-2.5 overflow-hidden text-white rounded-md">
            <video class="h-full w-full rounded-lg" id="video-<?php echo $course['course_id']; ?>" controls>
              <source src="<?php echo $video_content['file_url']; ?>" type="video/mp4" />
              Your browser does not support the video tag.
            </video>
            <div id="message-<?php echo $course['course_id']; ?>" class="absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center bg-black bg-opacity-60 text-white text-xl font-bold hidden">
              Please buy the course first to play the video.
            </div>
          </div>
          <div class="p-4">
            <h6 class="mb-2 text-white text-xl font-semibold">
              <?php echo htmlspecialchars($course['title']); ?>
            </h6>
            <p class="text-white leading-normal font-light">
              <?php echo htmlspecialchars($course['description']); ?>
            </p>
            <h4 class="font-bold">Category: <?php echo htmlspecialchars($course['category']); ?></h4> 
            <h4 class="font-bold">Price: $<?php echo number_format($course['price'], 2); ?></h4> 
          </div>
          <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
              <img alt="<?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>"
                   src="<?php echo $course['profile_pic']; ?>"
                   class="relative inline-block h-8 w-8 rounded-full" />
              <div class="flex flex-col ml-3 text-sm">
                <span class="text-white font-semibold">
                  <?php echo htmlspecialchars($course['firstName'] . ' ' . $course['lastName']); ?>
                </span>
                <span class="text-white">
                  <?php echo date('F j, Y', strtotime($course['post_date'])); ?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php
        // Close the row after 3 cards
        $counter++;
        if ($counter % 3 == 0) {
            echo '</div>';  // Close the div for the row
        }
    } // End of while loop

    // If the last row has fewer than 3 cards, close the remaining row div
    if ($counter % 3 != 0) {
        echo '</div>';  // Close the div for the last row
    }
    echo '</section>';
}
?>

<script>
// JavaScript to handle video play, stop it, and show message
document.addEventListener('DOMContentLoaded', function() {
    const videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.controls = false;
        video.addEventListener('play', function(event) {
            event.preventDefault();
            const courseId = video.id.split('-')[1];
            const messageDiv = document.getElementById('message-' + courseId);
            messageDiv.classList.remove('hidden');
            setTimeout(function() {
                messageDiv.classList.add('hidden');
            }, 3000);
        });
    });
});
</script>
</section>


<!-- All Instructors -->
<section>
<h2 class="mt-5 mb-5 text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">All Instructors</h2>
<?php
include("database.php");

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Prepare and execute the query to search instructors by name (first name or last name)
$sql = "SELECT user_id, firstName, lastName, email, profile_pic, bio 
        FROM User 
        WHERE role = 'instructor' 
        AND (firstName LIKE ? OR lastName LIKE ?)";
$stmt = $conn->prepare($sql);
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="all-instructor flex flex-wrap justify-center gap-6">';  // Adjusted gap between cards
    
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];

        // Fetch uploaded courses for the instructor
        $course_sql = "SELECT title FROM Course WHERE instructor_id = (
                            SELECT instructor_id FROM Instructor WHERE user_id = ?
                        )";
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
        echo '<div class="bg-[#283747] p-6 shadow-xl w-full max-w-sm rounded-2xl font-sans overflow-hidden">';
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
    echo '<p class="text-center text-gray-500">No instructors found.</p>';
}

$conn->close();
?>

</section>



    </mian>



<script src="js/script.js"></script>



<?php include('footer.php') ?>
      
    </body>
 

    </html>
