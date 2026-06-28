<?php
session_start();
include "Connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Login.php");
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email = ? OR fullname = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        // ROLE REDIRECT
        switch ($user['role']) {

            case "admin":
                header("Location:   Admin.php");
                break;

            case "collector":
                header("Location: Collector.php");
                break;

            case "recycling":
                header("Location: Recycling.php");
                break;

            case "resident":
                header("Location: Resident.php");
                break;

            default:
                echo "Invalid role";
        }

        exit();

    } else {
        echo "<script>alert('Wrong password'); window.location='Login.php';</script>";
    }

} else {
    echo "<script>alert('User not found'); window.location='Login.php';</script>";
}
?>