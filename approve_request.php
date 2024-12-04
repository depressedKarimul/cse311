<?php
// Start the session and check for admin privileges
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirect to login if not admin
    exit;
}

// Include the database connection file
include_once 'database.php';

// Handle the POST request to approve or reject a user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // 'approve' or 'reject'
    $user_id = intval($_POST['user_id']); // Sanitize user ID
    $admin_id = $_SESSION['user_id']; // Assuming admin's user_id is stored in the session

    if ($action === 'approve') {
        // Approve the instructor request
        $query = "UPDATE User SET is_approved = 1 WHERE user_id = ?";
    } elseif ($action === 'reject') {
        // Reject the instructor request (remove user from the database)
        $query = "DELETE FROM User WHERE user_id = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Insert into Instructor_Approval table
        $approval_status = ($action === 'approve') ? 'approved' : 'rejected';
        $approval_date = date('Y-m-d');
        
        $approval_query = "INSERT INTO Instructor_Approval (admin_id, user_id, approval_status, approval_date) 
                           VALUES (?, ?, ?, ?)";
        $approval_stmt = $conn->prepare($approval_query);
        $approval_stmt->bind_param("iiss", $admin_id, $user_id, $approval_status, $approval_date);

        if ($approval_stmt->execute()) {
            $_SESSION['message'] = $action === 'approve' 
                ? "User has been approved successfully!" 
                : "User has been rejected successfully!";
        } else {
            $_SESSION['error'] = "Failed to record approval status. Please try again.";
        }
        
        $approval_stmt->close();
    } else {
        $_SESSION['error'] = "Failed to process the request. Please try again.";
    }

    $stmt->close();
    header('Location: approve_request.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Instructor Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <main class="min-h-screen p-5">
        <h2 class="text-center text-4xl text-white bg-blue-700 p-5 font-extrabold rounded-md">
            Authorize Instructor Requests
        </h2>

        <div class="container mx-auto mt-10">
            <!-- Display success or error messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
                    <?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
                    <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Fetch pending instructor requests -->
            <?php
            $query = "SELECT * FROM User WHERE role = 'instructor' AND is_approved = 0";
            $result = $conn->query($query);
            ?>

            <?php if ($result->num_rows === 0): ?>
                <p class="text-center text-gray-700 text-lg font-semibold">
                    No pending instructor requests at the moment.
                </p>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="bg-white shadow-md rounded-lg p-5">
                            <div class="flex items-center space-x-4">
                                <img 
                                    src="<?= htmlspecialchars($row['profile_pic']) ?>" 
                                    alt="Profile Picture" 
                                    class="w-20 h-20 rounded-full border-2 border-blue-500">
                                <div>
                                    <h3 class="text-xl font-bold"><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></h3>
                                    <p class="text-sm text-gray-600">Email: <?= htmlspecialchars($row['email']) ?></p>
                                    <p class="text-sm text-gray-600">Bio: <?= htmlspecialchars($row['bio']) ?></p>
                                </div>
                            </div>
                            <div class="mt-4 flex gap-4">
                                <!-- Approve Form -->
                                <form action="approve_request.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                    <button 
                                        type="submit" 
                                        name="action" 
                                        value="approve" 
                                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                        Approve
                                    </button>
                                </form>
                                <!-- Reject Form -->
                                <form action="approve_request.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                    <button 
                                        type="submit" 
                                        name="action" 
                                        value="reject" 
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </main>
</body>
</html>
