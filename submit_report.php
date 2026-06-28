<!DOCTYPE html>
<html>
<head>
    <title>Submit Report</title>

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

        /* Form */
        .form-container{
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 2px 10px rgba(0,0,0,.1);
            max-width:900px;
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
            color:#333;
        }

        input,
        select,
        textarea{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
        }

        textarea{
            resize:none;
        }

        .btn{
            background:#198754;
            color:white;
            border:none;
            padding:12px 25px;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
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
        <li><a href="submit_report.html" class="active">📝 Submit Report</a></li>
        <li><a href="notifications.html">🔔 Notifications</a></li>
        <li><a href="profile.html">👤 Profile</a></li>
        <li><a href="#">🚪 Logout</a></li>
    </ul>

</div>

<!-- Main Content -->
<div class="main">

    <div class="header">
        <h1>Submit Collection Report</h1>
    </div>

    <div class="form-container">

        <form>

            <div class="form-group">
                <label>Task ID</label>
                <input type="text" placeholder="Enter Task ID">
            </div>

            <div class="form-group">
                <label>Waste Type</label>
                <select>
                    <option>Select Waste Type</option>
                    <option>Plastic</option>
                    <option>Paper</option>
                    <option>Glass</option>
                    <option>Metal</option>
                    <option>Organic</option>
                </select>
            </div>

            <div class="form-group">
                <label>Quantity Collected (KG)</label>
                <input type="number" placeholder="Enter quantity">
            </div>

            <div class="form-group">
                <label>Collection Location</label>
                <input type="text" placeholder="Enter collection location">
            </div>

            <div class="form-group">
                <label>Collection Date</label>
                <input type="date">
            </div>

            <div class="form-group">
                <label>Upload Collection Photo</label>
                <input type="file">
            </div>

            <div class="form-group">
                <label>Additional Notes</label>
                <textarea rows="5" placeholder="Enter notes about the collection"></textarea>
            </div>

            <button type="submit" class="btn">
                Submit Report
            </button>

        </form>

    </div>

</div>

</body>
</html>