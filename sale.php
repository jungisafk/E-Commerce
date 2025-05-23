<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
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
                <a href="sale.php" class="active">Sale</a>
            </nav>
            
            <div class="header-icons">
                <div class="icon search-icon" onclick="toggleSearchBar()">🔍</div>
                <div class="icon" onclick="window.location.href='account.php'">👤</div>
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
    
    <!-- Sale Banner -->
    <div class="category-banner sale-banner">
        <div class="container">
            <h1>SALE</h1>
            <p>Up to 70% off on selected items</p>
            <div class="countdown-timer">
                <div class="countdown-item">
                    <div class="countdown-number" id="days">03</div>
                    <div class="countdown-label">Days</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="hours">12</div>
                    <div class="countdown-label">Hours</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="minutes">45</div>
                    <div class="countdown-label">Minutes</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="seconds">30</div>
                    <div class="countdown-label">Seconds</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Shop Content -->
    <div class="container">
        <div class="shop-filters-container">
            <div class="shop-filters-header">
                <div class="filter-toggle">
                    <span>Filters</span>
                    <span class="toggle-icon">+</span>
                </div>
                
                <div class="sort-options">
                    <label for="sort-select">Sort by:</label>
                    <select class="sort-select" id="sort-select">
                        <option>Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Discount: High to Low</option>
                        <option>Customer Rating</option>
                    </select>
                </div>
                
                <div class="view-options">
                    <div class="view-option active">⊞</div>
                    <div class="view-option">☰</div>
                </div>
            </div>
            
            <div class="filters-container">
                <div class="filters">
                    <div class="filter-group">
                        <h3>Category</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="category-all" checked>
                                <label for="category-all">All Sale Items</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-men">
                                <label for="category-men">Men</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-women">
                                <label for="category-women">Women</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-kids">
                                <label for="category-kids">Kids</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-accessories">
                                <label for="category-accessories">Accessories</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Price</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="price-all" checked>
                                <label for="price-all">All Prices</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="price-0-50">
                                <label for="price-0-50">$0 - $50</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="price-50-100">
                                <label for="price-50-100">$50 - $100</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="price-100-200">
                                <label for="price-100-200">$100 - $200</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="price-200-plus">
                                <label for="price-200-plus">$200+</label>
                            </div>
                        </div>
                        
                        <div class="price-range">
                            <input type="number" placeholder="Min" min="0">
                            <span>-</span>
                            <input type="number" placeholder="Max">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Discount</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="discount-10">
                                <label for="discount-10">10% Off or More</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="discount-20">
                                <label for="discount-20">20% Off or More</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="discount-30">
                                <label for="discount-30">30% Off or More</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="discount-50">
                                <label for="discount-50">50% Off or More</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="discount-70">
                                <label for="discount-70">70% Off or More</label>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn">Apply Filters</button>
                </div>
            </div>
        </div>
        
        <div class="shop-products grid-view" id="sale-products">
            <!-- Sale Products -->
            <div class="product" onclick="window.location.href='product-details.php?id=25'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Men's Polo Shirt">
                    <div class="discount-badge">-30%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Men's Polo Shirt</h3>
                    <div class="product-price">
                        <div class="original-price">$39.99</div>
                        <div class="current-price">$27.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=26'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Women's Cardigan">
                    <div class="discount-badge">-40%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Women's Knit Cardigan</h3>
                    <div class="product-price">
                        <div class="original-price">$64.99</div>
                        <div class="current-price">$38.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=27'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Kids Sneakers">
                    <div class="discount-badge">-25%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Kids Colorful Sneakers</h3>
                    <div class="product-price">
                        <div class="original-price">$39.99</div>
                        <div class="current-price">$29.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=28'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Leather Wallet">
                    <div class="discount-badge">-50%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Leather Wallet</h3>
                    <div class="product-price">
                        <div class="original-price">$49.99</div>
                        <div class="current-price">$24.99</div>
                    </div>
                    <div class="product-rating">★★★★★</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=29'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Men's Sweater">
                    <div class="discount-badge">-60%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Men's Wool Sweater</h3>
                    <div class="product-price">
                        <div class="original-price">$89.99</div>
                        <div class="current-price">$35.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=30'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Women's Dress">
                    <div class="discount-badge">-70%</div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">Women's Evening Dress</h3>
                    <div class="product-price">
                        <div class="original-price">$129.99</div>
                        <div class="current-price">$38.99</div>
                    </div>
                    <div class="product-rating">★★★★★</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
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
    <script>
        // Countdown timer for sale
        function updateCountdown() {
            const now = new Date();
            const endDate = new Date();
            endDate.setDate(now.getDate() + 3); // Sale ends in 3 days
            endDate.setHours(23, 59, 59); // End of day
            
            const diff = endDate - now;
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }
        
        // Update countdown every second
        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
</body>
</html>
