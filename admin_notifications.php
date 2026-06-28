<?php
session_start();
include "Connection.php";

/* =========================
   SEND TO ALL USERS
========================= */
if (isset($_POST['send_all'])) {

    $title = $_POST['title'];
    $message = $_POST['message'];

    $users = $conn->query("SELECT user_id FROM users");

    while ($u = $users->fetch_assoc()) {

        $stmt = $conn->prepare("
            INSERT INTO notifications (user_id, title, message, status, created_at)
            VALUES (?, ?, ?, 'unread', NOW())
        ");

        $stmt->bind_param("iss", $u['user_id'], $title, $message);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: admin_notifications.php");
    exit();
}

/* =========================
   SEND TO ONE USER
========================= */
if (isset($_POST['send_one'])) {

    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $message = $_POST['message'];

    if (!empty($user_id)) {

        $stmt = $conn->prepare("
            INSERT INTO notifications (user_id, title, message, status, created_at)
            VALUES (?, ?, ?, 'unread', NOW())
        ");

        $stmt->bind_param("iss", $user_id, $title, $message);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: admin_notifications.php");
    exit();
}

/* =========================
   DELETE SINGLE MESSAGE
========================= */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM notifications
        WHERE notification_id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_notifications.php");
    exit();
}

/* =========================
   DELETE ALL MESSAGES
========================= */
if (isset($_POST['delete_all'])) {

    $conn->query("DELETE FROM notifications");

    header("Location: admin_notifications.php");
    exit();
}

/* =========================
   FETCH DATA
========================= */
$users = $conn->query("SELECT user_id, fullname FROM users");

$inbox = $conn->query("
    SELECT n.*, u.fullname
    FROM notifications n
    LEFT JOIN users u ON n.user_id = u.user_id
    ORDER BY n.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>EcoWaste Admin Notifications</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#eef2f7;
}

/* SIDEBAR */
.sidebar {
    width:240px;
    height:100vh;
    position:fixed;
    background:#198754;
    color:white;
    padding:20px;
}

.sidebar a {
    color:white;
    display:block;
    padding:12px;
    text-decoration:none;
    border-radius:10px;
}

.sidebar a:hover {
    background:rgba(255,255,255,0.2);
}

/* MAIN */
.main {
    margin-left:260px;
    padding:25px;
}

/* CARDS */
.card{
    border:none;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

/* MESSAGE CARD */
.message-card{
    padding:18px;
    border-radius:18px;
    margin-bottom:15px;
    transition:0.3s;
}

.message-card:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 20px rgba(0,0,0,0.08);
}

.unread-card{
    background:#fff8dc;
    border-left:6px solid #dc3545;
}

.read-card{
    background:#ffffff;
    border-left:6px solid #198754;
}

/* LOGO */
.eco-logo{
    width:120px;
    height:120px;
    object-fit:contain;
}

/* FORM */
.form-control{
    border-radius:12px;
    padding:10px;
}

.btn{
    border-radius:10px;
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>EcoWaste Admin</h4>
    <hr>
    <a href="admin.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="admin_notifications.php"><i class="bi bi-bell"></i> Notifications</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- HEADER -->
<div class="text-center mb-4">
    <img src="eco.png" class="eco-logo" alt="EcoWaste Logo">
    <h2 class="fw-bold text-success mt-2">
        EcoWaste Notification System
    </h2>
</div>

<div class="row">

<!-- LEFT SIDE -->
<div class="col-md-4">

<div class="card p-3">

<h5 class="text-success mb-3">
    <i class="bi bi-send"></i> Send Message
</h5>

<form method="POST">

<select name="user_id" class="form-control mb-2">
    <option value="">-- Send to All Users --</option>

    <?php while($u = $users->fetch_assoc()) { ?>
        <option value="<?= $u['user_id'] ?>">
            <?= $u['fullname'] ?>
        </option>
    <?php } ?>
</select>

<input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

<textarea name="message" class="form-control mb-3" placeholder="Message" required></textarea>

<button name="send_all" class="btn btn-success w-100 mb-2">
    Send to All
</button>

<button name="send_one" class="btn btn-primary w-100">
    Send to Selected User
</button>

</form>

</div>

</div>

<!-- RIGHT SIDE -->
<div class="col-md-8">

<div class="card p-4">

<div class="d-flex justify-content-between align-items-center mb-3">

<h4 class="text-success mb-0">
    <i class="bi bi-chat-dots"></i> Messages Inbox
</h4>

<form method="POST" onsubmit="return confirm('Delete ALL messages?')">
    <button name="delete_all" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i> Delete All
    </button>
</form>

</div>

<?php if ($inbox->num_rows == 0) { ?>
    <div class="alert alert-info text-center">
        No notifications found
    </div>
<?php } ?>

<?php while($n = $inbox->fetch_assoc()) { ?>

<div class="message-card <?= $n['status']=='unread' ? 'unread-card' : 'read-card' ?>">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-1">
                <?= htmlspecialchars($n['title']) ?>
            </h5>

            <small class="text-muted">
                To: <strong><?= htmlspecialchars($n['fullname'] ?? 'All Users') ?></strong>
            </small>
        </div>

        <?php if($n['status']=='unread') { ?>
            <span class="badge bg-danger">Unread</span>
        <?php } else { ?>
            <span class="badge bg-success">Read</span>
        <?php } ?>

    </div>

    <p class="mt-3 text-secondary">
        <?= nl2br(htmlspecialchars($n['message'])) ?>
    </p>

    <small class="text-muted">
        <i class="bi bi-clock"></i>
        <?= date('d M Y H:i', strtotime($n['created_at'])) ?>
    </small>

    <div class="mt-2">
        <a href="?delete=<?= $n['notification_id'] ?>"
           onclick="return confirm('Delete this message?')"
           class="btn btn-outline-danger btn-sm">
            <i class="bi bi-trash"></i> Delete
        </a>
    </div>

</div>

<?php } ?>

</div>

</div>

</div>

</div>

</body>
</html>