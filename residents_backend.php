<?php
include "Connection.php";

/* ================= CREATE (ADD RESIDENT) ================= */
function addResident($conn, $user_id, $address, $phone, $notes) {

    $stmt = $conn->prepare("
        INSERT INTO residents (user_id, address, phone, location_notes)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("isss", $user_id, $address, $phone, $notes);
    return $stmt->execute();
}

/* ================= READ (ALL RESIDENTS) ================= */
function getResidents($conn) {

    return $conn->query("
        SELECT r.*, u.fullname, u.email
        FROM residents r
        JOIN users u ON r.user_id = u.user_id
        ORDER BY r.resident_id DESC
    ");
}

/* ================= READ (ONE RESIDENT) ================= */
function getResident($conn, $id) {

    $stmt = $conn->prepare("
        SELECT * FROM residents WHERE resident_id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

/* ================= UPDATE RESIDENT ================= */
function updateResident($conn, $id, $address, $phone, $notes) {

    $stmt = $conn->prepare("
        UPDATE residents 
        SET address = ?, phone = ?, location_notes = ?
        WHERE resident_id = ?
    ");

    $stmt->bind_param("sssi", $address, $phone, $notes, $id);
    return $stmt->execute();
}

/* ================= DELETE RESIDENT ================= */
function deleteResident($conn, $id) {

    $stmt = $conn->prepare("
        DELETE FROM residents WHERE resident_id = ?
    ");

    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>