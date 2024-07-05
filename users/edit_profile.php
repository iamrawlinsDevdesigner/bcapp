<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'bcapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT name, email, profile_image, address, nationality, telephone, state FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $profile_image, $address, $nationality, $telephone, $state);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Profile</h2>
        <form action="../scripts/update_profile.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="profile_image" class="block text-gray-700 font-bold mb-2">Profile Image</label>
                <input type="file" id="profile_image" name="profile_image" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <?php if ($profile_image): ?>
                    <img src="../assets/images/<?php echo htmlspecialchars($profile_image); ?>" alt="Profile Image" class="mt-4 w-32 h-32 object-cover rounded-full mx-auto">
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="nationality" class="block text-gray-700 font-bold mb-2">Nationality</label>
                <input type="text" id="nationality" name="nationality" value="<?php echo htmlspecialchars($nationality); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="telephone" class="block text-gray-700 font-bold mb-2">Telephone</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="state" class="block text-gray-700 font-bold mb-2">State</label>
                <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($state); ?>" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Update Profile</button>
        </form>
        <a href="user_dashboard.php" class="block text-center text-blue-500 hover:underline mt-4">Back to Dashboard</a>
    </div>
</body>
</html>
