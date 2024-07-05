<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../views/login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address']));
    $nationality = htmlspecialchars(trim($_POST['nationality']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $state = htmlspecialchars(trim($_POST['state']));
    $profile_image = null;

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check === false) {
            die("File is not an image.");
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Check file size
        if ($_FILES["profile_image"]["size"] > 5000000) {
            die("Sorry, your file is too large.");
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $profile_image = basename($_FILES["profile_image"]["name"]);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }

    $conn = new mysqli('localhost', 'root', '', 'bcapp');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($profile_image) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, profile_image = ?, address = ?, nationality = ?, telephone = ?, state = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $name, $email, $profile_image, $address, $nationality, $telephone, $state, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, nationality = ?, telephone = ?, state = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $email, $address, $nationality, $telephone, $state, $user_id);
    }

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    $_SESSION['user_name'] = $name;

    header("Location: ../users/user_dashboard.php");
    exit();
}
?>
