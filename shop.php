<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | FASHION TRENDS</title>
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
                <a href="sale.php">Sale</a>
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
    
    <!-- Shop Header -->
    <section class="shop-header">
        <div class="container">
            <h1 class="shop-title">Shop</h1>
            <div class="breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <span>Shop</span>
            </div>
        </div>
    </section>
    
    <!-- Shop Content -->
    <div class="container shop-container">
        <!-- Filters Sidebar -->
        <div class="filters">
            <div class="filter-group">
                <h3 class="filter-title">Categories</h3>
                <div class="filter-options">
                    <label>
                        <input type="checkbox" checked> All Clothing
                    </label>
                    <label>
                        <input type="checkbox"> T-Shirts
                    </label>
                    <label>
                        <input type="checkbox"> Shirts
                    </label>
                    <label>
                        <input type="checkbox"> Jeans
                    </label>
                    <label>
                        <input type="checkbox"> Jackets
                    </label>
                    <label>
                        <input type="checkbox"> Dresses
                    </label>
                    <label>
                        <input type="checkbox"> Shoes
                    </label>
                </div>
            </div>
            
            <div class="filter-group">
                <h3 class="filter-title">Price Range</h3>
                <div class="filter-options">
                    <label>
                        <input type="checkbox" checked> All Prices
                    </label>
                    <label>
                        <input type="checkbox"> $0 - $50
                    </label>
                    <label>
                        <input type="checkbox"> $50 - $100
                    </label>
                    <label>
                        <input type="checkbox"> $100 - $200
                    </label>
                    <label>
                        <input type="checkbox"> $200+
                    </label>
                </div>
                
                <div class="price-range">
                    <input type="text" placeholder="Min" class="price-input">
                    <input type="text" placeholder="Max" class="price-input">
                </div>
            </div>
            
            <div class="filter-group">
                <h3 class="filter-title">Colors</h3>
                <div class="filter-colors">
                    <div class="color-option color-black active"></div>
                    <div class="color-option color-white"></div>
                    <div class="color-option color-red"></div>
                    <div class="color-option color-blue"></div>
                    <div class="color-option color-green"></div>
                </div>
            </div>
            
            <div class="filter-group">
                <h3 class="filter-title">Size</h3>
                <div class="filter-options">
                    <label>
                        <input type="checkbox"> XS
                    </label>
                    <label>
                        <input type="checkbox" checked> S
                    </label>
                    <label>
                        <input type="checkbox" checked> M
                    </label>
                    <label>
                        <input type="checkbox" checked> L
                    </label>
                    <label>
                        <input type="checkbox"> XL
                    </label>
                    <label>
                        <input type="checkbox"> XXL
                    </label>
                </div>
            </div>
            
            <div class="filter-group">
                <h3 class="filter-title">Brand</h3>
                <div class="filter-options">
                    <label>
                        <input type="checkbox" checked> All Brands
                    </label>
                    <label>
                        <input type="checkbox"> Nike
                    </label>
                    <label>
                        <input type="checkbox"> Adidas
                    </label>
                    <label>
                        <input type="checkbox"> Puma
                    </label>
                    <label>
                        <input type="checkbox"> Zara
                    </label>
                    <label>
                        <input type="checkbox"> H&M
                    </label>
                </div>
            </div>
            
            <button class="btn">Apply Filters</button>
        </div>
        
        <!-- Products Grid -->
        <div class="shop-products-container">
            <div class="shop-header-actions">
                <div class="products-count">Showing 1-12 of 36 products</div>
                
                <div class="sort-options">
                    <span>Sort by:</span>
                    <select class="sort-select">
                        <option>Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Customer Rating</option>
                        <option>New Arrivals</option>
                    </select>
                    
                    <div class="view-options">
                        <div class="view-option active">☰</div>
                        <div class="view-option">▦</div>
                    </div>
                </div>
            </div>
            
            <div class="shop-products">
                <div class="product" onclick="window.location.href='product-details.php?id=1'">
                    <div class="product-image">
                        <img src="/placeholder.svg?height=300&width=250" alt="Casual T-Shirt">
                        <div class="product-tag">New</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Casual Cotton T-Shirt</h3>
                        <div class="product-price">
                            <div class="current-price">$29.99</div>
                            <div class="old-price">$39.99</div>
                        </div>
                        <div class="product-rating">★★★★☆</div>
                        <div class="product-actions">
                            <button class="btn add-to-cart">Add to Cart</button>
                            <div class="wishlist">❤️</div>
                        </div>
                    </div>
                </div>
                
                <div class="product" onclick="window.location.href='product-details.php?id=2'">
                    <div class="product-image">
                        <img src="/placeholder.svg?height=300&width=250" alt="Summer Dress">
                        <div class="product-tag">Hot</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Floral Summer Dress</h3>
                        <div class="product-price">
                            <div class="current-price">$49.99</div>
                            <div class="old-price">$69.99</div>
                        </div>
                        <div class="product-rating">★★★★★</div>
                        <div class="product-actions">
                            <button class="btn add-to-cart">Add to Cart</button>
                            <div class="wishlist">❤️</div>
                        </div>
                    </div>
                </div>
                
                <div class="product" onclick="window.location.href='product-details.php?id=3'">
                    <div class="product-image">
                        <img src="/placeholder.svg?height=300&width=250" alt="Denim Jacket">
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
                
                <div class="product" onclick="window.location.href='product-details.php?id=4'">
                    <div class="product-image">
                        <img src="/placeholder.svg?height=300&width=250" alt="Sneakers">
                        <div class="product-tag">Sale</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Casual Sneakers</h3>
                        <div class="product-price">
                            <div class="current-price">$59.99</div>
                            <div class="old-price">$89.99</div>
                        </div>
                        <div class="product-rating">★★★★★</div>
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
                            <div class="current-price">$45.99</div>
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
                        <img src="/placeholder.svg?height=300&width=250" alt="Formal Shirt">
                        <div class="product-tag">New</div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Formal Cotton Shirt</h3>
                        <div class="product-price">
                            <div class="current-price">$39.99</div>
                            <div class="old-price">$49.99</div>
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
                        <img src="/placeholder.svg?height=300&width=250" alt="Leather Jacket">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Leather Biker Jacket</h3>
                        <div class="product-price">
                            <div class="current-price">$129.99</div>
                            <div class="old-price">$159.99</div>
                        </div>
                        <div class="product-rating">★★★★★</div>
                        <div class="product-actions">
                            <button class="btn add-to-cart">Add to Cart</button>
                            <div class="wishlist">❤️</div>
                        </div>
                    </div>
                </div>
                
                <div class="product" onclick="window.location.href='product-details.php?id=5'">
                    <div class="product-image">
                        <img src="/placeholder.svg?height=300&width=250" alt="Summer Hat">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">Summer Straw Hat</h3>
                        <div class="product-price">
                            <div class="current-price">$24.99</div>
                        </div>
                        <div class="product-rating">★★★★☆</div>
                        <div class="product-actions">
                            <button class="btn add-to-cart">Add to Cart</button>
                            <div class="wishlist">❤️</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pagination">
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item">→</div>
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
