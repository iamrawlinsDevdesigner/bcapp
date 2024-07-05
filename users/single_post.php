<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: user_dashboard.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'bcapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = intval($_GET['id']);
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    $conn->close();
    header("Location: user_dashboard.php");
    exit();
}

$post = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <img src="../assets/images/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="w-full h-64 object-cover rounded-md mb-4">
            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($post['title']); ?></h1>
            <p class="text-xl text-gray-700 mb-4">$<?php echo number_format($post['price'], 2); ?></p>
            <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($post['description']); ?></p>
            <p class="text-gray-600 mb-4"><strong>Condition:</strong> <?php echo htmlspecialchars($post['condition']); ?></p>
            <?php if (!empty($post['size'])): ?>
                <p class="text-gray-600 mb-4"><strong>Size:</strong> <?php echo htmlspecialchars($post['size']); ?></p>
            <?php endif; ?>
            <a href="user_dashboard.php" class="text-blue-500 hover:underline">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
