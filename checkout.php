<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | FASHION TRENDS</title>
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
                <a href="men.php">Men</a>
                <a href="women.php">Women</a>
                <a href="kids.php">Kids</a>
                <a href="accessories.php">Accessories</a>
                <a href="sale.php">Sale</a>
            </nav>
            
            <div class="header-icons">
                <div class="icon">🔍</div>
                <div class="icon" onclick="window.location.href='account.php'">👤</div>
                <div class="icon">💖</div>
                <div class="icon" onclick="window.location.href='cart.php'">
                    🛒
                    <span class="cart-count">3</span>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Checkout Page -->
    <div class="container checkout-container">
        <div class="checkout-form">
            <h2 class="form-title">Billing Details</h2>
            
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name *</label>
                        <input type="text" id="firstName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name *</label>
                        <input type="text" id="lastName" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="company" class="form-label">Company Name (Optional)</label>
                    <input type="text" id="company" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="country" class="form-label">Country / Region *</label>
                    <select id="country" class="form-control" required>
                        <option value="">Select a country</option>
                        <option value="US">United States</option>
                        <option value="CA">Canada</option>
                        <option value="UK">United Kingdom</option>
                        <option value="AU">Australia</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address" class="form-label">Street Address *</label>
                    <input type="text" id="address" class="form-control" placeholder="House number and street name" required>
                </div>
                
                <div class="form-group">
                    <input type="text" id="address2" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                </div>
                
                <div class="form-group">
                    <label for="city" class="form-label">Town / City *</label>
                    <input type="text" id="city" class="form-control" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="state" class="form-label">State *</label>
                        <select id="state" class="form-control" required>
                            <option value="">Select a state</option>
                            <option value="NY">New York</option>
                            <option value="CA">California</option>
                            <option value="TX">Texas</option>
                            <option value="FL">Florida</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="zip" class="form-label">ZIP Code *</label>
                        <input type="text" id="zip" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="tel" id="phone" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="createAccount" class="form-check-input">
                        <label for="createAccount">Create an account?</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="notes" class="form-label">Order Notes (Optional)</label>
                    <textarea id="notes" class="form-control" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                </div>
            </form>
            
            <h2 class="form-title" style="margin-top: 40px;">Payment Method</h2>
            
            <div class="payment-methods">
                <div class="payment-method active">
                    <input type="radio" name="payment" id="creditCard" class="payment-radio" checked>
                    <label for="creditCard">Credit Card</label>
                    <div class="payment-logo">
                        <img src="/placeholder.svg?height=24&width=36" alt="Visa">
                        <img src="/placeholder.svg?height=24&width=36" alt="MasterCard">
                        <img src="/placeholder.svg?height=24&width=36" alt="American Express">
                    </div>
                </div>
                
                <div class="payment-method">
                    <input type="radio" name="payment" id="paypal" class="payment-radio">
                    <label for="paypal">PayPal</label>
                    <div class="payment-logo">
                        <img src="/placeholder.svg?height=24&width=36" alt="PayPal">
                    </div>
                </div>
                
                <div class="payment-method">
                    <input type="radio" name="payment" id="bankTransfer" class="payment-radio">
                    <label for="bankTransfer">Direct Bank Transfer</label>
                </div>
            </div>
        </div>
        
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>
            
            <div class="order-items">
                <div class="order-item">
                    <div class="order-item-name">
                        <div class="item-quantity-badge">1</div>
                        <div>Floral Summer Dress</div>
                    </div>
                    <div class="order-item-price">$49.99</div>
                </div>
                
                <div class="order-item">
                    <div class="order-item-name">
                        <div class="item-quantity-badge">1</div>
                        <div>Casual Cotton T-Shirt</div>
                    </div>
                    <div class="order-item-price">$29.99</div>
                </div>
                
                <div class="order-item">
                    <div class="order-item-name">
                        <div class="item-quantity-badge">1</div>
                        <div>Summer Straw Hat</div>
                    </div>
                    <div class="order-item-price">$24.99</div>
                </div>
            </div>
            
            <div class="summary-row">
                <div class="summary-label">Subtotal</div>
                <div class="summary-value">$104.97</div>
            </div>
            
            <div class="summary-row">
                <div class="summary-label">Shipping</div>
                <div class="summary-value">Free</div>
            </div>
            
            <div class="summary-row">
                <div class="summary-label">Tax</div>
                <div class="summary-value">$8.40</div>
            </div>
            
            <div class="summary-row summary-total">
                <div class="summary-label">Total</div>
                <div class="summary-value">$113.37</div>
            </div>
            
            <button class="btn place-order-btn">Place Order</button>
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
                        <li><a href="kid.php">Kid's Clothing</a></li>
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
</body>
</html>