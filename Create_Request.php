<?php
include('Connection.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = "";

/* ================= INSERT REQUEST ================= */
if (isset($_POST['submit'])) {
    $type = trim($_POST['waste_type']);
    $desc = trim($_POST['description']);
    $loc  = trim($_POST['location']);
    $img  = "";

    if (!empty($_FILES['image']['name'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (!in_array($ext, $allowed_extensions)) {
            $error_message = "Invalid file format. Only JPG, JPEG, PNG, and WEBP allowed.";
        } elseif ($file_size > 5 * 1024 * 1024) {
            $error_message = "File size exceeds the 5MB maximum limit.";
        } else {
            $img = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755, true);
            }
            move_uploaded_file($file_tmp, "uploads/" . $img);
        }
    }

    if (empty($error_message)) {
        $stmt = $conn->prepare("INSERT INTO waste_requests (resident_id, waste_type, description, image, location, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("issss", $user_id, $type, $desc, $img, $loc);
        $stmt->execute();
        $stmt->close();
        
        header("Location: create_request.php");
        exit();
    }
}

/* ================= DATABASE MANIPULATION ================= */
if (isset($_GET['action'], $_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    $allowed_statuses = ['pending', 'assigned', 'in_progress', 'completed'];

    if (in_array($action, $allowed_statuses)) {
        $stmt = $conn->prepare("UPDATE waste_requests SET status = ? WHERE request_id = ?");
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: create_request.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f5; font-family: 'Segoe UI', system-ui, sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); }
        .app-logo { height: 40px; width: auto; object-fit: contain; }
        
        /* Notification Stream Card Items */
        .notification-item {
            border-left: 5px solid #ccc;
            transition: all 0.2s ease;
            background: #fff;
        }
        .notification-item.border-pending { border-left-color: #ff9800; background: #fffcf5; }
        .notification-item.border-assigned { border-left-color: #2196f3; }
        .notification-item.border-progress { border-left-color: #9c27b0; }
        .notification-item.border-completed { border-left-color: #4caf50; }
        .notification-item:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.06); }

        /* Badge Customization */
        .bg-pending { background-color: #ffe6cc; color: #ff9800; font-weight: 600; }
        .bg-assigned { background-color: #e1f5fe; color: #0288d1; font-weight: 600; }
        .bg-progress { background-color: #f3e5f5; color: #7b1fa2; font-weight: 600; }
        .bg-completed { background-color: #e8f5e9; color: #388e3c; font-weight: 600; }

        .thumb-preview { width: 56px; height: 56px; object-fit: cover; border-radius: 10px; cursor: pointer; }
        .btn-outline-purple { color: #9c27b0; border-color: #9c27b0; }
        .btn-outline-purple:hover, .btn-outline-purple.active { background-color: #9c27b0; color: #fff; border-color: #9c27b0; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-success shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="eco.png" alt="Eco Logo" class="app-logo">
            <span class="fw-bold tracking-wide">EcoWaste Management</span>
        </a>
    </div>
</nav>

<div class="container">
    <a href="Resident.php" class="btn btn-dark btn-sm rounded-pill px-3 mb-4">⬅ Dashboard</a>

    <?php if(!empty($error_message)) { ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <?= htmlspecialchars($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card p-4">
                <h4 class="mb-3 fw-bold text-success">Create Request</h4>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Waste Type</label>
                        <select name="waste_type" class="form-select rounded-3" required>
                            <option>Plastic</option>
                            <option>Organic</option>
                            <option>Metal</option>
                            <option>Glass</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Description</label>
                        <textarea name="description" class="form-control rounded-3" placeholder="Provide details..." rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Pickup Location</label>
                        <input name="location" class="form-control rounded-3" placeholder="Street name, landmark..." required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Upload Image (Optional)</label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/png, image/jpeg, image/webp">
                    </div>
                    <button class="btn btn-success w-100 py-2 rounded-3 fw-bold" name="submit">Submit Request</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold m-0 text-secondary">Activity Stream</h4>
                <span class="badge bg-secondary rounded-pill">Updates Feed</span>
            </div>

            <div class="notification-feed">
                <?php
                $stmt = $conn->prepare("SELECT * FROM waste_requests WHERE resident_id = ? ORDER BY request_date DESC");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows === 0) {
                    echo '<div class="card p-5 text-center text-muted"><i class="bi bi-bell-slash fs-1"></i><p class="mt-2">No active notification requests found.</p></div>';
                }

                while($r = $result->fetch_assoc()) {
                    $status_key = $r['status'];
                    $border_class = "border-" . ($status_key == 'in_progress' ? 'progress' : $status_key);
                    $badge_class = "bg-" . ($status_key == 'in_progress' ? 'progress' : $status_key);
                ?>
                    <div class="card notification-item <?= $border_class ?> p-3 mb-3">
                        <div class="row align-items-center g-3">
                            
                            <div class="col-sm-7">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge <?= $badge_class ?> rounded-pill px-2.5 py-1 text-capitalize"><?= str_replace('_', ' ', $status_key) ?></span>
                                    <span class="text-muted small fw-medium"><i class="bi bi-tag"></i> ID: #<?= $r['request_id'] ?></span>
                                </div>
                                <h5 class="fw-bold text-dark my-1"><?= htmlspecialchars($r['waste_type']) ?> Waste Disposal</h5>
                                <p class="text-muted small mb-0 text-truncate" style="max-width: 380px;"><?= htmlspecialchars($r['description']) ?></p>
                                <small class="text-secondary d-block mt-1"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($r['location']) ?></small>
                            </div>

                            <div class="col-sm-2 text-sm-center">
                                <?php if(!empty($r['image']) && file_exists("uploads/".$r['image'])) { ?>
                                    <img src="uploads/<?= htmlspecialchars($r['image']) ?>" 
                                         class="thumb-preview border" 
                                         alt="Waste asset preview"
                                         onclick="openImage('uploads/<?= htmlspecialchars($r['image']) ?>')">
                                <?php } else { ?>
                                    <span class="text-muted small d-block py-2"><i class="bi bi-image text-light fs-3"></i></span>
                                <?php } ?>
                            </div>

                            <div class="col-sm-3 text-sm-end d-flex flex-sm-column gap-2 justify-content-end">
                                <button class="btn btn-light btn-sm text-secondary border rounded-pill px-3" onclick="viewDetail(
                                    '<?= addslashes(htmlspecialchars($r['waste_type'])) ?>',
                                    '<?= addslashes(htmlspecialchars($r['description'])) ?>',
                                    '<?= addslashes(htmlspecialchars($r['location'])) ?>',
                                    '<?= addslashes(htmlspecialchars($r['status'])) ?>',
                                    '<?= !empty($r['image']) ? 'uploads/'.addslashes(htmlspecialchars($r['image'])) : '' ?>'
                                )"><i class="bi bi-eye"></i> View</button>
                                
                                <div class="btn-group btn-group-sm w-100" role="group">
                                    <a href="?action=assigned&id=<?= $r['request_id'] ?>" class="btn btn-outline-primary <?= $status_key == 'assigned' ? 'active' : '' ?>" title="Assign Task">Assign</a>
                                    <a href="?action=in_progress&id=<?= $r['request_id'] ?>" class="btn btn-outline-purple <?= $status_key == 'in_progress' ? 'active' : '' ?>" title="Set In Progress">Prog</a>
                                    <a href="?action=completed&id=<?= $r['request_id'] ?>" class="btn btn-outline-success <?= $status_key == 'completed' ? 'active' : '' ?>" title="Complete Task">Done</a>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } $stmt->close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="bi bi-info-circle"></i> Notification Breakdown</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <span class="text-muted small d-block font-monospace uppercase">Category Classification</span>
                    <h4 id="d_type" class="fw-bold text-success m-0"></h4>
                </div>
                <hr class="text-black-50">
                <p class="mb-2"><strong class="text-dark">Description:</strong> <span id="d_desc" class="text-secondary"></span></p>
                <p class="mb-2"><strong class="text-dark">Destination Target:</strong> <span id="d_loc" class="text-secondary"></span></p>
                <p class="mb-0"><strong class="text-dark">Current Phase Status:</strong> <span id="d_status" class="badge bg-light text-dark border"></span></p>
                <div class="text-center mt-4">
                    <img id="d_img" class="modal-img d-none img-fluid rounded border shadow-sm" alt="Disposal detail verification file asset">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0">
                <img id="zoomImg" class="img-fluid rounded shadow-lg" style="max-height: 80vh;" alt="Scaled preview verification rendering view">
                <div class="mt-3">
                    <button type="button" class="btn btn-light rounded-pill shadow-sm px-4 btn-sm" data-bs-dismiss="modal">Close Window</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewDetail(type, desc, loc, status, img){
    document.getElementById("d_type").innerText = type;
    document.getElementById("d_desc").innerText = desc;
    document.getElementById("d_loc").innerText = loc;
    document.getElementById("d_status").innerText = status.toUpperCase().replace('_', ' ');
    
    let modalImg = document.getElementById("d_img");
    if(img) {
        modalImg.src = img;
        modalImg.classList.remove('d-none');
    } else {
        modalImg.classList.add('d-none');
    }
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function openImage(src){
    document.getElementById("zoomImg").src = src;
    new bootstrap.Modal(document.getElementById('imgModal')).show();
}
</script>
</body>
</html>