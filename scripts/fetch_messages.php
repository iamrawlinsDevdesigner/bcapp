<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$post_id = intval($_GET['post_id']);
$user_id = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'bcapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM messages WHERE post_id = ? ORDER BY timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($messages);
?>
