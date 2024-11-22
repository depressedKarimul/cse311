<!DOCTYPE html>
<html lang="en">
<head>
  <?php

  include('head_content.php')
  
  ?>
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
<h2 class="text-center text-4xl text-white bg-[#283747] p-5 font-extrabold" >Authorize Instructor Request</h2>

<div class="instructor-request">
<?php
include("database.php");

// Fetch pending instructor requests
$sql = "SELECT user_id, firstName, lastName, profile_pic, email, bio FROM User WHERE role = 'instructor_pending'";
$result = $conn->query($sql);

// Check for errors in the query
if (!$result) {
    die("Error fetching data: " . $conn->error);
}
?>

<div class="flex flex-wrap justify-center gap-4">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="w-full sm:w-1/2 lg:w-1/3 p-2">
                <div class="bg-white shadow-xl rounded-lg py-3">
                    <div class="photo-wrapper p-2">
                        <img class="w-32 h-32 rounded-full mx-auto" src="<?= htmlspecialchars($row['profile_pic'] ?: 'default-profile.png'); ?>" alt="Profile">
                    </div>
                    <div class="p-2">
                        <h3 class="text-center text-xl text-gray-900 font-medium leading-8"><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?></h3>
                        <div class="text-center text-gray-400 text-xs font-semibold">
                            <p>Pending Instructor</p>
                        </div>
                        <table class="text-xs my-3">
                            <tbody>
                                <tr><td class="px-2 py-2 text-gray-500 font-semibold">Email</td><td class="px-2 py-2"><?= htmlspecialchars($row['email']); ?></td></tr>
                                <tr><td class="px-2 py-2 text-gray-500 font-semibold">Bio</td><td class="px-2 py-2"><?= htmlspecialchars($row['bio']); ?></td></tr>
                            </tbody>
                        </table>

                        <div class="text-center my-3">
                            <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="user_id" value="<?= $row['user_id']; ?>">
                                <input type="hidden" name="bio" value="<?= htmlspecialchars($row['bio']); ?>">
                                <button type="submit" name="confirm" class="btn btn-outline btn-success">Confirm</button>
                                <button type="submit" name="reject" class="btn btn-outline btn-error">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center text-gray-500 text-xl">No requests yet. Please check back later. We're waiting for new instructors to join!</p>
    <?php endif; ?>
</div>

<?php
// Handle confirmation or rejection
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Debugging: Check POST data
    var_dump($_POST);  // This will print POST data

    $user_id = $_POST['user_id'];

    if (isset($_POST['confirm'])) {
        $expertise = $_POST['bio'];

        // Insert into Instructor table
        $stmt = $conn->prepare("INSERT INTO Instructor (user_id, expertise) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $expertise);

        if ($stmt->execute()) {
            // Update User role to 'instructor'
            $stmt = $conn->prepare("UPDATE User SET role = 'instructor' WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {
                echo "<p class='text-center text-green-500'>Instructor request confirmed!</p>";
            } else {
                echo "<p class='text-center text-red-500'>Error updating user role. Please try again.</p>";
            }
        } else {
            echo "<p class='text-center text-red-500'>Error confirming request. Please try again.</p>";
        }
    } elseif (isset($_POST['reject'])) {
        // Delete the user if rejected
        $stmt = $conn->prepare("DELETE FROM User WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo "<p class='text-center text-red-500'>Instructor request rejected.</p>";
        } else {
            echo "<p class='text-center text-red-500'>Error rejecting request. Please try again.</p>";
        }
    }

    // Redirect to the same page to refresh the list after action
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$conn->close();
?>

</div>
</main>


</body>
</html>