<?php
include "residents_backend.php";

/* ================= ADD ================= */
if (isset($_POST['save'])) {

    addResident(
        $conn,
        $_POST['user_id'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['location_notes']
    );

    header("Location: residents_backend.php");
    exit();
}

/* ================= UPDATE ================= */
if (isset($_POST['update'])) {

    updateResident(
        $conn,
        $_POST['resident_id'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['location_notes']
    );

    header("Location: residents_backend.php");
    exit();
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {

    deleteResident($conn, $_GET['delete']);

    header("Location: residents_backend.php");
    exit();
}

/* ================= EDIT DATA ================= */
$editData = null;
if (isset($_GET['edit'])) {
    $editData = getResident($conn, $_GET['edit']);
}

$residents = getResidents($conn);
$users = $conn->query("SELECT * FROM users WHERE role='resident'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Residents Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }
.card { border:none; border-radius:12px; }
</style>
</head>

<body>

<div class="container mt-4">

<h3 class="mb-3">Residents Management</h3>

<div class="row">

<!-- ================= FORM ================= -->
<div class="col-md-4">

<div class="card p-3 shadow-sm">

<h5><?= $editData ? "Update Resident" : "Add Resident" ?></h5>

<form method="POST">

<?php if($editData){ ?>
    <input type="hidden" name="resident_id" value="<?= $editData['resident_id'] ?>">
<?php } ?>

<!-- USER SELECT -->
<select name="user_id" class="form-control mb-2" required <?= $editData ? 'disabled' : '' ?>>
    <option value="">Select User</option>
    <?php while($u = $users->fetch_assoc()) { ?>
        <option value="<?= $u['user_id'] ?>"
            <?= ($editData && $editData['user_id']==$u['user_id']) ? 'selected' : '' ?>>
            <?= $u['fullname'] ?>
        </option>
    <?php } ?>
</select>

<!-- ADDRESS -->
<textarea name="address" class="form-control mb-2" placeholder="Address" required><?= $editData['address'] ?? '' ?></textarea>

<!-- PHONE -->
<input type="text" name="phone" class="form-control mb-2"
       placeholder="Phone"
       value="<?= $editData['phone'] ?? '' ?>">

<!-- NOTES -->
<textarea name="location_notes" class="form-control mb-3" placeholder="Location Notes"><?= $editData['location_notes'] ?? '' ?></textarea>

<?php if($editData){ ?>
    <button name="update" class="btn btn-primary w-100">
        Update Resident
    </button>
<?php } else { ?>
    <button name="save" class="btn btn-success w-100">
        Save Resident
    </button>
<?php } ?>

</form>

</div>

</div>

<!-- ================= TABLE ================= -->
<div class="col-md-8">

<div class="card p-3 shadow-sm">

<h5>All Residents</h5>

<table class="table table-bordered text-center">

<thead class="table-success">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Address</th>
    <th>Phone</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($r = $residents->fetch_assoc()) { ?>

<tr>
    <td><?= $r['resident_id'] ?></td>
    <td><?= $r['fullname'] ?></td>
    <td><?= $r['email'] ?></td>
    <td><?= $r['address'] ?></td>
    <td><?= $r['phone'] ?></td>

    <td>
        <a href="residents_backend.php?edit=<?= $r['resident_id'] ?>"
           class="btn btn-primary btn-sm">
           Edit
        </a>

        <a href="residents_backend.php?delete=<?= $r['resident_id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Delete resident?')">
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