<?php
include "Connection.php";

/* ================= ADD VEHICLE ================= */
function addVehicle($conn, $plate, $type, $capacity) {

    $stmt = $conn->prepare("
        INSERT INTO vehicles (plate_number, vehicle_type, capacity, status)
        VALUES (?, ?, ?, 'available')
    ");

    $stmt->bind_param("ssd", $plate, $type, $capacity);
    return $stmt->execute();
}

/* ================= UPDATE VEHICLE ================= */
function updateVehicle($conn, $id, $plate, $type, $capacity, $status) {

    $stmt = $conn->prepare("
        UPDATE vehicles 
        SET plate_number=?, vehicle_type=?, capacity=?, status=?
        WHERE vehicle_id=?
    ");

    $stmt->bind_param("ssdsi", $plate, $type, $capacity, $status, $id);
    return $stmt->execute();
}

/* ================= DELETE VEHICLE ================= */
function deleteVehicle($conn, $id) {

    $stmt = $conn->prepare("
        DELETE FROM vehicles 
        WHERE vehicle_id=?
    ");

    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

/* ================= GET ALL VEHICLES ================= */
function getVehicles($conn) {

    return $conn->query("
        SELECT * FROM vehicles 
        ORDER BY vehicle_id DESC
    ");
}

/* ================= GET SINGLE VEHICLE ================= */
function getVehicleById($conn, $id) {

    $stmt = $conn->prepare("
        SELECT * FROM vehicles WHERE vehicle_id=?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
?>