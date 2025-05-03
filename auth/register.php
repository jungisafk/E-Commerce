<?php
session_start();
require_once '../config/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Additional fields for sellers
    $store_name = isset($_POST['store_name']) ? trim($_POST['store_name']) : '';
    $store_description = isset($_POST['store_description']) ? trim($_POST['store_description']) : '';
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Please enter your name";
    }
    
    if (empty($email)) {
        $errors[] = "Please enter your email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }
    
    if (empty($password)) {
        $errors[] = "Please enter a password";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    if ($role === 'seller') {
        if (empty($store_name)) {
            $errors[] = "Please enter your store name";
        }
    }
    
    // Check if email already exists
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $errors[] = "Email already exists. Please use a different email or login.";
        }
    } catch(PDOException $e) {
        $errors[] = "Error: " . $e->getMessage();
    }
    
    // If no errors, proceed with registration
    if (empty($errors)) {
        try {
            // Start transaction
            $pdo->beginTransaction();
            
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare an insert statement for users table
            $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            
            // Execute the statement
            $stmt->execute();
            
            // Get the last inserted ID (user_id)
            $user_id = $pdo->lastInsertId();
            
            // If role is seller, insert into seller_profiles table
            if ($role === 'seller') {
                $sql = "INSERT INTO seller_profiles (user_id, store_name, description) VALUES (:user_id, :store_name, :description)";
                $stmt = $pdo->prepare($sql);
                
                // Bind parameters
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':store_name', $store_name, PDO::PARAM_STR);
                $stmt->bindParam(':description', $store_description, PDO::PARAM_STR);
                
                // Execute the statement
                $stmt->execute();
            }
            
            // Commit the transaction
            $pdo->commit();
            
            // Registration successful, set session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user_id;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;
            
            // Redirect user based on role
            if ($role === 'seller') {
                header("location: ../seller-dashboard.php");
            } else {
                header("location: ../index.php");
            }
            exit;
            
        } catch(PDOException $e) {
            // Roll back the transaction if something failed
            $pdo->rollBack();
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | FASHION TRENDS</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../account-styles.css">
</head>
<body>
    <!-- Header -->
    <?php include '../includes/header.php'; ?>
    
    <!-- Register Container -->
    <div class="container">
        <div class="auth-container">
            <div class="auth-tabs">
                <div class="auth-tab" onclick="window.location.href='login.php'">Login</div>
                <div class="auth-tab active">Register</div>
            </div>
            
            <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form class="auth-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="role-selector">
                    <div class="role-option <?php echo (!isset($_POST['role']) || $_POST['role'] === 'buyer') ? 'active' : ''; ?>" onclick="selectRole('buyer')">
                        <div class="role-icon">🛒</div>
                        <div class="role-title">Buyer</div>
                        <div class="role-description">Shop and browse products</div>
                        <input type="radio" name="role" value="buyer" <?php echo (!isset($_POST['role']) || $_POST['role'] === 'buyer') ? 'checked' : ''; ?> style="display: none;">
                    </div>
                    
                    <div class="role-option <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'active' : ''; ?>" onclick="selectRole('seller')">
                        <div class="role-icon">💼</div>
                        <div class="role-title">Seller</div>
                        <div class="role-description">Sell your products</div>
                        <input type="radio" name="role" value="seller" <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'checked' : ''; ?> style="display: none;">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                
                <div class="seller-fields" style="display: <?php echo (isset($_POST['role']) && $_POST['role'] === 'seller') ? 'block' : 'none'; ?>;">
                    <div class="form-group">
                        <label for="store_name">Store Name</label>
                        <input type="text" id="store_name" name="store_name" placeholder="Enter your store name" value="<?php echo isset($_POST['store_name']) ? htmlspecialchars($_POST['store_name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="store_description">Store Description</label>
                        <textarea id="store_description" name="store_description" placeholder="Describe your store and what you sell"><?php echo isset($_POST['store_description']) ? htmlspecialchars($_POST['store_description']) : ''; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
                    </div>
                </div>
                
                <button type="submit" class="auth-btn">Create Account</button>
            </form>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../script.js"></script>
    <script>
        function selectRole(role) {
            // Update radio buttons
            document.querySelector('input[value="buyer"]').checked = (role === 'buyer');
            document.querySelector('input[value="seller"]').checked = (role === 'seller');
            
            // Update active class
            document.querySelectorAll('.role-option').forEach(option => {
                option.classList.remove('active');
            });
            
            document.querySelector(`.role-option input[value="${role}"]`).parentNode.classList.add('active');
            
            // Show/hide seller fields
            const sellerFields = document.querySelector('.seller-fields');
            sellerFields.style.display = (role === 'seller') ? 'block' : 'none';
            
            // Update required attribute for seller fields
            const storeNameInput = document.getElementById('store_name');
            storeNameInput.required = (role === 'seller');
        }
    </script>
</body>
</html>
