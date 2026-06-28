<?php
// 1. Initialize the session
session_start();

// 2. Unset all session variables
$_SESSION = array();

// 3. Delete the session cookie if it exists (highly recommended for security)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destroy the session on the server
session_destroy();

// 5. Redirect to the login page (change 'login.php' to your actual login filename)
header("Location: login.php");
exit;
?>