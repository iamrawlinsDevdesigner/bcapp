<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $category = htmlspecialchars(trim($_POST['category']));
    $title = htmlspecialchars(trim($_POST['title']));
    $price = filter_var(trim($_POST['price']), FILTER_VALIDATE_FLOAT);
    $description = htmlspecialchars(trim($_POST['description']));
    $condition = htmlspecialchars(trim($_POST['item_condition']));
    $sizes = isset($_POST['size']) ? $_POST['size'] : [];
    $sizes = implode(',', $sizes);
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Check file size (allowing up to 2MB)
        if ($_FILES["image"]["size"] > 2000000) { // 2MB = 2,000,000 bytes
            die("Sorry, your file is too large.");
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    $conn = new mysqli('localhost', 'root', '', 'bcapp');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO posts (user_id, category, image, title, price, description, item_condition, size) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdssss", $user_id, $category, $image, $title, $price, $description, $condition, $sizes);

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    header("Location: ../users/user_dashboard.php");
    exit();
}
?>
