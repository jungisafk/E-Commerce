<?php
session_start();

// Check if user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect to appropriate dashboard based on role
    if($_SESSION["role"] === "seller") {
        header("location: seller-dashboard.php");
    } else {
        header("location: index.php");
    }
    exit;
}

// Initialize variables
$login_error = "";
$register_error = "";
$register_success = "";

// Process login form
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    require_once 'config/db.php';
    
    // Get form data
    $email = trim($_POST["loginEmail"]);
    $password = $_POST["loginPassword"];
    
    // Validate input
    if(empty($email) || empty($password)) {
        $login_error = "Please enter both email and password.";
    } else {
        try {
            // Prepare a select statement
            $sql = "SELECT id, name, email, password, role FROM users WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            
            // Execute the statement
            $stmt->execute();
            
            // Check if email exists
            if($stmt->rowCount() == 1) {
                $user = $stmt->fetch();
                
                // Verify the password
                if(password_verify($password, $user['password'])) {
                    // Password is correct, start a new session
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["name"] = $user['name'];
                    $_SESSION["email"] = $user['email'];
                    $_SESSION["role"] = $user['role'];
                    
                    // Redirect user based on role
                    if($user['role'] == 'seller') {
                        header("location: seller-dashboard.php");
                    } else {
                        header("location: index.php");
                    }
                    exit;
                } else {
                    // Password is not valid
                    $login_error = "Invalid password.";
                }
            } else {
                // Email doesn't exist
                $login_error = "No account found with that email.";
            }
        } catch(PDOException $e) {
            $login_error = "Error: " . $e->getMessage();
        }
    }
}

