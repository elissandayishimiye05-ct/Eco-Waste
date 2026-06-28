<!DOCTYPE html>
<html>
<head>
    <title>My Tasks - Collector Panel</title>

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

        /* Summary Cards */
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

        /* Task Table */
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

        .pending{
            background:#ffc107;
            color:black;
        }

        .ongoing{
            background:#0d6efd;
        }

        .completed{
            background:#198754;
        }

        .btn{
            border:none;
            padding:8px 15px;
            border-radius:5px;
            cursor:pointer;
            color:white;
        }

        .start{
            background:#0d6efd;
        }

        .complete{
            background:#198754;
        }

        .view{
            background:#6c757d;
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
        <li><a href="tasks.html" class="active">📋 My Tasks</a></li>
        <li><a href="reports.html">📊 Reports</a></li>
        <li><a href="submit_report.html">📝 Submit Report</a></li>
        <li><a href="notifications.html">🔔 Notifications</a></li>
        <li><a href="profile.html">👤 Profile</a></li>
        <li><a href="#">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->

<div class="main">

    <div class="header">
        <h1>My Collection Tasks</h1>
    </div>

    <!-- Summary -->

    <div class="cards">

        <div class="card">
            <h2>25</h2>
            <p>Total Tasks</p>
        </div>

        <div class="card">
            <h2>10</h2>
            <p>Ongoing Tasks</p>
        </div>

        <div class="card">
            <h2>15</h2>
            <p>Completed Tasks</p>
        </div>

    </div>

    <!-- Tasks Table -->

    <div class="table-box">

        <table>

            <tr>
                <th>Task ID</th>
                <th>Waste Type</th>
                <th>Location</th>
                <th>Collection Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td>001</td>
                <td>Plastic</td>
                <td>Kigali</td>
                <td>23-Jun-2026</td>

                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>

                <td>
                    <button class="btn start">
                        Start
                    </button>
                </td>
            </tr>

            <tr>
                <td>002</td>
                <td>Paper</td>
                <td>Gasabo</td>
                <td>23-Jun-2026</td>

                <td>
                    <span class="status ongoing">
                        Ongoing
                    </span>
                </td>

                <td>
                    <button class="btn complete">
                        Complete
                    </button>
                </td>
            </tr>

            <tr>
                <td>003</td>
                <td>Metal</td>
                <td>Kicukiro</td>
                <td>22-Jun-2026</td>

                <td>
                    <span class="status completed">
                        Completed
                    </span>
                </td>

                <td>
                    <button class="btn view">
                        View
                    </button>
                </td>
            </tr>

        </table>

    </div>

</div>

</body>
</html>