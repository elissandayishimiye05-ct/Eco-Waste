<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>

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

        .sidebar ul li a:hover,
        .active{
            background:#146c43;
        }

        /* Main Content */
        .main{
            margin-left:270px;
            padding:25px;
        }

        .header{
            margin-bottom:25px;
        }

        .header h1{
            color:#198754;
        }

        /* Notification Cards */
        .notification-card{
            background:white;
            padding:20px;
            margin-bottom:15px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            border-left:6px solid #198754;
        }

        .notification-card h3{
            color:#198754;
            margin-bottom:8px;
        }

        .notification-card p{
            color:#555;
            margin-bottom:10px;
        }

        .time{
            font-size:13px;
            color:gray;
        }

        .unread{
            border-left:6px solid #0d6efd;
        }

        .warning{
            border-left:6px solid #ffc107;
        }

        .success{
            border-left:6px solid #198754;
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
        <li><a href="dashboard.html">🏠 Dashboard</a></li>
        <li><a href="tasks.html">📋 My Tasks</a></li>
        <li><a href="reports.html">📊 Reports</a></li>
        <li><a href="submit_report.html">📝 Submit Report</a></li>
        <li><a href="notifications.html" class="active">🔔 Notifications</a></li>
        <li><a href="profile.html">👤 Profile</a></li>
        <li><a href="#">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->
<div class="main">

    <div class="header">
        <h1>Notifications</h1>
    </div>

    <div class="notification-card unread">
        <h3>📋 New Task Assigned</h3>
        <p>You have been assigned a new waste collection task in Kigali Sector.</p>
        <span class="time">5 minutes ago</span>
    </div>

    <div class="notification-card success">
        <h3>✅ Report Approved</h3>
        <p>Your collection report for Task #105 has been approved by the administrator.</p>
        <span class="time">1 hour ago</span>
    </div>

    <div class="notification-card warning">
        <h3>⚠ Schedule Updated</h3>
        <p>The collection schedule for Task #112 has been changed to tomorrow at 09:00 AM.</p>
        <span class="time">3 hours ago</span>
    </div>

    <div class="notification-card success">
        <h3>🚛 Vehicle Assigned</h3>
        <p>Vehicle RAB 123A has been assigned for today's collection activities.</p>
        <span class="time">Yesterday</span>
    </div>

    <div class="notification-card">
        <h3>📢 System Announcement</h3>
        <p>Please submit all completed collection reports before the end of the working day.</p>
        <span class="time">2 days ago</span>
    </div>

</div>

</body>
</html>