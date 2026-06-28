<?php
include "Connection.php";

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE user_id=$id");
    header("Location: users.php");
    exit();
}

/* ================= ADD / UPDATE ================= */
$edit = false;
$data = null;

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $data = $conn->query("SELECT * FROM users WHERE user_id=$id")->fetch_assoc();
}

if (isset($_POST['save_user'])) {

    $id = $_POST['user_id'] ?? '';
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    if (!empty($id)) {
        // UPDATE
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "UPDATE users SET 
                    fullname='$fullname',
                    email='$email',
                    phone='$phone',
                    password='$password',
                    role='$role'
                    WHERE user_id=$id";
        } else {
            $sql = "UPDATE users SET 
                    fullname='$fullname',
                    email='$email',
                    phone='$phone',
                    role='$role'
                    WHERE user_id=$id";
        }
    } else {
        // INSERT
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullname, email, phone, password, role)
                VALUES ('$fullname', '$email', '$phone', '$password', '$role')";
    }

    $conn->query($sql);
    header("Location: users.php");
    exit();
}

/* ================= FETCH USERS ================= */
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Users Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#f4f6f9; }

/* Sidebar */
.sidebar {
    height: 100vh;
    width: 220px;
    background: #198754;
    position: fixed;
    color: white;
    padding-top: 20px;
}

.sidebar img { width: 70px; }
.sidebar a {
    display:block;
    color:white;
    padding:10px;
    text-decoration:none;
}
.sidebar a:hover { background:#145c3a; }

/* Main */
.main {
    margin-left: 230px;
    padding: 20px;
}

/* Layout split */
.split {
    display: flex;
    gap: 20px;
}

/* Left form */
.form-box {
    flex: 1;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    height: fit-content;
}

/* Right table */
.table-box {
    flex: 2;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar text-center">
    <img src="eco.png">
    <h5>EcoWaste</h5>
    <hr>
    <a href="admin.php">Dashboard</a>
    <a href="users.php">Users</a>
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

<h3 class="mb-3">Users Management</h3>

<div class="split">

    <!-- LEFT: FORM -->
    <div class="form-box">
        <h5><?= $edit ? "Edit User" : "Add User" ?></h5>

        <form method="post">

            <input type="hidden" name="user_id"
                   value="<?= $edit ? $data['user_id'] : '' ?>">

            <input type="text" name="fullname"
                   class="form-control mb-2"
                   placeholder="Full Name"
                   value="<?= $edit ? $data['fullname'] : '' ?>" required>

            <input type="email" name="email"
                   class="form-control mb-2"
                   placeholder="Email"
                   value="<?= $edit ? $data['email'] : '' ?>" required>

            <input type="text" name="phone"
                   class="form-control mb-2"
                   placeholder="Phone"
                   value="<?= $edit ? $data['phone'] : '' ?>">

            <input type="password" name="password"
                   class="form-control mb-2"
                   placeholder="Password (leave empty if editing)">

            <select name="role" class="form-control mb-3">
                <option value="admin">Admin</option>
                <option value="collector">Collector</option>
                <option value="recycling">Recycling</option>
                <option value="resident">Resident</option>
            </select>

            <button name="save_user" class="btn btn-success w-100">
                <?= $edit ? "Update User" : "Add User" ?>
            </button>

        </form>
    </div>

    <!-- RIGHT: TABLE -->
    <div class="table-box">

        <table class="table table-hover text-center">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['fullname'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><span class="badge bg-success"><?= $row['role'] ?></span></td>

                    <td>
                        <a href="users.php?edit=<?= $row['user_id'] ?>"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="users.php?delete=<?= $row['user_id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete user?')">
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

</body>
</html>