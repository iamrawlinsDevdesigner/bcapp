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
    <title>View Posts</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/toggle_view.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">My Posts</h1>
            <div class="flex space-x-2">
                <button id="grid-view" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Grid View</button>
                <button id="list-view" class="bg-gray-500 text-white px-4 py-2 rounded-lg">List View</button>
            </div>
        </div>
        <div id="posts-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Posts will be inserted here by jQuery -->
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $.getJSON('../scripts/fetch_posts.php', function(data) {
                $.each(data, function(key, post) {
                    $('#posts-container').append(`
                        <div class="post-card bg-white p-4 rounded-lg shadow-md">
                            <img src="../assets/images/${post.image}" alt="${post.title}" class="w-full h-48 object-cover rounded-md mb-4">
                            <h2 class="text-lg font-bold mb-2">${post.title}</h2>
                            <p class="text-gray-600">$${post.price}</p>
                            <a href="single_post.php?id=${post.id}" class="text-blue-500 hover:underline">View Details</a>
                        </div>
                    `);
                });
            });

            $('#grid-view').click(function() {
                $('#posts-container').removeClass('list-view').addClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4');
            });

            $('#list-view').click(function() {
                $('#posts-container').removeClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4').addClass('list-view');
            });
        });
    </script>
    <style>
        .list-view .post-card {
            display: flex;
            align-items: center;
        }
        .list-view .post-card img {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }
        .list-view .post-card h2 {
            margin: 0;
        }
        .list-view .post-card p {
            margin-top: 10px;
        }
    </style>
</body>
</html>
