<?php
include "recycling_backend.php";

/* ADD */
if (isset($_POST['save'])) {

    addCenter(
        $conn,
        $_POST['center_name'],
        $_POST['location'],
        $_POST['contact_phone']
    );

    header("Location: recycling_centers.php");
    exit();
}

/* DELETE */
if (isset($_GET['delete'])) {

    deleteCenter($conn, $_GET['delete']);

    header("Location: recycling_centers.php");
    exit();
}

$centers = getCenters($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Recycling Centers</title>

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

    <a href="admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="users.php"><i class="bi bi-people"></i> Users</a>
    <a href="collectors.php"><i class="bi bi-person-badge"></i> Collectors</a>
    <a href="recycling_centers.php"><i class="bi bi-recycle"></i> Recycling Centers</a>
</div>

<!-- MAIN -->
<div class="main">

<h3 class="mb-3">Recycling Centers</h3>

<div class="row">

<!-- FORM -->
<div class="col-md-4">

<div class="card p-3">

<h5>Add Center</h5>

<form method="POST">

<input type="text" name="center_name" class="form-control mb-2" placeholder="Center Name" required>

<input type="text" name="location" class="form-control mb-2" placeholder="Location" required>

<input type="text" name="contact_phone" class="form-control mb-3" placeholder="Phone">

<button class="btn btn-success w-100" name="save">
    Save Center
</button>

</form>

</div>

</div>

<!-- TABLE -->
<div class="col-md-8">

<div class="card p-3">

<h5>Centers List</h5>

<table class="table table-bordered text-center align-middle">

<thead class="table-success">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Location</th>
    <th>Phone</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $centers->fetch_assoc()) { ?>

<tr>
    <td><?= $row['center_id'] ?></td>
    <td><?= $row['center_name'] ?></td>
    <td><?= $row['location'] ?></td>
    <td><?= $row['contact_phone'] ?></td>

    <td>
        <a href="?delete=<?= $row['center_id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete this center?')">
            <i class="bi bi-trash"></i>
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