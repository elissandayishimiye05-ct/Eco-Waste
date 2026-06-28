<?php
include('Connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

/* =========================
   CHANGE PASSWORD (SECURE)
========================= */
if (isset($_POST['change'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    // Using prepared statements to fetch the user's password securely
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        // Verify the old password against the stored hash
        if (password_verify($old, $row['password'])) {
            
            // Hash the new password before storing it
            $hashedNew = password_hash($new, PASSWORD_DEFAULT);

            // Update using prepared statements
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $update_stmt->bind_param("si", $hashedNew, $user_id);
            
            if ($update_stmt->execute()) {
                $message = "<div class='alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show' role='alert'>
                                <i class='bi bi-check-circle-fill me-2'></i>Password changed successfully.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
            } else {
                $message = "<div class='alert alert-danger border-0 shadow-sm rounded-3 alert-dismissible fade show' role='alert'>
                                <i class='bi bi-exclamation-triangle-fill me-2'></i>An error occurred. Please try again.
                                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                            </div>";
            }
            $update_stmt->close();

        } else {
            $message = "<div class='alert alert-danger border-0 shadow-sm rounded-3 alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i>Old password is incorrect.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
        }
    } else {
        $message = "<div class='alert alert-danger border-0 shadow-sm rounded-3 alert-dismissible fade show' role='alert'>
                        <i class='bi bi-exclamation-triangle-fill me-2'></i>User account not found.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - EcoWaste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f5; font-family: 'Segoe UI', system-ui, sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
        .app-logo { height: 40px; width: auto; object-fit: contain; }
        .user-box {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<!-- Matching Navbar Header from Create Request -->
<nav class="navbar navbar-dark bg-success shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="eco.png" alt="Eco Logo" class="app-logo">
            <span class="fw-bold tracking-wide">EcoWaste Management</span>
        </a>
    </div>
</nav>

<div class="container">
    <!-- Back to Dashboard Navigation -->
    <a href="Resident.php" class="btn btn-dark btn-sm rounded-pill px-3 mb-4">⬅ Dashboard</a>

    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            
            <!-- Dynamic Alert Alerts Area -->
            <?php echo $message; ?>

            <div class="card p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-shield-lock-fill fs-3 text-success"></i>
                    <h4 class="m-0 fw-bold text-success">Update Password</h4>
                </div>
                
                <p class="text-muted small">Ensure your account stays protected by updating your security credentials regularly.</p>

                <div class="user-box d-flex align-items-center gap-2 mb-4 fw-medium">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Logged in User ID: <strong><?= htmlspecialchars($user_id); ?></strong></span>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Old Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary border-end-0 rounded-start-3"><i class="bi bi-lock"></i></span>
                            <input type="password" name="old_password" class="form-control bg-light border-start-0 rounded-end-3" placeholder="Enter current password" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary border-end-0 rounded-start-3"><i class="bi bi-key"></i></span>
                            <input type="password" name="new_password" class="form-control bg-light border-start-0 rounded-end-3" placeholder="Create strong new password" required>
                        </div>
                    </div>

                    <button type="submit" name="change" class="btn btn-success w-100 py-2 rounded-3 fw-bold shadow-sm">
                        Save Security Changes
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>