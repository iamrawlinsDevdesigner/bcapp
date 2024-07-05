<?php
// Start a new session
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create a new MySQLi connection
    $conn = new mysqli('localhost', 'root', '', 'bcapp');
    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    // Bind parameters to the SQL query
    $stmt->bind_param("s", $email);
    // Execute the query
    $stmt->execute();
    // Bind the result to variables
    $stmt->bind_result($id, $name, $hashed_password, $role);
    // Fetch the result
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Set session variables
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        // Redirect based on user role
        if ($role == 'admin') {
            header("Location: ../admin/admin_dashboard.php");
        } else {
            header("Location: ../users/user_dashboard.php");
        }
        exit();
    } else {
        // Display an error message for invalid credentials
        echo "Invalid email or password";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
