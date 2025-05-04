<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="account-styles.css">
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
                <div class="icon" onclick="window.location.href='login.php'">👤</div>
                <div class="icon">💖</div>
                <div class="icon" onclick="window.location.href='cart.php'">
                    🛒
                    <span class="cart-count">3</span>
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
    
    <!-- Login Container -->
    <div class="container">
        <div class="auth-container">
            <div class="auth-tabs">
                <div class="auth-tab active" onclick="switchTab('login')">Login</div>
                <div class="auth-tab" onclick="switchTab('register')">Register</div>
            </div>
            
            <div id="login-form" class="auth-form">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" placeholder="Enter your password">
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember-me">
                        <label for="remember-me">Remember me</label>
                    </div>
                </div>
                
                <button class="auth-btn" onclick="login()">Login</button>
                
                <div class="auth-footer">
                    <a href="#">Forgot your password?</a>
                </div>
            </div>
            
            <div id="register-form" class="auth-form" style="display: none;">
                <div class="role-selector">
                    <div class="role-option active" onclick="selectRole('buyer')">
                        <div class="role-icon">🛒</div>
                        <div class="role-title">Buyer</div>
                        <div class="role-description">Shop and browse products</div>
                    </div>
                    
                    <div class="role-option" onclick="selectRole('seller')">
                        <div class="role-icon">💼</div>
                        <div class="role-title">Seller</div>
                        <div class="role-description">Sell your products</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" placeholder="Create a password">
                </div>
                
                <div class="form-group">
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" placeholder="Confirm your password">
                </div>
                
                <div class="form-group seller-fields" style="display: none;">
                    <label for="store-name">Store Name</label>
                    <input type="text" id="store-name" placeholder="Enter your store name">
                </div>
                
                <div class="form-group seller-fields" style="display: none;">
                    <label for="store-description">Store Description</label>
                    <textarea id="store-description" placeholder="Describe your store and what you sell"></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="terms">
                        <label for="terms">I agree to the <a href="#">Terms and Conditions</a></label>
                    </div>
                </div>
                
                <button class="auth-btn" onclick="register()">Create Account</button>
            </div>
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
    <script src="account.js"></script>
</body>
</html>