// Process registration form
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    require_once 'config/db.php';
    
    // Get form data
    $name = trim($_POST["registerName"]);
    $email = trim($_POST["registerEmail"]);
    $password = $_POST["registerPassword"];
    $confirm_password = $_POST["confirmPassword"];
    $role = isset($_POST["role"]) ? $_POST["role"] : "buyer"; // Default to buyer
    
    // Validate input
    $errors = [];
    
    if(empty($name)) {
        $errors[] = "Please enter your name.";
    }
    
    if(empty($email)) {
        $errors[] = "Please enter your email.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if(empty($password)) {
        $errors[] = "Please enter a password.";
    } elseif(strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    
    if($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    
    if(!isset($_POST["agreeTerms"])) {
        $errors[] = "You must agree to the Terms & Conditions.";
    }
    
    // Check if email already exists
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $errors[] = "Email already exists. Please use a different email or login.";
        }
    } catch(PDOException $e) {
        $errors[] = "Error: " . $e->getMessage();
    }
    
    // If no errors, proceed with registration
    if(empty($errors)) {
        try {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            
            // Execute the statement
            $stmt->execute();
            
            // Registration successful
            $register_success = "Registration successful! You can now login.";
            
        } catch(PDOException $e) {
            $register_error = "Error: " . $e->getMessage();
        }
    } else {
        $register_error = implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Additional styles for auth forms */
        .auth-container {
            display: flex;
            justify-content: center;
            padding: 40px 0;
        }
        
        .auth-form {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .auth-title {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .auth-form-group {
            margin-bottom: 20px;
        }
        
        .auth-form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .auth-form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .auth-form-check {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: #e83e8c;
            text-decoration: none;
        }
        
        .auth-btn {
            width: 100%;
            padding: 12px;
            background-color: #e83e8c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .auth-btn:hover {
            background-color: #d33a7e;
        }
        
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background-color: #e5e5e5;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #777;
        }
        
        .social-login {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .facebook-btn {
            background-color: #3b5998;
            color: white;
        }
        
        .google-btn {
            background-color: #db4437;
            color: white;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 20px;
        }
        
        .auth-footer a {
            color: #e83e8c;
            text-decoration: none;
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        /* Role selector styles */
        .role-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .role-option {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .role-option.active {
            border-color: #e83e8c;
            background-color: rgba(232, 62, 140, 0.05);
        }
        
        .role-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .role-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .role-description {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">FASHION<span>TRENDS</span></a></div>
            
            <div class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">
                ☰
            </div>
            
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="men.php">Men</a>
                <a href="women.php">Women</a>
                <a href="kids.php">Kids</a>
                <a href="accessories.php">Accessories</a>
                <a href="sale.php">Sale</a>
            </nav>
            
            <div class="header-icons">
                <div class="icon search-icon" onclick="toggleSearchBar()">🔍</div>
                <div class="icon" onclick="window.location.href='account.php'">👤</div>
                <div class="icon">💖</div>
                <div class="icon" onclick="window.location.href='cart.php'">
                    🛒
                    <span class="cart-count">0</span>
                </div>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="container">
                <form id="search-form" action="search.php" method="get">
                    <input type="text" id="search-input" name="q" placeholder="Search for products..." autocomplete="off">
                    <button type="submit" class="search-btn">Search</button>
                    <div class="close-search" onclick="toggleSearchBar()">✕</div>
                </form>
                <div class="search-suggestions" id="search-suggestions"></div>
            </div>
        </div>
    </header>
    
    <!-- Login/Register Section -->
    <div class="container auth-container">
        <!-- Login Form -->
        <div class="auth-form" id="login-form" style="display: <?php echo (isset($_POST['register']) || isset($register_success)) ? 'none' : 'block'; ?>">
            <h2 class="auth-title">Login</h2>
            
            <?php if(!empty($login_error)): ?>
                <div class="alert alert-danger"><?php echo $login_error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="auth-form-group">
                    <label for="loginEmail" class="auth-form-label">Email Address *</label>
                    <input type="email" id="loginEmail" name="loginEmail" class="auth-form-control" required>
                </div>
                
                <div class="auth-form-group">
                    <label for="loginPassword" class="auth-form-label">Password *</label>
                    <input type="password" id="loginPassword" name="loginPassword" class="auth-form-control" required>
                </div>
                
                <div class="auth-form-check">
                    <div class="remember-me">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <label for="rememberMe">Remember me</label>
                    </div>
                    
                    <a href="forgot-password.php" class="forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" name="login" class="btn auth-btn">Login</button>
                
                <div class="auth-divider">
                    <div class="divider-line"></div>
                    <div class="divider-text">OR</div>
                    <div class="divider-line"></div>
                </div>
                
                <div class="social-login">
                    <div class="social-btn facebook-btn">f Facebook</div>
                    <div class="social-btn google-btn">G Google</div>
                </div>
                
                <div class="auth-footer">
                    Don't have an account? <a href="#" onclick="toggleForms()">Register</a>
                </div>
            </form>
        </div>
        
        <!-- Register Form -->
        <div class="auth-form" id="register-form" style="display: <?php echo (isset($_POST['register']) || isset($register_success)) ? 'block' : 'none'; ?>">
            <h2 class="auth-title">Register</h2>
            
            <?php if(!empty($register_error)): ?>
                <div class="alert alert-danger"><?php echo $register_error; ?></div>
            <?php endif; ?>
            
            <?php if(!empty($register_success)): ?>
                <div class="alert alert-success"><?php echo $register_success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="role-selector">
                    <div class="role-option active" onclick="selectRole('buyer')">
                        <div class="role-icon">🛒</div>
                        <div class="role-title">Buyer</div>
                        <div class="role-description">Shop and browse products</div>
                        <input type="radio" name="role" value="buyer" checked style="display: none;">
                    </div>
                    
                    <div class="role-option" onclick="selectRole('seller')">
                        <div class="role-icon">💼</div>
                        <div class="role-title">Seller</div>
                        <div class="role-description">Sell your products</div>
                        <input type="radio" name="role" value="seller" style="display: none;">
                    </div>
                </div>
                
                <div class="auth-form-group">
                    <label for="registerName" class="auth-form-label">Full Name *</label>
                    <input type="text" id="registerName" name="registerName" class="auth-form-control" required>
                </div>
                
                <div class="auth-form-group">
                    <label for="registerEmail" class="auth-form-label">Email Address *</label>
                    <input type="email" id="registerEmail" name="registerEmail" class="auth-form-control" required>
                </div>
                
                <div class="auth-form-group">
                    <label for="registerPassword" class="auth-form-label">Password *</label>
                    <input type="password" id="registerPassword" name="registerPassword" class="auth-form-control" required>
                </div>
                
                <div class="auth-form-group">
                    <label for="confirmPassword" class="auth-form-label">Confirm Password *</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="auth-form-control" required>
                </div>
                
                <div class="seller-fields" style="display: none;">
                    <div class="auth-form-group">
                        <label for="storeName" class="auth-form-label">Store Name *</label>
                        <input type="text" id="storeName" name="storeName" class="auth-form-control">
                    </div>
                    
                    <div class="auth-form-group">
                        <label for="storeDescription" class="auth-form-label">Store Description</label>
                        <textarea id="storeDescription" name="storeDescription" class="auth-form-control" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="auth-form-check">
                    <div class="remember-me">
                        <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
                        <label for="agreeTerms">I agree to the <a href="#">Terms & Conditions</a></label>
                    </div>
                </div>
                
                <button type="submit" name="register" class="btn auth-btn">Register</button>
                
                <div class="auth-divider">
                    <div class="divider-line"></div>
                    <div class="divider-text">OR</div>
                    <div class="divider-line"></div>
                </div>
                
                <div class="social-login">
                    <div class="social-btn facebook-btn">f Facebook</div>
                    <div class="social-btn google-btn">G Google</div>
                </div>
                
                <div class="auth-footer">
                    Already have an account? <a href="#" onclick="toggleForms()">Login</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Newsletter Section -->
    <section class="section newsletter">
        <div class="container">
            <h2 class="section-title">Subscribe to Our Newsletter</h2>
            <p class="section-subtitle">Get the latest updates on new products and upcoming sales</p>
            
            <form class="newsletter-form">
                <input type="email" placeholder="Your email address" class="newsletter-input" required>
                <button type="submit" class="btn">Subscribe</button>
            </form>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FASHION TRENDS</h3>
                    <p>Discover the latest fashion trends and get inspired by our collection of stylish clothing and accessories.</p>
                    <div class="footer-social">
                        <a href="#" class="social-icon">f</a>
                        <a href="#" class="social-icon">t</a>
                        <a href="#" class="social-icon">in</a>
                        <a href="#" class="social-icon">p</a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Shopping</h3>
                    <ul class="footer-links">
                        <li><a href="men.php">Men's Clothing</a></li>
                        <li><a href="women.php">Women's Clothing</a></li>
                        <li><a href="kids.php">Kid's Clothing</a></li>
                        <li><a href="accessories.php">Accessories</a></li>
                        <li><a href="shop.php">New Arrivals</a></li>
                        <li><a href="sale.php">Sale</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Information</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact</h3>
                    <ul class="footer-links">
                        <li>123 Fashion Street, New York, NY 10001</li>
                        <li>Email: info@fashiontrends.com</li>
                        <li>Phone: +1 (123) 456-7890</li>
                        <li>Hours: Mon-Fri 9am-6pm</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 FASHION TRENDS. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- JavaScript -->
    <script src="script.js"></script>
    <script>
        // Toggle between login and register forms
        function toggleForms() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }
        
        // Select role (buyer or seller)
        function selectRole(role) {
            // Update radio buttons
            document.querySelector('input[value="buyer"]').checked = (role === 'buyer');
            document.querySelector('input[value="seller"]').checked = (role === 'seller');
            
            // Update active class
            document.querySelectorAll('.role-option').forEach(option => {
                option.classList.remove('active');
            });
            
            document.querySelector(`input[value="${role}"]`).parentNode.classList.add('active');
            
            // Show/hide seller fields
            const sellerFields = document.querySelector('.seller-fields');
            sellerFields.style.display = (role === 'seller') ? 'block' : 'none';
            
            // Update required attribute for seller fields
            const storeNameInput = document.getElementById('storeName');
            storeNameInput.required = (role === 'seller');
        }
        
        // Toggle search bar
        function toggleSearchBar() {
            const searchBar = document.querySelector('.search-bar');
            searchBar.classList.toggle('active');
            
            if (searchBar.classList.contains('active')) {
                document.getElementById('search-input').focus();
            }
        }
    </script>
</body>
</html>
