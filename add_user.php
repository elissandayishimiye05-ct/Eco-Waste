<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add User - EcoWaste</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .card {
            max-width: 500px;
            margin: 50px auto;
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .card-header {
            background: #198754;
            color: white;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="card">
    <div class="card-header">
        Add New User
    </div>

    <div class="card-body">

        <form action="save_user.php" method="post">

            <input type="text" name="fullname" placeholder="Full Name"
                   class="form-control mb-2" required>

            <input type="email" name="email" placeholder="Email"
                   class="form-control mb-2" required>

            <input type="text" name="phone" placeholder="Phone"
                   class="form-control mb-2">

            <input type="password" name="password" placeholder="Password"
                   class="form-control mb-2" required>

            <select name="role" class="form-control mb-3" required>
                <option value="admin">Admin</option>
                <option value="collector">Collector</option>
                <option value="recycling">Recycling</option>
                <option value="resident">Resident</option>
            </select>

            <button class="btn btn-success w-100">
                Save User
            </button>

        </form>

    </div>
</div>

</body>
</html>