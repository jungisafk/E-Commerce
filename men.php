<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Collection | FASHION TRENDS</title>
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
                <a href="men.php" class="active">Men</a>
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
    
    <!-- Men's Collection Banner -->
    <div class="category-banner">
        <div class="container">
            <h1>Men's Collection</h1>
            <p>Discover our latest men's fashion for every occasion</p>
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
                        <option>Customer Rating</option>
                        <option>New Arrivals</option>
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
                                <label for="category-all">All Men's Clothing</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-shirts">
                                <label for="category-shirts">Shirts</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-pants">
                                <label for="category-pants">Pants & Jeans</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-jackets">
                                <label for="category-jackets">Jackets & Coats</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="category-activewear">
                                <label for="category-activewear">Activewear</label>
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
                        <h3>Color</h3>
                        <div class="color-options">
                            <div class="color-option color-black" title="Black"></div>
                            <div class="color-option color-white" title="White"></div>
                            <div class="color-option color-red" title="Red"></div>
                            <div class="color-option color-blue" title="Blue"></div>
                            <div class="color-option color-green" title="Green"></div>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Size</h3>
                        <div class="filter-options">
                            <div class="filter-option">
                                <input type="checkbox" id="size-xs">
                                <label for="size-xs">XS</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="size-s">
                                <label for="size-s">S</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="size-m">
                                <label for="size-m">M</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="size-l">
                                <label for="size-l">L</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="size-xl">
                                <label for="size-xl">XL</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" id="size-xxl">
                                <label for="size-xxl">XXL</label>
                            </div>
                        </div>
                    </div>
                    
                    <button class="btn">Apply Filters</button>
                </div>
            </div>
        </div>
        
        <div class="shop-products grid-view" id="men-products">
            <!-- Men's Products -->
            <div class="product" onclick="window.location.href='product-details.php?id=1'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Casual Cotton T-Shirt">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Casual Cotton T-Shirt</h3>
                    <div class="product-price">
                        <div class="current-price">$29.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=3'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Classic Denim Jacket">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Classic Denim Jacket</h3>
                    <div class="product-price">
                        <div class="current-price">$79.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=6'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Slim Fit Jeans">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Slim Fit Jeans</h3>
                    <div class="product-price">
                        <div class="current-price">$69.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=10'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Men's Formal Shirt">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Men's Formal Shirt</h3>
                    <div class="product-price">
                        <div class="current-price">$54.99</div>
                    </div>
                    <div class="product-rating">★★★★★</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=13'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Men's Casual Hoodie">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Men's Casual Hoodie</h3>
                    <div class="product-price">
                        <div class="current-price">$49.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
                    <div class="product-actions">
                        <button class="btn add-to-cart">Add to Cart</button>
                        <div class="wishlist">❤️</div>
                    </div>
                </div>
            </div>
            
            <div class="product" onclick="window.location.href='product-details.php?id=14'">
                <div class="product-image">
                    <img src="/placeholder.svg?height=300&width=250" alt="Men's Cargo Pants">
                </div>
                <div class="product-info">
                    <h3 class="product-name">Men's Cargo Pants</h3>
                    <div class="product-price">
                        <div class="current-price">$59.99</div>
                    </div>
                    <div class="product-rating">★★★★☆</div>
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
</body>
</html>
