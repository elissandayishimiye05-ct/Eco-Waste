<?php
include "Connection.php";

/* =======================
   COUNTS FROM DATABASE
======================= */

// Users
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();

// Waste requests
$waste = $conn->query("SELECT COUNT(*) as total FROM waste_requests")->fetch_assoc();

// Recycling materials
$recycling = $conn->query("SELECT COUNT(*) as total FROM recycled_materials")->fetch_assoc();

// Collectors
$collectors = $conn->query("SELECT COUNT(*) as total FROM collectors")->fetch_assoc();

/* =======================
   RECENT ACTIVITY (example)
   (you can replace with real logs table if you have it)
======================= */
$recent = $conn->query("
    SELECT 'User Registered' as action, fullname as user, created_at 
    FROM users
    ORDER BY user_id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>EcoWaste Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }

/* Sidebar */
.sidebar {
    height: 100vh;
    width: 230px;
    background: #198754;
    position: fixed;
    color: white;
    padding-top: 15px;
}

.sidebar img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
}

.sidebar a {
    display:block;
    color:white;
    padding:12px 18px;
    text-decoration:none;
}

.sidebar a:hover {
    background:#145c3a;
}

/* Main */
.main {
    margin-left: 240px;
    padding: 20px;
}

/* Cards */
.card-box {
    border: none;
    border-radius: 12px;
    transition: 0.3s;
}

.card-box:hover {
    transform: translateY(-5px);
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar text-center">

    <img src="eco.png">
    <h5>EcoWaste</h5>
    <small>Admin Panel</small>

    <hr>

    <a href="admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="users.php"><i class="bi bi-people"></i> Users</a>
    <a href="waste_requests.php"><i class="bi bi-trash"></i> Waste Requests</a>
    <a href="collectors.php"><i class="bi bi-person-badge"></i> Collectors</a>
    <a href="recycling_centers.php"><i class="bi bi-recycle"></i> Recycling Centers</a>
    <a href="vehicles.php"><i class="bi bi-truck"></i> Vehicles</a>
    <a href="admin_notifications.php"><i class="bi bi-bell"></i> Notifications</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h2>Admin Dashboard</h2>
<p class="text-muted">Welcome Admin </p>

<!-- CARDS -->
<div class="row g-3">

    <div class="col-md-3">
        <div class="card card-box shadow-sm p-3">
            <h6>Total Users</h6>
            <h3><?= $users['total'] ?></h3>
            <i class="bi bi-people fs-2 text-success"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box shadow-sm p-3">
            <h6>Waste Requests</h6>
            <h3><?= $waste['total'] ?></h3>
            <i class="bi bi-trash fs-2 text-danger"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box shadow-sm p-3">
            <h6>Recycling Records</h6>
            <h3><?= $recycling['total'] ?></h3>
            <i class="bi bi-recycle fs-2 text-primary"></i>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-box shadow-sm p-3">
            <h6>Collectors</h6>
            <h3><?= $collectors['total'] ?></h3>
            <i class="bi bi-person-badge fs-2 text-warning"></i>
        </div>
    </div>

</div>

<!-- RECENT ACTIVITY -->
<div class="card mt-4 shadow-sm p-3">

    <h5>Recent Activity</h5>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $recent->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['user'] ?></td>
                <td><?= $row['action'] ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

</div>

</body>
</html>