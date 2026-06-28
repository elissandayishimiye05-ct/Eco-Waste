<?php
include "Connection.php";
session_start();

/* =========================
   UPDATE STATUS (POST)
========================= */
if (isset($_POST['action']) && isset($_POST['id'])) {

    $id = intval($_POST['id']);
    $action = $_POST['action'];

    $allowed = ['assigned', 'in_progress', 'completed'];

    if (in_array($action, $allowed)) {

        $stmt = $conn->prepare("
            UPDATE waste_requests 
            SET status = ? 
            WHERE request_id = ?
        ");

        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: waste_requests.php");
    exit();
}

/* =========================
   FETCH DATA
========================= */
$result = $conn->query("
    SELECT 
        wr.*,
        u.fullname
    FROM waste_requests wr
    LEFT JOIN residents r ON wr.resident_id = r.resident_id
    LEFT JOIN users u ON r.user_id = u.user_id
    ORDER BY wr.request_date DESC
");

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Waste Requests</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h3>Waste Requests</h3>

<table class="table table-bordered text-center align-middle">

<thead class="table-success">
<tr>
    <th>ID</th>
    <th>Resident</th>
    <th>Type</th>
    <th>Image</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while ($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?= $row['request_id'] ?></td>
    <td><?= $row['fullname'] ?? 'Unknown' ?></td>
    <td><?= $row['waste_type'] ?></td>

    <td>
        <?php if (!empty($row['image'])) { ?>
            <img src="uploads/<?= $row['image'] ?>"
                 width="60"
                 height="60"
                 style="object-fit:cover;border-radius:6px;">
        <?php } else { ?>
            No image
        <?php } ?>
    </td>

    <td><?= $row['status'] ?></td>

    <td class="d-flex gap-1 justify-content-center">

        <!-- VIEW BUTTON (ZOOM) -->
        <button 
            class="btn btn-dark btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#viewModal"
            onclick="viewData(
                '<?= $row['fullname'] ?>',
                '<?= $row['waste_type'] ?>',
                '<?= $row['description'] ?>',
                '<?= $row['location'] ?>',
                '<?= $row['image'] ?>',
                '<?= $row['status'] ?>'
            )">
            <i class="bi bi-eye"></i>
        </button>

        <!-- STATUS BUTTONS -->
        <form method="POST">
            <input type="hidden" name="id" value="<?= $row['request_id'] ?>">
            <input type="hidden" name="action" value="assigned">
            <button class="btn btn-info btn-sm">Assign</button>
        </form>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $row['request_id'] ?>">
            <input type="hidden" name="action" value="in_progress">
            <button class="btn btn-primary btn-sm">Start</button>
        </form>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $row['request_id'] ?>">
            <input type="hidden" name="action" value="completed">
            <button class="btn btn-success btn-sm">Done</button>
        </form>

    </td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

<!-- =========================
     VIEW MODAL (ZOOM)
========================= -->
<div class="modal fade" id="viewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Request Details</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <p><strong>Resident:</strong> <span id="vName"></span></p>
        <p><strong>Waste Type:</strong> <span id="vType"></span></p>
        <p><strong>Description:</strong> <span id="vDesc"></span></p>
        <p><strong>Location:</strong> <span id="vLoc"></span></p>
        <p><strong>Status:</strong> <span id="vStatus"></span></p>

        <hr>

        <img id="vImg"
             src=""
             style="width:100%; max-height:400px; object-fit:contain; border-radius:10px;">

      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function viewData(name, type, desc, loc, img, status) {

    document.getElementById("vName").innerText = name;
    document.getElementById("vType").innerText = type;
    document.getElementById("vDesc").innerText = desc;
    document.getElementById("vLoc").innerText = loc;
    document.getElementById("vStatus").innerText = status;

    if (img) {
        document.getElementById("vImg").src = "uploads/" + img;
    } else {
        document.getElementById("vImg").src = "";
    }
}
</script>

</body>
</html>