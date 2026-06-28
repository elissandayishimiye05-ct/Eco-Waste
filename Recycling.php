<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EcoWaste Recycling Panel</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background: #198754;
            color: white;
            position: fixed;
            width: 230px;
            padding-top: 15px;
        }

        .sidebar img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid white;
            object-fit: cover;
        }

        .sidebar h5 {
            margin-top: 10px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }

        .sidebar a:hover {
            background: #145c3a;
            border-radius: 5px;
        }

        /* Main */
        .main {
            margin-left: 240px;
            padding: 20px;
        }

        .card-box {
            border: none;
            border-radius: 12px;
        }
    </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar text-center">

    <!-- LOGO -->
    <img src="eco.png" alt="EcoWaste Logo">

    <h5>EcoWaste</h5>
    <small>Recycling Panel</small>

    <hr>

    <a href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="#"><i class="bi bi-recycle"></i> Recyclable Materials</a>
    <a href="#"><i class="bi bi-box-seam"></i> Stock Processing</a>
    <a href="#"><i class="bi bi-bar-chart"></i> Reports</a>
    <a href="login.html"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main">

    <h2>Recycling Dashboard</h2>
    <p class="text-muted">Welcome, Recycler ♻️</p>

    <!-- Cards -->
    <div class="row">

        <div class="col-md-4">
            <div class="card card-box shadow-sm p-3">
                <h5>Recyclable Items</h5>
                <h3>85</h3>
                <i class="bi bi-recycle fs-2 text-success"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box shadow-sm p-3">
                <h5>Processed</h5>
                <h3>60</h3>
                <i class="bi bi-check-circle fs-2 text-primary"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-box shadow-sm p-3">
                <h5>Pending Sorting</h5>
                <h3>25</h3>
                <i class="bi bi-hourglass-split fs-2 text-warning"></i>
            </div>
        </div>

    </div>

    <!-- Table -->
    <div class="card mt-4 shadow-sm p-3">
        <h5>Recycling Activity</h5>

        <table class="table table-striped">
            <tr>
                <th>Material</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Plastic</td>
                <td>120 kg</td>
                <td><span class="badge bg-warning">Sorting</span></td>
            </tr>
            <tr>
                <td>Paper</td>
                <td>80 kg</td>
                <td><span class="badge bg-success">Processed</span></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>