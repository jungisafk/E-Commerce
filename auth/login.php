<?php
// Start the session
session_start();

// If user is already logged in, redirect to appropriate dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: ' . ($_SESSION['role'] === 'seller' ? 'seller-dashboard.php' : 'buyer-dashboard.php'));
    exit;
}

// Initialize variables
$login_error = '';
$register_error = '';
$register_success = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Get form data
    $email = filter_input(INPUT_POST, 'login_email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['login_password'];
    
    // Connect to database
    require_once 'config/db.php';
    
    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a new session
                session_regenerate_id();
                
                // Store data in session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect user to appropriate dashboard
                header('Location: ' . ($user['role'] === 'seller' ? 'seller-dashboard.php' : 'buyer-dashboard.php'));
                exit;
            } else {
                $login_error = 'Invalid password';
            }
        } else {
            $login_error = 'No account found with that email';
        }
    } catch (PDOException $e) {
        $login_error = 'Database error: ' . $e->getMessage();
    }
}

// Process registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Get form data
    $name = filter_input(INPUT_POST, 'register_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'register_email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['register_password'];
    $confirm_password = $_POST['register_confirm_password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    
    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {
        $register_error = 'All fields are required';
    } elseif ($password !== $confirm_password) {
        $register_error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $register_error = 'Password must be at least 8 characters long';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = 'Invalid email format';
    } elseif (!in_array($role, ['buyer', 'seller'])) {
        $register_error = 'Invalid role selected';
    } else {
        // Connect to database
        require_once 'config/db.php';
        
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $register_error = 'Email already exists';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Prepare SQL statement
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                
                // Execute statement
                if ($stmt->execute([$name, $email, $hashed_password, $role])) {
                    // If user is a seller, add store information
                    if ($role === 'seller' && !empty($_POST['store_name'])) {
                        $user_id = $pdo->lastInsertId();
                        $store_name = filter_input(INPUT_POST, 'store_name', FILTER_SANITIZE_STRING);
                        $store_description = filter_input(INPUT_POST, 'store_description', FILTER_SANITIZE_STRING);
                        
                        $stmt = $pdo->prepare("INSERT INTO stores (user_id, name, description) VALUES (?, ?, ?)");
                        $stmt->execute([$user_id, $store_name, $store_description]);
                    }
                    
                    $register_success = 'Registration successful! You can now log in.';
                } else {
                    $register_error = 'Registration failed';
                }
            }
        } catch (PDOException $e) {
            $register_error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Login Container -->
    <main>
        <div class="container">
            <div class="auth-container">
                <div class="auth-tabs">
                    <div class="auth-tab <?php echo !isset($_GET['register']) ? 'active' : ''; ?>" onclick="switchTab('login')">Login</div>
                    <div class="auth-tab <?php echo isset($_GET['register']) ? 'active' : ''; ?>" onclick="switchTab('register')">Register</div>
                </div>
                
                <div id="login-form" class="auth-form" style="<?php echo isset($_GET['register']) ? 'display: none;' : ''; ?>">
                    <?php if (!empty($login_error)): ?>
                        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            <?php echo $login_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($register_success)): ?>
                        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            <?php echo $register_success; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="login.php">
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="login_email" placeholder="Enter your email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" name="login_password" placeholder="Enter your password" required>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="remember-me" name="remember_me">
                                <label for="remember-me">Remember me</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="login" class="auth-btn">Login</button>
                        
                        <div class="auth-footer">
                            <a href="forgot-password.php">Forgot your password?</a>
                        </div>
                    </form>
                </div>
                
                <div id="register-form" class="auth-form" style="<?php echo !isset($_GET['register']) ? 'display: none;' : ''; ?>">
                    <?php if (!empty($register_error)): ?>
                        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            <?php echo $register_error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="login.php?register=1">
                        <div class="role-selector">
                            <div class="role-option <?php echo (!isset($_POST['role']) || $_POST['role'] === 'buyer') ? 'active' : ''; ?>" onclick="selectRole('buyer')">
                                <div class="role-icon">🛒</div>
                                <div class="role-title">Buyer</div>
                                <div class="role-description">Shop and browse products</div>
                            </div>
                            
                            <div class="role-option <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'active' : ''; ?>" onclick="selectRole('seller')">
                                <div class="role-icon">💼</div>
                                <div class="role-title">Seller</div>
                                <div class="role-description">Sell your products</div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="role-input" name="role" value="<?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'seller' : 'buyer'; ?>">
                        
                        <div class="form-group">
                            <label for="register-name">Full Name</label>
                            <input type="text" id="register-name" name="register_name" placeholder="Enter your full name" value="<?php echo isset($_POST['register_name']) ? htmlspecialchars($_POST['register_name']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-email">Email</label>
                            <input type="email" id="register-email" name="register_email" placeholder="Enter your email" value="<?php echo isset($_POST['register_email']) ? htmlspecialchars($_POST['register_email']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <input type="password" id="register-password" name="register_password" placeholder="Create a password (min. 8 characters)" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-confirm-password">Confirm Password</label>
                            <input type="password" id="register-confirm-password" name="register_confirm_password" placeholder="Confirm your password" required>
                        </div>
                        
                        <div class="form-group seller-fields" style="display: <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'block' : 'none'; ?>;">
                            <label for="store-name">Store Name</label>
                            <input type="text" id="store-name" name="store_name" placeholder="Enter your store name" value="<?php echo isset($_POST['store_name']) ? htmlspecialchars($_POST['store_name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group seller-fields" style="display: <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'block' : 'none'; ?>;">
                            <label for="store-description">Store Description</label>
                            <textarea id="store-description" name="store_description" placeholder="Describe your store and what you sell"><?php echo isset($_POST['store_description']) ? htmlspecialchars($_POST['store_description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">I agree to the <a href="terms.php">Terms and Conditions</a></label>
                            </div>
                        </div>
                        
                        <button type="submit" name="register" class="auth-btn">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Newsletter Section -->
    <?php include 'includes/newsletter.php'; ?>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script>
        function switchTab(tab) {
            if (tab === 'login') {
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
                document.querySelector('.auth-tab:nth-child(1)').classList.add('active');
                document.querySelector('.auth-tab:nth-child(2)').classList.remove('active');
                history.replaceState(null, '', 'login.php');
            } else {
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
                document.querySelector('.auth-tab:nth-child(1)').classList.remove('active');
                document.querySelector('.auth-tab:nth-child(2)').classList.add('active');
                history.replaceState(null, '', 'login.php?register=1');
            }
        }
        
        function selectRole(role) {
            document.getElementById('role-input').value = role;
            
            if (role === 'buyer') {
                document.querySelector('.role-option:nth-child(1)').classList.add('active');
                document.querySelector('.role-option:nth-child(2)').classList.remove('active');
                document.querySelectorAll('.seller-fields').forEach(field => {
                    field.style.display = 'none';
                });
            } else {
                document.querySelector('.role-option:nth-child(1)').classList.remove('active');
                document.querySelector('.role-option:nth-child(2)').classList.add('active');
                document.querySelectorAll('.seller-fields').forEach(field => {
                    field.style.display = 'block';
                });
            }
        }
    </script>
</body>
</html>
