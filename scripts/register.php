<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Hash the password for security
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Create a new MySQLi connection
    $conn = new mysqli('localhost', 'root', '', 'bcapp');
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    // Bind parameters to the SQL query
    $stmt->bind_param("sss", $name, $email, $password);
    // Execute the query
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the login page after successful registration
    header("Location: ../views/login.html");
    exit();
}
?>
