<!DOCTYPE html>
<html lang="en" >
<head>
<?php include('head_content.php') ?>
</head>
<body>

<header class="mb-5">
  <!-- Navigation -->
   <nav>
   <div class="navbar bg-base-100">
  <div class="navbar-start">
    <div class="dropdown bg-[#1D232A]">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
        <li><a>Homepage</a></li>
        <li><a>Portfolio</a></li>
        <li><a>About</a></li>
      </ul>
    </div>
  </div>
  <div class="navbar-center">
    <a class="btn btn-ghost text-xl">SkillPro Admin Panel</a>
  </div>
  <div class="navbar-end">
    <button class="btn btn-ghost btn-circle">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
      </svg>
    </button>
    <a href="approve_request.php"  class="btn btn-ghost btn-circle">
      <div class="indicator">
        
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-5 w-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="badge badge-xs badge-primary indicator-item"></span>
      </div>
    </a>
  </div>
</div>
   </nav>


   


</header>


<main>

<h2 class="text-center text-4xl text-white bg-[#283747] p-5 font-extrabold" >All Students</h2>

<div class="all-student mt-6">

<?php
include("database.php");

// Fetch all students
$sql = "SELECT firstName, lastName, email, profile_pic, bio FROM User WHERE role = 'student'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="all-student flex flex-wrap justify-center gap-4">';
    $count = 0;

    while ($row = $result->fetch_assoc()) {
        // Start a new row after every 3 cards
        if ($count % 3 === 0 && $count !== 0) {
            echo '<div class="w-full"></div>';
        }

        // Display the student card
        echo '<div class="bg-[#283747] p-6 shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] w-full max-w-sm rounded-2xl font-[sans-serif] overflow-hidden">';
        echo '<div class="flex flex-col items-center">';
        echo '<div class="min-h-[110px]">';
        echo '<img src="' . htmlspecialchars($row["profile_pic"] ?: "default-profile.png") . '" class="w-28 h-w-28 rounded-full" />';
        echo '</div>';
        echo '<div class="mt-4 text-center">';
        echo '<p class="text-lg text-white font-bold">' . htmlspecialchars($row["firstName"] . " " . $row["lastName"]) . '</p>';
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["email"]) . '</p>'; // Add email here
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["bio"]) . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $count++;
    }

    echo '</div>';
} else {
    echo '<p class="text-center text-gray-500">No students found.</p>';
}

$conn->close();
?>
</div>



<!-- All Instructors -->


<h2 class="mt-5 text-center text-4xl text-white bg-[#283747] p-5 font-extrabold">All Instructors</h2>


<div class="all-student mt-6">

<?php
include("database.php");

// Fetch all students
$sql = "SELECT firstName, lastName, email, profile_pic, bio FROM User WHERE role = 'instructor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="all-student flex flex-wrap justify-center gap-4">';
    $count = 0;

    while ($row = $result->fetch_assoc()) {
        // Start a new row after every 3 cards
        if ($count % 3 === 0 && $count !== 0) {
            echo '<div class="w-full"></div>';
        }

        // Display the student card
        echo '<div class="bg-[#283747] p-6 shadow-[0_4px_12px_-5px_rgba(0,0,0,0.4)] w-full max-w-sm rounded-2xl font-[sans-serif] overflow-hidden">';
        echo '<div class="flex flex-col items-center">';
        echo '<div class="min-h-[110px]">';
        echo '<img src="' . htmlspecialchars($row["profile_pic"] ?: "default-profile.png") . '" class="w-28 h-w-28 rounded-full" />';
        echo '</div>';
        echo '<div class="mt-4 text-center">';
        echo '<p class="text-lg text-white font-bold">' . htmlspecialchars($row["firstName"] . " " . $row["lastName"]) . '</p>';
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["email"]) . '</p>'; // Add email here
        echo '<p class="text-sm text-white mt-1">' . htmlspecialchars($row["bio"]) . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $count++;
    }

    echo '</div>';
} else {
    echo '<p class="text-center text-gray-500">No Instructor Found.</p>';
}

$conn->close();
?>
</div>






</main>


  
</body>
</html>