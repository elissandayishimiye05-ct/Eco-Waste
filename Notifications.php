```php
<?php
session_start();
include "Connection.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* =========================
   SEND NOTIFICATION
========================= */
if (isset($_POST['send'])) {

    $title = trim($_POST['title']);
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("
        INSERT INTO notifications
        (user_id, title, message, status, created_at)
        VALUES (?, ?, ?, 'unread', NOW())
    ");

    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $title, $message);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: Notifications.php");
    exit();
}

/* =========================
   MARK AS READ
========================= */
if (isset($_GET['read'])) {

    $id = intval($_GET['read']);

    $stmt = $conn->prepare("
        UPDATE notifications
        SET status='read'
        WHERE notification_id=? AND user_id=?
    ");

    if ($stmt) {
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: Notifications.php");
    exit();
}

/* =========================
   MARK AS UNREAD
========================= */
if (isset($_GET['unread'])) {

    $id = intval($_GET['unread']);

    $stmt = $conn->prepare("
        UPDATE notifications
        SET status='unread'
        WHERE notification_id=? AND user_id=?
    ");

    if ($stmt) {
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: Notifications.php");
    exit();
}

/* =========================
   DELETE NOTIFICATION
========================= */
if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("
        DELETE FROM notifications
        WHERE notification_id=? AND user_id=?
    ");

    if ($stmt) {
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: Notifications.php");
    exit();
}

/* =========================
   FETCH NOTIFICATIONS
========================= */
$result = null;

$stmt = $conn->prepare("
    SELECT *
    FROM notifications
    WHERE user_id = ?
    ORDER BY created_at DESC
");

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EcoWaste Notifications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#eef2f7;
            font-family:Arial, sans-serif;
        }

        .eco-logo{
            width:160px;
            height:160px;
            object-fit:contain;
        }

        .card{
            border:none;
            border-radius:20px;
            box-shadow:0 8px 25px rgba(0,0,0,.08);
        }

        .notification-card{
            border-radius:18px;
            padding:20px;
            margin-bottom:20px;
            transition:all .3s ease;
        }

        .notification-card:hover{
            transform:translateY(-4px);
            box-shadow:0 10px 25px rgba(0,0,0,.10);
        }

        .notification-unread{
            background:#fff8dc;
            border-left:6px solid #ffc107;
        }

        .notification-read{
            background:#ffffff;
            border-left:6px solid #198754;
        }

        .notification-title{
            font-size:1.2rem;
            font-weight:600;
        }

        .notification-message{
            color:#6c757d;
            margin-top:10px;
        }

        .form-control{
            border-radius:12px;
            padding:12px;
        }

        .btn{
            border-radius:10px;
        }
    </style>
</head>

<body>

<div class="container py-4">

    <div class="text-center mb-4">

        <img src="eco.png" class="eco-logo" alt="EcoWaste Logo">

        <h2 class="fw-bold text-success mt-3">
            <i class="bi bi-bell-fill"></i>
            EcoWaste Notifications Center
        </h2>

        <p class="text-muted">
            Manage and track your notifications.
        </p>

    </div>

    <!-- SEND FORM -->
    <div class="card p-4 mb-4">

        <h4 class="mb-3 text-success">
            <i class="bi bi-send-fill"></i>
            Send Notification
        </h4>

        <form method="POST">

            <input type="text"
                   name="title"
                   class="form-control mb-3"
                   placeholder="Notification Title"
                   required>

            <textarea name="message"
                      rows="4"
                      class="form-control mb-3"
                      placeholder="Write your message..."
                      required></textarea>

            <button type="submit"
                    name="send"
                    class="btn btn-success">
                <i class="bi bi-send"></i>
                Send Notification
            </button>

        </form>

    </div>

    <!-- NOTIFICATIONS -->
    <div class="card p-4">

        <h4 class="mb-4">
            <i class="bi bi-chat-dots-fill"></i>
            My Notifications
        </h4>

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while($row = $result->fetch_assoc()): ?>

                <div class="notification-card <?= $row['status']=='unread' ? 'notification-unread' : 'notification-read' ?>">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <div class="notification-title">
                                <?= htmlspecialchars($row['title']) ?>
                            </div>

                            <small class="text-muted">
                                <?= date("d M Y H:i", strtotime($row['created_at'])) ?>
                            </small>
                        </div>

                        <?php if($row['status']=='unread'): ?>
                            <span class="badge bg-warning">Unread</span>
                        <?php else: ?>
                            <span class="badge bg-success">Read</span>
                        <?php endif; ?>

                    </div>

                    <div class="notification-message">
                        <?= nl2br(htmlspecialchars($row['message'])) ?>
                    </div>

                    <div class="mt-3 d-flex gap-2 flex-wrap">

                        <?php if($row['status']=='unread'): ?>

                            <a href="?read=<?= $row['notification_id'] ?>"
                               class="btn btn-primary btn-sm">
                                Mark Read
                            </a>

                        <?php else: ?>

                            <a href="?unread=<?= $row['notification_id'] ?>"
                               class="btn btn-warning btn-sm">
                                Mark Unread
                            </a>

                        <?php endif; ?>

                        <a href="?delete=<?= $row['notification_id'] ?>"
                           onclick="return confirm('Delete notification?')"
                           class="btn btn-danger btn-sm">
                            Delete
                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="alert alert-info text-center">
                No notifications available.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
```
