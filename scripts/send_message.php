<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = intval($_POST['post_id']);
    $sender_id = $_SESSION['user_id'];
    $receiver_id = intval($_POST['receiver_id']);
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($message)) {
        die("Message cannot be empty");
    }

    $conn = new mysqli('localhost', 'root', '', 'bcapp');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO messages (post_id, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $post_id, $sender_id, $receiver_id, $message);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
