<?php
session_start();
include "notifications_backend.php";

$user_id = $_SESSION['user_id'];

$notifs = getUserNotifications($conn, $user_id);

/* MARK AS READ */
if (isset($_GET['read'])) {
    markAsRead($conn, $_GET['read']);
    header("Location: user_notifications.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Notifications</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

<h3>My Notifications</h3>

<table class="table table-bordered">

<tr>
    <th>Title</th>
    <th>Message</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($n = $notifs->fetch_assoc()) { ?>

<tr>
    <td><?= $n['title'] ?></td>
    <td><?= $n['message'] ?></td>

    <td>
        <?= $n['status'] ?>
    </td>

    <td>
        <a href="?read=<?= $n['notification_id'] ?>" class="btn btn-sm btn-success">
            Mark Read
        </a>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>