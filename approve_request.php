<!DOCTYPE html>
<html lang="en">
<head>
  <?php

  include('head_content.php')
  
  ?> 
</head>
<body>

<header class="mb-5">
  Navigation
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
<div class="instructor-request">
<?php
include("database.php");

$query = "SELECT * FROM User WHERE role = 'instructor' AND is_approved IS NULL";
$result = mysqli_query($conn, $query);
?>

<?php if (mysqli_num_rows($result) == 0): ?>
    <div class="text-center text-gray-500 font-semibold my-10">
        <p>No pending instructor requests at the moment.</p>
    </div>
<?php else: ?>
    <div class="flex flex-wrap justify-center gap-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="w-full sm:w-1/3 lg:w-1/3 p-2">
                <div class="bg-[#283747] shadow-xl rounded-lg py-3">
                    <div class="photo-wrapper p-2">
                        <img class="w-32 h-32 rounded-full mx-auto" src="<?= htmlspecialchars($row['profile_pic']) ?>" alt="Profile">
                    </div>
                    <div class="p-2">
                        <h3 class="text-center font-extrabold text-3xl text-white font-3 leading-8"><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></h3>
                        <div class="text-center text-white text-xs font-semibold">
                            <p>Pending Instructor</p>
                        </div>
                        <table class="text-xs my-3">
                            <tbody>
                                <tr>
                                    <td class="px-2 py-2 text-white font-semibold">Email</td>
                                    <td class="px-2 py-2"><?= htmlspecialchars($row['email']) ?></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 text-white font-semibold">Bio</td>
                                    <td class="px-2 py-2"><?= htmlspecialchars($row['bio']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-center my-3">
                            <form action="process_request.php" method="post" class="inline">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-outline btn-success">Confirm</button>
                            </form>
                            <form action="process_request.php" method="post" class="inline">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                <button type="submit" name="action" value="reject" class="btn btn-outline btn-error">Reject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>
</div>

</div>

</div>
</main>


</body>
</html>