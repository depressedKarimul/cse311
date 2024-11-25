<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skill Pro</title>

  <link rel="stylesheet" href="Styles/styles.css">
  <link rel="stylesheet" href="Styles/Nav.css" />
  <link rel="stylesheet" href="Styles/allCourses.css">

  <!-- Tailwind and DaisyUI -->
  <link
    href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css"
    rel="stylesheet"
    type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />

  <!-- Tailwind Custom Color -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            clifford: "#da373d",
          },
        },
      },
    };
  </script>
</head>

<body>

  <?php
  // Database connection
  include('database.php');

  // Query to fetch course details and video content
  $sql = "
      SELECT 
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
  ";

  $result = $conn->query($sql);
  ?>

  <div class="flex flex-wrap justify-center">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
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
          </div>
          <div class="pl-6 pb-6 flex justify-around">
            <button class="btn btn-info">Edit</button>
            <button class="btn btn-error">Delete</button>
          </div>
        </div>
    <?php
      }
    } else {
      echo '<p>No courses available.</p>';
    }
    ?>
  </div>


</body>

</html>