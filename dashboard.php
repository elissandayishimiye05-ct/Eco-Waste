<!DOCTYPE html>
<html>
<head>
    <title>Collector Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Segoe UI, sans-serif;
        }

        body{
            background:#f4f6f9;
        }

        /* Sidebar */
        .sidebar{
            position:fixed;
            width:250px;
            height:100vh;
            background:#198754;
            color:white;
            padding:20px;
        }

        .logo{
            text-align:center;
            margin-bottom:30px;
        }

        .logo img{
            width:90px;
            height:90px;
            border-radius:50%;
            background:white;
            padding:5px;
        }

        .logo h2{
            margin-top:10px;
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar ul li{
            margin:10px 0;
        }

        .sidebar ul li a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px;
            border-radius:8px;
        }

        .sidebar ul li a:hover{
            background:#146c43;
        }

        /* Main Content */
        .main{
            margin-left:270px;
            padding:25px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .header h1{
            color:#198754;
        }

        .profile{
            background:white;
            padding:10px 20px;
            border-radius:10px;
            box-shadow:0 2px 5px rgba(0,0,0,.1);
        }

        /* Cards */
        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            text-align:center;
        }

        .card h2{
            color:#198754;
            font-size:35px;
        }

        .card p{
            margin-top:10px;
            color:#666;
        }

        /* Tables */
        .section{
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            margin-bottom:25px;
        }

        .section h3{
            margin-bottom:15px;
            color:#198754;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#198754;
            color:white;
            padding:12px;
        }

        table td{
            padding:12px;
            border-bottom:1px solid #ddd;
        }

        .status{
            padding:5px 12px;
            border-radius:20px;
            color:white;
            font-size:13px;
        }

        .pending{
            background:orange;
        }

        .ongoing{
            background:#0d6efd;
        }

        .completed{
            background:#198754;
        }

        /* Notifications */
        .notification{
            padding:15px;
            background:#f8f9fa;
            border-left:5px solid #198754;
            margin-bottom:10px;
            border-radius:5px;
        }
    </style>

</head>

<body>

<!-- Sidebar -->

<div class="sidebar">

    <div class="logo">
        <img src="eco.png" alt="Eco Logo">
        <h2>Eco Waste</h2>
        <p>Collector Panel</p>
    </div>

    <ul>
        <li><a href="dashboard.php">🏠 Dashboard</a></li>
        <li><a href="task.php">📋 My Tasks</a></li>
        <li><a href="reports.php">📊 Reports</a></li>
        <li><a href="submit_report.php">📝 Submit Report</a></li>
        <li><a href="cnotification.php">🔔 Notifications</a></li>
        <li><a href="profiles.php">👤 Profile</a></li>
        <li><a href="logout.php">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->

<div class="main">

    <div class="header">
        <h1>Collector Dashboard</h1>

        <div class="profile">
            Welcome, Collector
        </div>
    </div>

    <!-- Statistics -->

    <div class="cards">

        <div class="card">
            <h2>25</h2>
            <p>Total Tasks</p>
        </div>

        <div class="card">
            <h2>8</h2>
            <p>Pending Tasks</p>
        </div>

        <div class="card">
            <h2>10</h2>
            <p>Ongoing Tasks</p>
        </div>

        <div class="card">
            <h2>7</h2>
            <p>Completed Tasks</p>
        </div>

    </div>

    <!-- Recent Tasks -->

    <div class="section">

        <h3>Recent Collection Tasks</h3>

        <table>

            <tr>
                <th>ID</th>
                <th>Waste Type</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <tr>
                <td>1</td>
                <td>Plastic</td>
                <td>Kigali</td>
                <td>23-Jun-2026</td>
                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Paper</td>
                <td>Gasabo</td>
                <td>23-Jun-2026</td>
                <td>
                    <span class="status ongoing">
                        Ongoing
                    </span>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>Metal</td>
                <td>Kicukiro</td>
                <td>22-Jun-2026</td>
                <td>
                    <span class="status completed">
                        Completed
                    </span>
                </td>
            </tr>

        </table>

    </div>

    <!-- Notifications -->

    <div class="section">

        <h3>Recent Notifications</h3>

        <div class="notification">
            New collection task assigned in Kigali.
        </div>

        <div class="notification">
            Collection report submitted successfully.
        </div>

        <div class="notification">
            Vehicle assignment updated.
        </div>

    </div>

</div>

</body>
</html>