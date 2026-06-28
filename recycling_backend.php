<?php
include "Connection.php";

/* ================= ADD CENTER ================= */
function addCenter($conn, $name, $location, $phone) {

    $stmt = $conn->prepare("
        INSERT INTO recycling_centers (center_name, location, contact_phone)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("sss", $name, $location, $phone);
    return $stmt->execute();
}

/* ================= DELETE CENTER ================= */
function deleteCenter($conn, $id) {

    $stmt = $conn->prepare("
        DELETE FROM recycling_centers 
        WHERE center_id = ?
    ");

    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

/* ================= GET ALL CENTERS ================= */
function getCenters($conn) {

    return $conn->query("
        SELECT * FROM recycling_centers 
        ORDER BY center_id DESC
    ");
}
?>