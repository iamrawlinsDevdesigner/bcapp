<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'bcapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT profile_image, address, nationality, telephone, state FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_image, $address, $nationality, $telephone, $state);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .list-view .card { flex-direction: row; }
        .list-view .card img { width: 150px; height: auto; }
    </style>
</head>
<body>
    <header class="bg-gray-800 text-white p-4">
        <h1 class="text-xl">User Dashboard</h1>
    </header>
    <main class="container mx-auto p-4">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
        <p>This is the user dashboard.</p>
        <div class="mt-4">
            <?php if ($profile_image): ?>
                <img src="../assets/images/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="w-32 h-32 object-cover rounded-full mx-auto">
            <?php endif; ?>
            <p>Address: <?php echo htmlspecialchars($address); ?></p>
            <p>Nationality: <?php echo htmlspecialchars($nationality); ?></p>
            <p>Telephone: <?php echo htmlspecialchars($telephone); ?></p>
            <p>State: <?php echo htmlspecialchars($state); ?></p>
            <a href="edit_profile.php" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 mt-4">Edit Profile</a>
            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 mt-4">Logout</a>
            <a href="create_post.php" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 mt-4">Create New Post</a>
            <a href="view_posts.php" class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">View All Posts</a>
        </div>

                
         

    </main>
   
</body>
</html>
