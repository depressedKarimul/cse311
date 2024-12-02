<?php

session_start();
include('database.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $review_date = date('Y-m-d');

    // Insert review into the database, including user_id
    $query = "INSERT INTO course_reviews (course_id, user_id, rating, comment, review_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiss", $course_id, $user_id, $rating, $comment, $review_date);
    if ($stmt->execute()) {
        $message = "Review submitted successfully!";
    } else {
        $message = "Failed to submit review.";
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
<div class="bg-[#1D232A] flex items-center justify-center min-h-screen">

    <div class="bg-[#253240] shadow-lg rounded-lg p-8 w-96">
        <h1 class="text-2xl font-bold text-center mb-6">Submit Your Review</h1>

        <form method="POST" action="">
            <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">

            <label for="rating" class="block text-white font-semibold mb-2">Rating:</label>
            <div class="star-rating flex justify-center mb-4">
                <input type="radio" name="rating" value="1" id="star1" class="hidden" required>
                <label for="star1" class="text-white">&#9733;</label>
                <input type="radio" name="rating" value="2" id="star2" class="hidden">
                <label for="star2" class="text-white">&#9733;</label>
                <input type="radio" name="rating" value="3" id="star3" class="hidden">
                <label for="star3" class="text-white">&#9733;</label>
                <input type="radio" name="rating" value="4" id="star4" class="hidden">
                <label for="star4" class="text-white">&#9733;</label>
                <input type="radio" name="rating" value="5" id="star5" class="hidden">
                <label for="star5" class="text-white">&#9733;</label>
            </div>

            <label for="comment" class="block text-white font-semibold mb-2">Comment:</label>
            <textarea name="comment" id="comment" rows="4" class="w-full border-gray-300 rounded-lg p-2 mb-4 focus:ring-2 focus:ring-blue-500" required></textarea>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Submit Review
            </button>
        </form>
        
        <p class="mt-4 text-center text-[#0ff639]">
            <?php echo isset($message) ? $message : ''; ?>
        </p>
    </div>

    <script>
        // JavaScript for interactive star rating
        const stars = document.querySelectorAll('.star-rating label');
        stars.forEach(star => {
            star.addEventListener('click', (e) => {
                const rating = e.target.getAttribute('for').replace('star', '');
                document.querySelector('input[name="rating"][value="' + rating + '"]').checked = true;
                updateStarRating(rating);
            });
        });

        // Function to highlight the stars based on the rating selected
        function updateStarRating(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-400');
                } else {
                    star.classList.add('text-gray-400');
                    star.classList.remove('text-yellow-400');
                }
            });
        }
    </script>

</body>
</body>
   
</html>
