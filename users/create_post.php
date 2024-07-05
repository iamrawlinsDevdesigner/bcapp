<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Post</h2>
        <form action="../scripts/create_post.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                <select id="category" name="category" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Food">Food</option>
                    <option value="Fashion">Fashion</option>
                    <option value="Electronics">Electronics</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-bold mb-2">Image</label>
                <input type="file" id="image" name="image" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
                <input type="number" id="price" name="price" step="0.01" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea id="description" name="description" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="item_condition" class="block text-gray-700 font-bold mb-2">Condition</label>
                <select id="condition" name="condition" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Size (for Fashion items)</label>
                <div class="flex flex-wrap">
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="XS" class="mr-2"> XS
                    </label>
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="S" class="mr-2"> S
                    </label>
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="M" class="mr-2"> M
                    </label>
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="L" class="mr-2"> L
                    </label>
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="XL" class="mr-2"> XL
                    </label>
                    <label class="mr-4">
                        <input type="checkbox" name="size[]" value="XXL" class="mr-2"> XXL
                    </label>
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Create Post</button>
        </form>
        <a href="user_dashboard.php" class="block text-center text-blue-500 hover:underline mt-4">Back to Dashboard</a>
    </div>
</body>
</html>
