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
        die("Error: " . $stmt->error);
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
        die("Error: " . $stmt->error);
    }

    return true;
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
   GET USERS (dropdown)
========================= */
function getCollectorUsers($conn) {

    return $conn->query("
        SELECT user_id, fullname 
        FROM users 
        WHERE role = 'collector'
    ");
}
?>