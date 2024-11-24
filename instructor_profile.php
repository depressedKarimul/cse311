<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head_content.php'); ?>
</head>
<body class="text-gray-900">

<?php
include("database.php");
session_start();

// Assuming the user is logged in and the user_id is stored in the session
$user_id = $_SESSION['user_id'];

// Query to fetch user and instructor data including instructor_id
$query = "
    SELECT u.firstName, u.lastName, u.email, u.profile_pic, u.bio, i.expertise, i.total_courses, i.instructor_id
    FROM User u
    LEFT JOIN Instructor i ON u.user_id = i.user_id
    WHERE u.user_id = $user_id
";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the user data
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['firstName'];
    $lastName = $row['lastName'];
    $email = $row['email'];
    $profile_pic = $row['profile_pic'] ? $row['profile_pic'] : 'https://source.unsplash.com/MP0IUfwrn0A'; // Default pic if no profile pic is found
    $bio = $row['bio'];
    $expertise = $row['expertise'];
    $total_courses = $row['total_courses'];
    $instructor_id = $row['instructor_id']; // Fetching instructor_id
} else {
    echo "No data found for this user.";
    exit();
}
?>
<div class="font-sans antialiased text-white leading-normal tracking-wider bg-cover"
    style="background-image:url('https://source.unsplash.com/1L71sPT5XKc');">
    <div class="max-w-4xl flex items-center h-auto lg:h-screen flex-wrap mx-auto my-32 lg:my-0">
        <!--Main Col-->
        <div id="profile"
            class="w-full lg:w-3/5 rounded-lg lg:rounded-l-lg lg:rounded-r-none shadow-2xl bg-[#283747] opacity-75 mx-6 lg:mx-0 h-full">
            <div class="p-4 md:p-12 text-center lg:text-left">
                <!-- Image for mobile view-->
                <div class="block lg:hidden rounded-full shadow-xl mx-auto -mt-16 h-48 w-48 bg-cover bg-center"
                    style="background-image: url('<?php echo $profile_pic; ?>')"></div>

                <h1 class="text-3xl font-bold pt-8 lg:pt-0 text-white"><?php echo $firstName . " " . $lastName; ?></h1>
                <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-green-500 opacity-25">
                    Instructor ID: <?php echo $instructor_id ? $instructor_id : "Not yet assigned"; ?>
                </div>
                <div class="mx-auto lg:mx-0 w-4/5 pt-3 border-b-2 border-green-500 opacity-25">
                    User ID: <?php echo $user_id; ?>
                </div>
                <p class="pt-4 text-base font-bold flex items-center justify-center lg:justify-start">
                    <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z" />
                    </svg> Expertise: <?php echo $expertise ? $expertise : "Not set"; ?>
                </p>
                <p class="pt-2 text-white text-xs lg:text-sm flex items-center justify-center lg:justify-start">
                    <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm7.75-8a8.01 8.01 0 0 0 0-4h-3.82a28.81 28.81 0 0 1 0 4h3.82zm-.82 2h-3.22a14.44 14.44 0 0 1-.95 3.51A8.03 8.03 0 0 0 16.93 14zm-8.85-2h3.84a24.61 24.61 0 0 0 0-4H8.08a24.61 24.61 0 0 0 0 4zm.25 2c.41 2.4 1.13 4 1.67 4s1.26-1.6 1.67-4H8.33zm-6.08-2h3.82a28.81 28.81 0 0 1 0-4H2.25a8.01 8.01 0 0 0 0 4zm.82 2a8.03 8.03 0 0 0 4.17 3.51c-.42-.96-.74-2.16-.95-3.51H3.07zm13.86-8a8.03 8.03 0 0 0-4.17-3.51c.42.96.74 2.16.95 3.51h3.22zm-8.6 0h3.34c-.41-2.4-1.13-4-1.67-4S8.74 3.6 8.33 6zM3.07 6h3.22c.2-1.35.53-2.55.95-3.51A8.03 8.03 0 0 0 3.07 6z" />
                    </svg> Total Courses: <?php echo $total_courses ? $total_courses : "Not set"; ?>
                </p>
                <p class="pt-8 text-sm flex items-center justify-center lg:justify-start text-white">
                    <svg class="h-4 fill-current text-green-700 pr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                            d="M10 2a8 8 0 0 1 8 8c0 1.5-.5 2.9-1.4 4.1L12 10.3V13H8V7h5V2z"/>
                    </svg>
                    Bio: <?php echo $bio ? $bio : "No bio available."; ?>
                </p>

                <div class="pt-12 pb-8">
    <a href="mailto:<?php echo $email; ?>" class="block">
        <button class="bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded-full">
            Email: <?php echo $email; ?>
        </button>
    </a>
</div>

            </div>
        </div>

        <!-- Img Col-->
        <div class="w-full lg:w-2/5 h-full">
            <img src="Upload Photos/zara.jpg" class="rounded-none lg:rounded-lg shadow-2xl hidden lg:block h-full object-cover">
        </div>

        

</body>
</html>
