<?php
// Start session to access session variables
session_start();

// Check if user is logged in and has user role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

// Check if post ID is set in the URL
if (!isset($_GET['id'])) {
    header("Location: user_dashboard.php");
    exit();
}

// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'bcapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve post details
$post_id = intval($_GET['id']);
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if post exists
if ($result->num_rows == 0) {
    $stmt->close();
    $conn->close();
    header("Location: user_dashboard.php");
    exit();
}

// Fetch post details
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
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

        <!-- Chat Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Chat</h2>
            <div id="chat-box" class="overflow-y-auto h-64 mb-4 bg-gray-100 p-4 rounded-md">
                <!-- Chat messages will be appended here by jQuery -->
            </div>
            <form id="chat-form">
                <input type="hidden" id="post_id" name="post_id" value="<?php echo $post_id; ?>">
                <input type="hidden" id="receiver_id" name="receiver_id" value="<?php echo $post['user_id']; ?>">
                <div class="flex">
                    <input type="text" id="message" name="message" class="flex-1 px-3 py-2 border rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message..." required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">Send</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const postId = $('#post_id').val();

            // Fetch and display chat messages
            function loadChat() {
                $.getJSON('../scripts/fetch_messages.php?post_id=' + postId, function(data) {
                    $('#chat-box').empty();
                    $.each(data, function(key, message) {
                        $('#chat-box').append(`
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">${message.message}</p>
                                <p class="text-xs text-gray-500">${message.timestamp}</p>
                            </div>
                        `);
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                });
            }

            loadChat();

            // Send message
            $('#chat-form').submit(function(event) {
                event.preventDefault();
                const formData = $(this).serialize();
                $.post('../scripts/send_message.php', formData, function(response) {
                    $('#message').val('');
                    loadChat();
                });
            });
        });
    </script>
</body>
</html>
