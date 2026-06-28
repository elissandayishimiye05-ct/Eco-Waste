<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

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

        /* Main */
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

        /* Profile Card */
        .profile-card{
            background:white;
            border-radius:15px;
            padding:30px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            max-width:900px;
        }

        .profile-top{
            text-align:center;
            margin-bottom:30px;
        }

        .profile-top img{
            width:120px;
            height:120px;
            border-radius:50%;
            border:4px solid #198754;
            padding:5px;
        }

        .profile-top h2{
            margin-top:15px;
            color:#198754;
        }

        .profile-top p{
            color:#666;
        }

        .profile-info{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:20px;
        }

        .info-box{
            background:#f8f9fa;
            padding:15px;
            border-radius:10px;
        }

        .info-box label{
            display:block;
            font-weight:bold;
            color:#198754;
            margin-bottom:5px;
        }

        .info-box span{
            color:#333;
        }

        .btn{
            margin-top:25px;
            background:#198754;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:8px;
            cursor:pointer;
            font-size:15px;
        }

        .btn:hover{
            background:#146c43;
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
        <li><a href="notifications.html">🔔 Notifications</a></li>
        <li><a href="profile.html" class="active">👤 Profile</a></li>
        <li><a href="#">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->
<div class="main">

    <div class="header">
        <h1>My Profile</h1>
    </div>

    <div class="profile-card">

        <div class="profile-top">
            <img src="eco.png" alt="Profile">
            <h2>John Collector</h2>
            <p>Waste Collection Officer</p>
        </div>

        <div class="profile-info">

            <div class="info-box">
                <label>Collector ID</label>
                <span>COL001</span>
            </div>

            <div class="info-box">
                <label>Full Name</label>
                <span>John Collector</span>
            </div>

            <div class="info-box">
                <label>Email Address</label>
                <span>johncollector@email.com</span>
            </div>

            <div class="info-box">
                <label>Phone Number</label>
                <span>+250 788 123 456</span>
            </div>

            <div class="info-box">
                <label>Assigned Vehicle</label>
                <span>RAB 123A</span>
            </div>

            <div class="info-box">
                <label>Work Area</label>
                <span>Kigali City</span>
            </div>

            <div class="info-box">
                <label>Total Tasks Completed</label>
                <span>150</span>
            </div>

            <div class="info-box">
                <label>Reports Submitted</label>
                <span>145</span>
            </div>

        </div>

        <button class="btn">Edit Profile</button>

    </div>

</div>

</body>
</html>