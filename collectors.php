<?php
include "Connection.php";

/* =========================
   ADD COLLECTOR
========================= */
function addCollector($conn, $user_id, $emp_number, $phone) {

    if (empty($user_id) || empty($emp_number)) {
        die("User and Employee Number are required");
    }

    // Prevent duplicate collector
    $check = $conn->prepare("SELECT collector_id FROM collectors WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("This user is already a collector");
    }

    $stmt = $conn->prepare("
        INSERT INTO collectors (user_id, employee_number, phone, status)
        VALUES (?, ?, ?, 'active')
    ");

    $stmt->bind_param("iss", $user_id, $emp_number, $phone);

    if (!$stmt->execute()) {
        die("Insert Error: " . $stmt->error);
    }

    return true;
}

/* =========================
   DELETE COLLECTOR
========================= */
function deleteCollector($conn, $collector_id) {

    $stmt = $conn->prepare("
        DELETE FROM collectors 
        WHERE collector_id = ?
    ");

    $stmt->bind_param("i", $collector_id);

    if (!$stmt->execute()) {
        die("Delete Error: " . $stmt->error);
    }

    return true;
}

/* =========================
   GET COLLECTORS
========================= */
function getCollectors($conn) {

    return $conn->query("
        SELECT c.*, u.fullname, u.email
        FROM collectors c
        JOIN users u ON c.user_id = u.user_id
        ORDER BY c.collector_id DESC
    ");
}

/* =========================
   GET USERS (FIXED DROPDOWN)
========================= */
function getUsers($conn) {

    $result = $conn->query("
        SELECT user_id, fullname 
        FROM users
    ");

    if (!$result) {
        die("User Query Error: " . $conn->error);
    }

    return $result;
}

/* =========================
   HANDLE REQUESTS
========================= */
if (isset($_POST['save'])) {

    addCollector(
        $conn,
        $_POST['user_id'],
        $_POST['employee_number'],
        $_POST['phone']
    );

    header("Location: collectors.php");
    exit();
}

if (isset($_POST['delete'])) {

    deleteCollector($conn, $_POST['collector_id']);

    header("Location: collectors.php");
    exit();
}

/* =========================
   DATA
========================= */
$collectors = getCollectors($conn);
$users = getUsers($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Collectors Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }

.sidebar {
    height:100vh;
    width:230px;
    position:fixed;
    background:#198754;
    color:white;
    padding-top:20px;
}

.sidebar a {
    display:block;
    color:white;
    padding:12px;
    text-decoration:none;
}

.sidebar a:hover { background:#145c3a; }

.main {
    margin-left:240px;
    padding:20px;
}

.card {
    border:none;
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar text-center">
    <h4>EcoWaste</h4>
    <hr>

    <a href="admin.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="collectors.php">Collectors</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h3 class="mb-3">Collectors Management</h3>

<div class="row">

<!-- FORM -->
<div class="col-md-4">
<div class="card p-3">

<h5>Add Collector</h5>

<form method="POST">

<label class="form-label">Select User</label>
<select name="user_id" class="form-control mb-2" required>
    <option value="">-- Select User --</option>

    <?php
    if ($users->num_rows > 0) {
        while ($u = $users->fetch_assoc()) {
    ?>
        <option value="<?= $u['user_id'] ?>">
            <?= htmlspecialchars($u['fullname']) ?>
        </option>
    <?php
        }
    } else {
        echo "<option disabled>No users found</option>";
    }
    ?>
</select>

<label class="form-label">Employee Number</label>
<input type="text" name="employee_number" class="form-control mb-2" required>

<label class="form-label">Phone</label>
<input type="text" name="phone" class="form-control mb-3">

<button class="btn btn-success w-100" name="save">
    Save Collector
</button>

</form>

</div>
</div>

<!-- TABLE -->
<div class="col-md-8">
<div class="card p-3">

<h5>Collectors List</h5>

<table class="table table-bordered table-hover text-center">

<thead class="table-success">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Emp No</th>
    <th>Phone</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php if ($collectors->num_rows == 0) { ?>
<tr>
    <td colspan="7">No collectors found</td>
</tr>
<?php } ?>

<?php while ($row = $collectors->fetch_assoc()) { ?>

<tr>
    <td><?= $row['collector_id'] ?></td>
    <td><?= $row['fullname'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['employee_number'] ?></td>
    <td><?= $row['phone'] ?></td>

    <td>
        <?php if ($row['status'] == 'active') { ?>
            <span class="badge bg-success">Active</span>
        <?php } else { ?>
            <span class="badge bg-secondary">Inactive</span>
        <?php } ?>
    </td>

    <td>
        <form method="POST" onsubmit="return confirm('Delete this collector?')">
            <input type="hidden" name="collector_id" value="<?= $row['collector_id'] ?>">
            <button name="delete" class="btn btn-danger btn-sm">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </td>
</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>

</div>

</div>

</body>
</html>