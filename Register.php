<?php
include("database.php");
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password securely
    $profile_pic = $_POST["profile_pic"];
    $bio = filter_input(INPUT_POST, "bio", FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate input fields
    if (empty($firstName)) $errors[] = "First Name is required.";
    if (empty($lastName)) $errors[] = "Last Name is required.";
    if (empty($email)) {
        $errors[] = "Email is required.";
    } else {
        // Check if email already exists
        $query = "SELECT email FROM User WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $errors[] = "This email is already registered.";
        }
    }
    if (empty($password)) $errors[] = "Password is required.";
    if (empty($role)) $errors[] = "Role is required.";

    // If no errors, proceed with the database insertion
    if (empty($errors)) {
        $sql = "INSERT INTO User (firstName, lastName, email, password, role, profile_pic, bio) 
                VALUES ('$firstName','$lastName','$email','$hashedPassword', '$role', '$profile_pic', '$bio')";
      $successMessage = ""; // Initialize variable for success message

      try {
          mysqli_query($conn, $sql);
          $successMessage = "You are now registered!";

          header("Location: login.php");
      } catch (mysqli_sql_exception $e) {
          $errors[] = "Error: Could not register user. Please try again.";
      }
      
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1689443111130-6e9c7dfd8f9e?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-3xl bg-blue-950 bg-opacity-70 border-2 border-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-white mb-6">User Registration</h2>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
            <div>
                <label for="firstName" class="block text-white font-medium">First Name</label>
                <input type="text" name="firstName" id="firstName" 
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md placeholder-gray-300 focus:outline-none focus:ring focus:ring-white">
            </div>
            <div>
                <label for="lastName" class="block text-white font-medium">Last Name</label>
                <input type="text" name="lastName" id="lastName" 
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md placeholder-gray-300 focus:outline-none focus:ring focus:ring-white">
            </div>
            <div>
                <label for="email" class="block text-white font-medium">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md placeholder-gray-300 focus:outline-none focus:ring focus:ring-white">
            </div>
            <div>
                <label for="password" class="block text-white font-medium">Password</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md placeholder-gray-300 focus:outline-none focus:ring focus:ring-white">
            </div>
            <div>
                <label for="role" class="block text-white font-medium">Role</label>
                <select name="role" id="role" 
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md focus:outline-none focus:ring focus:ring-white">
                    <option value="" class="bg-gray-900">Select Role</option>
                    <option value="student" class="bg-gray-900">Student</option>
                    <option value="instructor" class="bg-gray-900">Instructor</option>
                   
                </select>
            </div>
            <div>
                <label for="profile_pic" class="block text-white font-medium">Profile Picture</label>
                <input type="file" name="profile_pic" id="profile_pic"
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md focus:outline-none focus:ring focus:ring-white">
            </div>
            <div>
                <label for="bio" class="block text-white font-medium">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                    class="w-full px-4 py-3 border border-white bg-transparent text-white rounded-md placeholder-gray-300 focus:outline-none focus:ring focus:ring-white"></textarea>
            </div>
            <div>
                <button type="submit"
                    name="submit" class="w-full px-6 py-3 text-lg font-medium text-blue-500 bg-white rounded-md hover:bg-gray-200 focus:outline-none focus:ring focus:ring-blue-300">
                    Register
                </button>
            </div>

            <!-- Success Messages -->

            

            <?php if (!empty($successMessage)): ?>
    <div class="mt-4 text-green-500">
        <p><?= $successMessage ?></p>
    </div>
<?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="mt-4 text-red-500">
                    <?php foreach ($errors as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
