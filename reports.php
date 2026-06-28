<!DOCTYPE html>
<html>
<head>
    <title>Collection Reports</title>

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
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .header h1{
            color:#198754;
        }

        /* Cards */
        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:20px;
            margin-bottom:25px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:12px;
            text-align:center;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
        }

        .card h2{
            color:#198754;
            margin-bottom:10px;
        }

        /* Report Table */
        .table-box{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
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
            text-align:center;
        }

        .status{
            padding:6px 12px;
            border-radius:20px;
            color:white;
            font-size:13px;
        }

        .approved{
            background:#198754;
        }

        .pending{
            background:#ffc107;
            color:black;
        }

        .rejected{
            background:#dc3545;
        }

        .btn{
            background:#198754;
            color:white;
            border:none;
            padding:8px 15px;
            border-radius:5px;
            cursor:pointer;
        }

        .btn:hover{
            opacity:.8;
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
        <li><a href="reports.html" class="active">📊 Reports</a></li>
        <li><a href="submit_report.html">📝 Submit Report</a></li>
        <li><a href="notifications.html">🔔 Notifications</a></li>
        <li><a href="profile.html">👤 Profile</a></li>
        <li><a href="#">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->

<div class="main">

    <div class="header">
        <h1>Collection Reports</h1>
    </div>

    <!-- Summary Cards -->

    <div class="cards">

        <div class="card">
            <h2>35</h2>
            <p>Total Reports</p>
        </div>

        <div class="card">
            <h2>28</h2>
            <p>Approved Reports</p>
        </div>

        <div class="card">
            <h2>7</h2>
            <p>Pending Review</p>
        </div>

    </div>

    <!-- Reports Table -->

    <div class="table-box">

        <table>

            <tr>
                <th>Report ID</th>
                <th>Task ID</th>
                <th>Waste Type</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>REP001</td>
                <td>TSK001</td>
                <td>Plastic</td>
                <td>50 KG</td>
                <td>23-Jun-2026</td>
                <td>
                    <span class="status approved">
                        Approved
                    </span>
                </td>
                <td>
                    <button class="btn">View</button>
                </td>
            </tr>

            <tr>
                <td>REP002</td>
                <td>TSK002</td>
                <td>Paper</td>
                <td>30 KG</td>
                <td>22-Jun-2026</td>
                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>
                <td>
                    <button class="btn">View</button>
                </td>
            </tr>

            <tr>
                <td>REP003</td>
                <td>TSK003</td>
                <td>Metal</td>
                <td>20 KG</td>
                <td>21-Jun-2026</td>
                <td>
                    <span class="status rejected">
                        Rejected
                    </span>
                </td>
                <td>
                    <button class="btn">View</button>
                </td>
            </tr>

        </table>

    </div>

</div>

</body>
</html>