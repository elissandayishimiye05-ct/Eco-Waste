<?php
include "Connection.php";

/* =========================
   ADD COLLECTOR
========================= */
function addCollector($conn, $user_id, $emp_number, $phone) {

    $stmt = $conn->prepare("
        INSERT INTO collectors (user_id, employee_number, phone, status)
        VALUES (?, ?, ?, 'active')
    ");

    $stmt->bind_param("iss", $user_id, $emp_number, $phone);
    return $stmt->execute();
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
    return $stmt->execute();
}

/* =========================
   GET ALL COLLECTORS
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
   GET USERS (for dropdown)
========================= */
function getCollectorUsers($conn) {

    return $conn->query("
        SELECT user_id, fullname 
        FROM users 
        WHERE role = 'collector'
    ");
}
?>