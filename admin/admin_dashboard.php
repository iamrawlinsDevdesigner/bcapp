<?php
// Start a new session
session_start();
// Check if the user is not logged in or is not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    // Redirect to the login page
    header("Location: ../views/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Dashboard</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        <a href="../users/logout.php" class="text-blue-500 hover:underline">Logout</a>
    </div>
</body>
</html>
