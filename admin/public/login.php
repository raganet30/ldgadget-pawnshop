<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login | LD Gadget Pawnshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/admin_style.css">
    <link rel="icon" type="image/png" href="../assets/pawnshop.png">
</head>

<body>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h1>LD Gadget Pawnshop</h1>
                <p>Admin Login</p>
            </div>

            <form class="login-form" method="POST" action="../processes/login_process.php">

                <!-- Error alert -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="login-error">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label>Email or Username</label>
                    <input type="text" name="username" placeholder="admin@example.com" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <span class="toggle-password" onclick="togglePassword()">👁</span>
                    </div>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <div class="login-footer">
                    <a href="#">Forgot password?</a>
                </div>
            </form>

        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            pwd.type = pwd.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>