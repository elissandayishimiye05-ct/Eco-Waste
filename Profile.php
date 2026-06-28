<?php
include('Connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Upgraded backend to use secure prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EcoWaste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f5; font-family: 'Segoe UI', system-ui, sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
        .app-logo { height: 40px; width: auto; object-fit: contain; }
        
        /* Modern Profile Specific Styles */
        .avatar-container {
            position: relative;
            display: inline-block;
        }
        .avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .profile-field {
            background: #fff;
            border: 1px solid #eaeaea;
            border-radius: 12px;
            padding: 14px 16px;
            transition: all 0.2s ease;
        }
        .profile-field:hover {
            border-color: #a3cfbb;
            background: #fafdfb;
        }
        .role-badge {
            background-color: #e8f5e9;
            color: #2e7d32;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<!-- Unified System Navbar Header -->
<nav class="navbar navbar-dark bg-success shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="eco.png" alt="Eco Logo" class="app-logo">
            <span class="fw-bold tracking-wide">EcoWaste Management</span>
        </a>
    </div>
</nav>

<div class="container">
    <!-- Back to Dashboard Control -->
    <a href="Resident.php" class="btn btn-dark btn-sm rounded-pill px-3 mb-4">⬅ Dashboard</a>

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            
            <div class="card p-4 mb-4">
                <!-- Header Info -->
                <div class="text-center pb-3 border-bottom mb-4">
                    <div class="avatar-container mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="avatar" alt="User Profile Image Avatar">
                    </div>
                    <h3 class="fw-bold text-dark m-0"><?= htmlspecialchars($user['fullname']); ?></h3>
                    <span class="badge role-badge rounded-pill px-3 py-1.5 mt-2 text-uppercase text-xs">
                        <i class="bi bi-shield-check me-1"></i> <?= htmlspecialchars($user['role']); ?> Account
                    </span>
                </div>

                <!-- Structured Profile Parameters Feed -->
                <div class="d-flex flex-column gap-3">
                    
                    <div class="profile-field d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-success fs-4"><i class="bi bi-person-fill-lock"></i></div>
                            <div>
                                <span class="text-muted d-block small fw-bold">System Identifier ID</span>
                                <span class="text-secondary font-monospace">#<?= htmlspecialchars($user['user_id']); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="profile-field d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-success fs-4"><i class="bi bi-envelope-at-fill"></i></div>
                            <div>
                                <span class="text-muted d-block small fw-bold">Email Address</span>
                                <strong class="text-dark fw-medium"><?= htmlspecialchars($user['email']); ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="profile-field d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-success fs-4"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <span class="text-muted d-block small fw-bold">Mobile Line Connection</span>
                                <span class="text-secondary"><?= htmlspecialchars($user['phone']); ?></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Security Action Options Tray -->
                <div class="mt-4 pt-2">
                    <a href="change_password.php" class="btn btn-success w-100 py-2.5 rounded-3 fw-bold shadow-sm">
                        <i class="bi bi-key-fill me-1"></i> Manage Password Credentials
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>