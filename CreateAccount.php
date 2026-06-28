<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create EcoWaste Account</title>

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Premium Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-green: #1E3F20;     /* Deep forest branding */
            --accent-green: #10B981;      /* Modern emerald for interactive elements */
            --text-main: #1E293B;         /* Slate 800 */
            --text-muted: #64748B;        /* Slate 500 */
            --input-border: #E2E8F0;
        }

        body {
            background-color: #ffffff;    /* Clean White Background */
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 15px;
        }

        .login-card {
            width: 100%;
            max-width: 360px;            /* Same narrow, sleek profile as login */
            background: #ffffff;
            border: 1px solid #E2E8F0;    /* Subtle border matching login */
            border-radius: 16px;
            padding: 1.75rem 1.5rem;      /* Identical compact padding */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        }

        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .logo-img {
            width: 65px;                  /* Consistent logo scaling */
            height: 65px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(16, 185, 129, 0.2);
        }

        .system-title {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: -0.5px;
        }

        .system-subtitle {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        /* Modern Form Inputs & Input Group Fixes */
        .form-label {
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
        }

        .input-group-text {
            background-color: #F8FAFC;
            border-color: var(--input-border);
            color: var(--text-muted);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .form-control {
            padding: 0.55rem 0.85rem;      /* Clean, compact input padding */
            border-color: var(--input-border);
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
            color: var(--text-main);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
            outline: none;
        }

        /* Advanced Custom Button */
        .btn-custom {
            background-color: var(--primary-green);
            color: #ffffff;
            font-weight: 600;
            padding: 0.6rem;
            font-size: 0.95rem;
            border-radius: 8px;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-custom:hover {
            background-color: #142c16;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 63, 32, 0.15);
        }

        .btn-custom:active {
            transform: translateY(0);
        }

        /* Links */
        .signup-link {
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .signup-link:hover {
            color: #059669;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="card login-card">

    <!-- Header Section -->
    <div class="text-center">
        <div class="logo-wrapper">
            <img src="eco.png" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" class="logo-img" alt="EcoWaste Logo">
            <div class="bi bi-recycle text-success fs-2" style="display:none; width:65px; height:65px; line-height:65px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; margin: 0 auto;"></div>
        </div>
        <h3 class="system-title mt-1">EcoWaste</h3>
        <p class="system-subtitle">Create your system account</p>
    </div>

    <!-- Form Section -->
    <form action="register_process.php" method="post" autocomplete="off">

        <!-- Full Name -->
        <div class="mb-2.5" style="margin-bottom: 0.75rem;">
            <label class="form-label">Full Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="fullname" class="form-control" placeholder="John Doe" required>
            </div>
        </div>

        <!-- Email -->
        <div class="mb-2.5" style="margin-bottom: 0.75rem;">
            <label class="form-label">Email Address</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
            </div>
        </div>

        <!-- Phone -->
        <div class="mb-2.5" style="margin-bottom: 0.75rem;">
            <label class="form-label">Phone Number</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="phone" class="form-control" placeholder="0 788 000 000">
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3.5" style="margin-bottom: 1.25rem;">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom w-100 shadow-sm">Create New Account</button>
        
        <!-- Redirection Link -->
        <p class="text-center mt-3 mb-0 text-muted" style="font-size: 0.85rem;">
            Already have an account? <a href="Login.php" class="signup-link">Login</a>
        </p>

    </form>

</div>

</body>
</html>