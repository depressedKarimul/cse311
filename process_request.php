<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $sql = "UPDATE User SET is_approved = 1 WHERE user_id = ?";
    } elseif ($action === 'reject') {
        $sql = "DELETE FROM User WHERE user_id = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    header("Location: approve_request.php");
    exit();
}
?>
