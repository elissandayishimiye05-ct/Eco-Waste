<?php
include "Connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate required fields
    if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
        die("All required fields must be filled!");
    }

    // Hash password (SECURITY IMPORTANT)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        die("Email already exists!");
    }

    // Insert user
    $sql = "INSERT INTO users (fullname, email, phone, password, role)
            VALUES ('$fullname', '$email', '$phone', '$hashedPassword', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: users.php?msg=User created successfully");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>