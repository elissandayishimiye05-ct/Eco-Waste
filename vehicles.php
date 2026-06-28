<?php
include "vehicles_backend.php";

/* ================= ADD ================= */
if (isset($_POST['save'])) {

    addVehicle(
        $conn,
        $_POST['plate_number'],
        $_POST['vehicle_type'],
        $_POST['capacity']
    );

    header("Location: vehicles.php");
    exit();
}

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    updateVehicle(
        $conn,
        $_POST['vehicle_id'],
        $_POST['plate_number'],
        $_POST['vehicle_type'],
        $_POST['capacity'],
        $_POST['status']
    );

    header("Location: vehicles.php");
    exit();
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {

    deleteVehicle($conn, $_GET['delete']);

    header("Location: vehicles.php");
    exit();
}

/* ================= EDIT DATA ================= */
$edit = null;
if (isset($_GET['edit'])) {
    $edit = getVehicleById($conn, $_GET['edit']);
}

$vehicles = getVehicles($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Vehicles Management</title>

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
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar text-center">
    <h4>EcoWaste</h4>
    <hr>

    <a href="admin.php">Dashboard</a>
    <a href="vehicles.php">Vehicles</a>
</div>

<!-- MAIN -->
<div class="main">

<h3 class="mb-3">Vehicles Management</h3>

<div class="row">

<!-- FORM -->
<div class="col-md-4">

<div class="card p-3">

<h5><?= $edit ? "Update Vehicle" : "Add Vehicle" ?></h5>

<form method="POST">

<?php if ($edit) { ?>
    <input type="hidden" name="vehicle_id" value="<?= $edit['vehicle_id'] ?>">
<?php } ?>

<input type="text" name="plate_number" class="form-control mb-2"
       placeholder="Plate Number"
       value="<?= $edit['plate_number'] ?? '' ?>" required>

<input type="text" name="vehicle_type" class="form-control mb-2"
       placeholder="Vehicle Type"
       value="<?= $edit['vehicle_type'] ?? '' ?>" required>

<input type="number" step="0.01" name="capacity" class="form-control mb-2"
       placeholder="Capacity"
       value="<?= $edit['capacity'] ?? '' ?>">

<?php if ($edit) { ?>
<select name="status" class="form-control mb-3">
    <option value="available" <?= $edit['status']=='available'?'selected':'' ?>>Available</option>
    <option value="assigned" <?= $edit['status']=='assigned'?'selected':'' ?>>Assigned</option>
    <option value="maintenance" <?= $edit['status']=='maintenance'?'selected':'' ?>>Maintenance</option>
</select>
<?php } ?>

<button class="btn btn-success w-100" name="<?= $edit ? 'update' : 'save' ?>">
    <?= $edit ? 'Update Vehicle' : 'Save Vehicle' ?>
</button>

</form>

</div>

</div>

<!-- TABLE -->
<div class="col-md-8">

<div class="card p-3">

<h5>Vehicles List</h5>

<table class="table table-bordered text-center align-middle">

<thead class="table-success">
<tr>
    <th>ID</th>
    <th>Plate</th>
    <th>Type</th>
    <th>Capacity</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while($v = $vehicles->fetch_assoc()) { ?>

<tr>
    <td><?= $v['vehicle_id'] ?></td>
    <td><?= $v['plate_number'] ?></td>
    <td><?= $v['vehicle_type'] ?></td>
    <td><?= $v['capacity'] ?> kg</td>

    <td>
        <?php
        if ($v['status']=='available') echo "<span class='badge bg-success'>Available</span>";
        elseif ($v['status']=='assigned') echo "<span class='badge bg-primary'>Assigned</span>";
        else echo "<span class='badge bg-warning'>Maintenance</span>";
        ?>
    </td>

    <td>
        <a href="?edit=<?= $v['vehicle_id'] ?>" class="btn btn-primary btn-sm">
            Edit
        </a>

        <a href="?delete=<?= $v['vehicle_id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete vehicle?')">
            Delete
        </a>
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