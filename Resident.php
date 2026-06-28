<?php
session_start();
include("Connection.php");

/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   GET USER INFO (SAFE)
========================= */
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    die("User not found");
}

/* =========================
   GET RESIDENT (OPTIONAL SAFE LINK)
========================= */
$resQuery = mysqli_query($conn, "SELECT resident_id FROM residents WHERE user_id='$user_id'");
$resident = mysqli_fetch_assoc($resQuery);
$resident_id = $resident ? $resident['resident_id'] : 0;

/* =========================
   DASHBOARD STATS
========================= */
function countQuery($conn, $sql){
    $result = mysqli_query($conn,$sql);
    return mysqli_fetch_assoc($result)['total'] ?? 0;
}

$total     = countQuery($conn, "SELECT COUNT(*) AS total FROM waste_requests WHERE resident_id='$resident_id'");
$pending   = countQuery($conn, "SELECT COUNT(*) AS total FROM waste_requests WHERE resident_id='$resident_id' AND status='pending'");
$completed = countQuery($conn, "SELECT COUNT(*) AS total FROM waste_requests WHERE resident_id='$resident_id' AND status='completed'");
$cancelled = countQuery($conn, "SELECT COUNT(*) AS total FROM waste_requests WHERE resident_id='$resident_id' AND status='cancelled'");

