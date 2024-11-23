<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'];

    if ($action === "approve") {
        $query = "UPDATE User SET is_approved = 1 WHERE user_id = $user_id";
    } elseif ($action === "reject") {
        $query = "DELETE FROM User WHERE user_id = $user_id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: approve_request.php");
        exit();
    } else {
        echo "Error processing request.";
    }
}
?>
