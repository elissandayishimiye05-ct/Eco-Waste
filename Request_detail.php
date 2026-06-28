<?php
include('Connection.php');
session_start();

/* =========================
   CHECK ID
========================= */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Create_Request.php");
    exit();
}

$id = intval($_GET['id']);

/* =========================
   FETCH REQUEST
========================= */
$sql = "SELECT * FROM waste_requests WHERE request_id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: Create_Request.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background:#e8f5e9; }

        .card {
            border:none;
            border-radius:15px;
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
        }

        .header {
            background:#2e7d32;
            color:white;
            padding:12px;
            border-radius:15px 15px 0 0;
        }

        .badge-pending { background:orange; }
        .badge-assigned { background:blue; }
        .badge-progress { background:purple; }
        .badge-completed { background:green; }
    </style>
</head>

<body>

<div class="container mt-4">

    <a href="create_request.php" class="btn btn-dark mb-3">⬅ Back</a>

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="header text-center">
                    <h4>🌿 Waste Request Detail</h4>
                </div>

                <div class="card-body">
                    

                    <div class="row">

                        <!-- IMAGE -->
                        <div class="col-md-5 text-center">
                            <?php if (!empty($row['image'])) { ?>
                                <img src="uploads/<?php echo $row['image']; ?>" 
                                     class="img-fluid rounded"
                                     style="max-height:250px;">
                            <?php } else { ?>
                                <p>No image uploaded</p>
                            <?php } ?>
                        </div>

                        <!-- DETAILS -->
                        <div class="col-md-7">

                            <h5>Waste Type:</h5>
                            <p><?php echo $row['waste_type']; ?></p>

                            <h5>Description:</h5>
                            <p><?php echo $row['description']; ?></p>

                            <h5>Location:</h5>
                            <p><?php echo $row['location']; ?></p>

                            <h5>Date:</h5>
                            <p><?php echo $row['request_date']; ?></p>

                            <h5>Status:</h5>

                            <span class="badge
                                <?php
                                    if ($row['status'] == 'pending') echo 'badge-pending';
                                    elseif ($row['status'] == 'assigned') echo 'badge-assigned';
                                    elseif ($row['status'] == 'in_progress') echo 'badge-progress';
                                    else echo 'badge-completed';
                                ?>
                            ">
                                <?php echo $row['status']; ?>
                            </span>

                        </div>

                    </div>

                    <hr>

                    <div class="text-end">
                        <a href="create_request.php" class="btn btn-success">
                            Back to Requests
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>