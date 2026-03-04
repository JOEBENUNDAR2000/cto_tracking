<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HR System | Secure Login</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

body {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(-45deg, #0f2027, #203a43, #2c5364, #1c92d2);
    background-size: 400% 400%;
    animation: gradientMove 12s ease infinite;
}

@keyframes gradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.login-card {
    width: 420px;
    padding: 45px 35px;
    border-radius: 25px;
    backdrop-filter: blur(25px);
    background: rgba(255, 255, 255, 0.12);
    box-shadow: 0 15px 40px rgba(0,0,0,0.4);
    color: white;
    animation: fadeInUp 0.8s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-title {
    font-weight: 700;
    letter-spacing: 1px;
}

.system-badge {
    background: rgba(255,255,255,0.2);
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 13px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.form-control {
    background: rgba(255,255,255,0.15);
    border: none;
    border-radius: 14px;
    color: white;
    padding: 12px 15px;
}

.form-control:focus {
    background: rgba(255,255,255,0.25);
    box-shadow: 0 0 0 2px rgba(255,255,255,0.3);
    color: white;
}

.form-floating > label {
    color: rgba(255,255,255,0.7);
}

.btn-login {
    border-radius: 14px;
    padding: 12px;
    font-weight: 600;
    background: white;
    color: #1c92d2;
    transition: all 0.3s ease;
}

.btn-login:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

.toggle-icon {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: rgba(255,255,255,0.7);
    transition: 0.3s;
}

.toggle-icon:hover {
    color: white;
}

.footer-text {
    font-size: 13px;
    opacity: 0.8;
}

</style>
</head>

<body>

<div class="login-card text-center">

    <div class="mb-4">
        <div class="system-badge mb-3">
            <i class="bi bi-shield-lock-fill me-2"></i> Secure Enterprise Access
        </div>
        <h4 class="login-title">Human Resources System</h4>
        <small class="text-light opacity-75">Sign in to continue</small>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger text-start">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login'); ?>" method="post">

        <div class="form-floating mb-3 text-dark">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <label>Username</label>
        </div>

        <div class="form-floating mb-4 position-relative text-dark">
            <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Password" required>
            <label>Password</label>

            <i class="bi bi-eye toggle-icon"
               id="toggleIcon"
               onclick="togglePassword()"></i>
        </div>

        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </button>

    </form>

    <div class="mt-4 footer-text">
        © <?= date('Y'); ?> Human Resources System | All Rights Reserved
    </div>

</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        password.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>

</body>
</html>