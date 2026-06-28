<?php
include "Connection.php";

/* ================= SEND TO ONE USER ================= */
function sendNotification($conn, $user_id, $title, $message) {

    if (empty($user_id)) return false;

    $stmt = $conn->prepare("
        INSERT INTO notifications (user_id, title, message, status)
        VALUES (?, ?, ?, 'unread')
    ");

    $stmt->bind_param("iss", $user_id, $title, $message);
    return $stmt->execute();
}

/* ================= SEND TO ALL USERS ================= */
function sendToAllUsers($conn, $title, $message) {

    $users = $conn->query("SELECT user_id FROM users");

    while ($u = $users->fetch_assoc()) {
        sendNotification($conn, $u['user_id'], $title, $message);
    }
}

/* ================= ADMIN INBOX ================= */
function getAdminInbox($conn) {

    return $conn->query("
        SELECT n.*, u.fullname
        FROM notifications n
        JOIN users u ON n.user_id = u.user_id
        ORDER BY n.created_at DESC
    ");
}

/* ================= USER NOTIFICATIONS ================= */
function getUserNotifications($conn, $user_id) {

    $stmt = $conn->prepare("
        SELECT * FROM notifications
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    return $stmt->get_result();
}

/* ================= MARK AS READ ================= */
function markAsRead($conn, $id) {

    $stmt = $conn->prepare("
        UPDATE notifications
        SET status='read'
        WHERE notification_id=?
    ");

    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>