<!DOCTYPE html>
<html lang="en">

<?php include("../views/head.php"); ?>

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
                    <input type="text" name="username" placeholder="username" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <span class="toggle-password" onclick="togglePassword()"><i class="bi bi-eye"></i></span>
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