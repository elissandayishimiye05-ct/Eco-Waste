<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoWaste Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
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
            max-width: 360px;            /* Resized narrower for a sleeker profile */
            background: #ffffff;
            border: 1px solid #E2E8F0;    /* Added subtle border since background is white */
            border-radius: 16px;
            padding: 1.75rem 1.5rem;      /* Reduced padding to minimize overall height */
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
        }

        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;        /* Reduced spacing to minimize height */
        }

        .logo-img {
            width: 65px;                  /* Scaled down logo slightly */
            height: 65px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(16, 185, 129, 0.2);
        }

        .system-title {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.35rem;           /* Slightly smaller font size */
            letter-spacing: -0.5px;
        }

        .system-subtitle {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 1.5rem;        /* Reduced spacing to minimize height */
        }

        /* Modern Form Inputs */
        .form-label {
            color: var(--text-main);
            font-weight: 500;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }

        .form-control {
            padding: 0.6rem 0.85rem;      /* Tighter input padding for reduced height */
            border-color: var(--input-border);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.9rem;
            transition: all 0.2s ease;
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
            padding: 0.6rem;              /* Tighter button padding for reduced height */
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

    <div class="text-center">
        <div class="logo-wrapper">
            <img src="eco.png" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" class="logo-img" alt="EcoWaste Logo">
            <div class="bi bi-recycle text-success fs-2" style="display:none; width:65px; height:65px; line-height:65px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; margin: 0 auto;"></div>
        </div>
        <h3 class="system-title mt-1">EcoWaste</h3>
        
    </div>

    <form action="login_process.php" method="post" autocomplete="off">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>

        <button type="submit" class="btn btn-custom w-100 mt-2 shadow-sm">Sign In</button>
        
        <p class="text-center mt-3 mb-0 text-muted" style="font-size: 0.85rem;">
            Don't have an account? <a href="CreateAccount.php" class="signup-link">Sign up</a>
        </p>

    </form>

</div>

</body>
</html>