<?php
include "Connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: CreateAccount.php");
    exit();
}

$fullname = $_POST['fullname'] ?? '';
$email    = $_POST['email'] ?? '';
$phone    = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

// DEFAULT ROLE (you can change later)
$role = "resident";

// HASH PASSWORD (IMPORTANT for your login system)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if user already exists
$check = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($check);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Email already exists'); window.location='CreateAccount.php';</script>";
    exit();
}

// INSERT USER
$sql = "INSERT INTO users (fullname, email, phone, password, role, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $fullname, $email, $phone, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "<script>alert('Account created successfully'); window.location='Login.php';</script>";
} else {
    echo "<script>alert('Error creating account'); window.location='CreateAccount.php';</script>";
}
?>