/* =========================
   RECENT REQUESTS
========================= */
$requests = mysqli_query($conn, "SELECT * FROM waste_requests WHERE resident_id='$resident_id' ORDER BY request_id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Waste Dashboard</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Premium Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #1E3F20;         /* Deep Forest Premium Branding */
            --sidebar-hover: #142C16;      /* Active state highlight */
            --body-bg: #F8FAFC;            /* Clean Slate SaaS Background */
            --card-border: #E2E8F0;        /* Subtle divider borders */
            --text-dark: #0F172A;          /* Slate 900 */
            --text-muted: #64748B;         /* Slate 500 */
            
            /* High-end Semantic Palette */
            --accent-blue: #3B82F6;        
            --accent-amber: #F59E0B;       
            --accent-emerald: #10B981;     
            --accent-rose: #EF4444;        
        }

        body {
            background-color: var(--body-bg);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            margin: 0;
        }

        /* PREMIUM SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: #ffffff;
            padding: 1.5rem 1rem;
            position: fixed;
            width: 240px;
            z-index: 100;
        }

        .logo-box {
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.2);
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.7rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.3rem;
            transition: all 0.2s ease;
        }

        .sidebar a i {
            font-size: 1.15rem;
            margin-right: 0.85rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--sidebar-hover);
            color: #ffffff;
        }

        .sidebar a.logout-btn:hover {
            background-color: rgba(239, 68, 68, 0.15);
            color: #F87171;
        }

        /* MAIN BODY STRUCTURE */
        .main-content {
            margin-left: 240px; /* Offset spacing to avoid overlapping the fixed sidebar */
            padding: 2rem;
            width: calc(100% - 240px);
        }

        .welcome-title {
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .welcome-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* MODERN CARD ARCHETYPE */
        .card {
            border: 1px solid var(--card-border);
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        }

        /* STATS BOXES WITH WHITE DESIGN */
        .stat-card {
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .stat-num {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0;
        }

        /* SEMANTIC TINTS FOR STAT CARDS */
        .stat-total .stat-icon-box     { background: rgba(59, 130, 246, 0.1); color: var(--accent-blue); }
        .stat-pending .stat-icon-box   { background: rgba(245, 158, 11, 0.1); color: var(--accent-amber); }
        .stat-completed .stat-icon-box { background: rgba(16, 185, 129, 0.1); color: var(--accent-emerald); }
        .stat-cancelled .stat-icon-box { background: rgba(239, 68, 68, 0.1); color: var(--accent-rose); }

        /* DATA TABLES */
        .table-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            background-color: #F8FAFC;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--card-border);
        }

        .table td {
            padding: 0.95rem 1rem;
            font-size: 0.9rem;
            color: #334155;
            border-bottom: 1px solid #F1F5F9;
        }

        /* MODERN BADGES */
        .status-badge {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
        }
        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin-right: 6px;
            display: inline-block;
        }

        .badge-pending { background-color: #FEF3C7; color: #D97706; }
        .badge-pending::before { background-color: #D97706; }

        .badge-completed { background-color: #D1FAE5; color: #059669; }
        .badge-completed::before { background-color: #059669; }

        .badge-cancelled { background-color: #FEE2E2; color: #DC2626; }
        .badge-cancelled::before { background-color: #DC2626; }

        .badge-default { background-color: #E2E8F0; color: #475569; }
        .badge-default::before { background-color: #475569; }
    </style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <div class="logo-box text-center">
        <img src="eco.png" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" class="logo mb-2" alt="EcoWaste Logo">
        <div class="bi bi-recycle text-white fs-3 mb-2 mx-auto" style="display:none; width:50px; height:50px; line-height:50px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
        <h6 class="m-0 font-weight-bold" style="letter-spacing: 0.5px;">EcoWaste Portal</h6>
    </div>

    <nav>
        <a href="Dashboard.php" class="active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a>
        <a href="Create_Request.php"><i class="bi bi-plus-circle"></i> Create Request</a>
        <a href="Notifications.php"><i class="bi bi-bell"></i> Notifications</a>
        <a href="Change_Password.php"><i class="bi bi-shield-lock"></i> Password</a>
        <a href="Profile.php"><i class="bi bi-person-gear"></i> Settings Profile</a>
        <a href="Logout.php" class="logout-btn mt-5"><i class="bi bi-box-arrow-left"></i> Sign Out</a>
    </nav>
</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="welcome-title mb-0">Welcome, <?php echo htmlspecialchars($user['fullname']); ?></h3>
            <p class="welcome-subtitle mb-0">Monitor and update your environmental system actions.</p>
        </div>
        <div class="text-end text-muted d-none d-sm-block" style="font-size: 0.85rem;">
            <i class="bi bi-calendar3 me-1"></i> <?php echo date('F d, Y'); ?>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3">
        <!-- Total Card -->
        <div class="col-6 col-md-3">
            <div class="card stat-card stat-total">
                <div class="stat-icon-box"><i class="bi bi-folder2-open"></i></div>
                <div class="stat-num"><?php echo $total; ?></div>
                <p class="stat-label">Total Requests</p>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="col-6 col-md-3">
            <div class="card stat-card stat-pending">
                <div class="stat-icon-box"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-num"><?php echo $pending; ?></div>
                <p class="stat-label">Pending Collection</p>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="col-6 col-md-3">
            <div class="card stat-card stat-completed">
                <div class="stat-icon-box"><i class="bi bi-check2-circle"></i></div>
                <div class="stat-num"><?php echo $completed; ?></div>
                <p class="stat-label">Completed Pickups</p>
            </div>
        </div>

        <!-- Cancelled Card -->
        <div class="col-6 col-md-3">
            <div class="card stat-card stat-cancelled">
                <div class="stat-icon-box"><i class="bi bi-x-circle"></i></div>
                <div class="stat-num"><?php echo $cancelled; ?></div>
                <p class="stat-label">Cancelled Tasks</p>
            </div>
        </div>
    </div>

    <!-- RECENT REQUESTS DATA CONTAINER -->
    <div class="card mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="table-card-title m-0">Recent Garbage & Waste Requests</h5>
            <a href="Create_Request.php" class="btn btn-sm px-3 text-white" style="background-color: var(--sidebar-bg); border-radius: 6px;">
                <i class="bi bi-plus"></i> New Request
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover alignment-middle">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Waste Category / Type</th>
                        <th>Log Date</th>
                        <th>Current Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($requests) > 0) {
                        while($row = mysqli_fetch_assoc($requests)) { 
                    ?>
                        <tr>
                            <td class="fw-semibold text-secondary">#<?php echo $row['request_id']; ?></td>
                            <td class="fw-medium"><?php echo htmlspecialchars($row['waste_type']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($row['request_date'])); ?></td>
                            <td>
                                <?php
                                $status = strtolower($row['status']);
                                if($status == "pending"){
                                    echo "<span class='status-badge badge-pending'>Pending</span>";
                                }
                                elseif($status == "completed"){
                                    echo "<span class='status-badge badge-completed'>Completed</span>";
                                }
                                elseif($status == "cancelled"){
                                    echo "<span class='status-badge badge-cancelled'>Cancelled</span>";
                                }
                                else{
                                    echo "<span class='status-badge badge-default'>".htmlspecialchars($row['status'])."</span>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='4' class='text-center py-4 text-muted'>No waste records found for your account.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>