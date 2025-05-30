<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">FASHION<span>TRENDS</span></div>
            
            <div class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">
                ☰
            </div>
            
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <a href="shop.php">Men</a>
                <a href="shop.php">Women</a>
                <a href="shop.php">Kids</a>
                <a href="shop.php">Accessories</a>
                <a href="shop.php">Sale</a>
            </nav>
            
            <div class="header-icons">
                <div class="icon">🔍</div>
                <div class="icon" onclick="window.location.href='account.php'">👤</div>
                <div class="icon">💖</div>
                <div class="icon" onclick="window.location.href='cart.php'">
                    🛒
                    <span class="cart-count">0</span>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Order Confirmation -->
    <div class="container" style="text-align: center; padding: 60px 0;">
        <div style="font-size: 72px; margin-bottom: 20px; color: #28a745;">✓</div>
        <h1 class="section-title">Order Confirmed!</h1>
        <p style="font-size: 18px; margin-bottom: 30px;">Thank you for your purchase. Your order has been received and is being processed.</p>
        
        <div style="background-color: white; border-radius: 8px; padding: 30px; max-width: 600px; margin: 0 auto; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h2 style="margin-bottom: 20px; font-size: 24px;">Order Details</h2>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                <div style="font-weight: 600;">Order Number:</div>
                <div id="orderNumber">ORD-2024-12345</div>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                <div style="font-weight: 600;">Date:</div>
                <div id="orderDate"></div>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                <div style="font-weight: 600;">Total:</div>
                <div id="orderTotal">$113.37</div>
            </div>
            
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                <div style="font-weight: 600;">Payment Method:</div>
                <div>Credit Card</div>
            </div>
            
            <div style="display: flex; justify-content: space-between;">
                <div style="font-weight: 600;">Shipping Address:</div>
                <div style="text-align: right;">
                    <div>John Doe</div>
                    <div>123 Main Street</div>
                    <div>Apt 4B</div>
                    <div>New York, NY 10001</div>
                    <div>United States</div>
                </div>
            </div>
        </div>
        
        <p style="margin: 30px 0;">A confirmation email has been sent to your email address.</p>
        
        <div style="margin-top: 30px;">
            <a href="shop.php" class="btn">Continue Shopping</a>
        </div>
    </div>
    
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
        // Set current date
        const today = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('orderDate').textContent = today.toLocaleDateString('en-US', options);
        
        // Generate random order number
        const orderNum = 'ORD-' + today.getFullYear() + '-' + Math.floor(10000 + Math.random() * 90000);
        document.getElementById('orderNumber').textContent = orderNum;
    </script>
</body>
</html>