<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="product-details.css">
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
    
    <!-- Breadcrumb -->
    <div class="container" style="margin-top: 30px;">
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <a href="shop.php">Shop</a>
            <span>/</span>
            <a href="women.php">Women</a>
            <span>/</span>
            <span>Floral Summer Dress</span>
        </div>
    </div>
    
    <!-- Product Details -->
    <div class="container">
        <div class="product-details">
            <div class="product-details-container">
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="/placeholder.svg?height=400&width=400" alt="Floral Summer Dress">
                    </div>
                    <div class="thumbnail-images">
                        <div class="thumbnail active">
                            <img src="/placeholder.svg?height=80&width=80" alt="Floral Summer Dress - Front">
                        </div>
                        <div class="thumbnail">
                            <img src="/placeholder.svg?height=80&width=80" alt="Floral Summer Dress - Side">
                        </div>
                        <div class="thumbnail">
                            <img src="/placeholder.svg?height=80&width=80" alt="Floral Summer Dress - Back">
                        </div>
                        <div class="thumbnail">
                            <img src="/placeholder.svg?height=80&width=80" alt="Floral Summer Dress - Detail">
                        </div>
                    </div>
                </div>
                
                <div class="product-info-details">
                    <div class="product-category">Women / Dresses</div>
                    <h1 class="product-title">Floral Summer Dress</h1>
                    
                    <div class="product-rating-details">
                        <div class="rating-stars">★★★★★</div>
                        <div class="rating-count">(24 reviews)</div>
                    </div>
                    
                    <div class="product-price-details">
                        <div class="current-price-details">$49.99</div>
                        <div class="old-price-details">$69.99</div>
                        <div class="discount-badge">-28%</div>
                    </div>
                    
                    <div class="product-description">
                        <p>A beautiful floral summer dress perfect for warm days and special occasions. Made from lightweight, breathable fabric with a flattering fit and elegant design. The vibrant floral pattern adds a touch of femininity and style.</p>
                    </div>
                    
                    <div class="product-meta">
                        <div class="meta-item">
                            <div class="meta-label">SKU:</div>
                            <div class="meta-value">FSD-2024-001</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Availability:</div>
                            <div class="meta-value">In Stock (12 items)</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Material:</div>
                            <div class="meta-value">95% Cotton, 5% Elastane</div>
                        </div>
                    </div>
                    
                    <div class="product-variations">
                        <div class="variation-title">Color:</div>
                        <div class="color-variations">
                            <div class="color-variation" style="background-color: #f8b5c1;" title="Pink"></div>
                            <div class="color-variation active" style="background-color: #b5d8f8;" title="Blue"></div>
                            <div class="color-variation" style="background-color: #f8e5b5;" title="Yellow"></div>
                        </div>
                        
                        <div class="variation-title">Size:</div>
                        <div class="size-variations">
                            <div class="size-variation">XS</div>
                            <div class="size-variation">S</div>
                            <div class="size-variation active">M</div>
                            <div class="size-variation">L</div>
                            <div class="size-variation">XL</div>
                        </div>
                    </div>
                    
                    <div class="quantity-selector">
                        <div class="quantity-btn">-</div>
                        <input type="number" value="1" min="1" class="quantity-input">
                        <div class="quantity-btn">+</div>
                    </div>
                    
                    <div class="product-actions-details">
                        <button class="btn add-to-cart-details">Add to Cart</button>
                        <div class="wishlist-details">❤️</div>
                        <div class="compare-details">⇄</div>
                    </div>
                    
                    <div class="product-share">
                        <div class="share-label">Share:</div>
                        <div class="share-icons">
                            <a href="#" class="share-icon">f</a>
                            <a href="#" class="share-icon">t</a>
                            <a href="#" class="share-icon">p</a>
                            <a href="#" class="share-icon">in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product-tabs">
            <div class="tabs-header">
                <div class="tab-item active">Description</div>
                <div class="tab-item">Additional Information</div>
                <div class="tab-item">Reviews (24)</div>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane active">
                    <h3>Product Description</h3>
                    <p>This beautiful floral summer dress is designed to keep you cool and stylish during warm weather. The lightweight fabric allows for breathability while the elegant cut ensures a flattering fit for all body types.</p>
                    
                    <p>Features:</p>
                    <ul style="list-style-type: disc; margin-left: 20px;">
                        <li>Lightweight and breathable fabric</li>
                        <li>Vibrant floral pattern</li>
                        <li>Adjustable waist tie</li>
                        <li>V-neckline</li>
                        <li>Mid-length design</li>
                        <li>Machine washable</li>
                    </ul>
                    
                    <p>Perfect for summer parties, beach outings, or casual day wear. Pair with sandals for a casual look or dress it up with heels for special occasions.</p>
                </div>
                
                <div class="tab-pane">
                    <h3>Additional Information</h3>
                    <table class="product-attributes">
                        <tr>
                            <th>Weight</th>
                            <td>0.3 kg</td>
                        </tr>
                        <tr>
                            <th>Dimensions</th>
                            <td>30 × 40 × 2 cm</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>Pink, Blue, Yellow</td>
                        </tr>
                        <tr>
                            <th>Size</th>
                            <td>XS, S, M, L, XL</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>95% Cotton, 5% Elastane</td>
                        </tr>
                        <tr>
                            <th>Care Instructions</th>
                            <td>Machine wash cold, gentle cycle. Do not bleach. Tumble dry low.</td>
                        </tr>
                    </table>
                </div>
                
                <div class="tab-pane">
                    <h3>Customer Reviews (24)</h3>
                    <div class="review-summary">
                        <div class="average-rating">
                            <div class="rating-number">4.8</div>
                            <div class="rating-stars">★★★★★</div>
                            <div class="rating-count">Based on 24 reviews</div>
                        </div>
                        <div class="rating-bars">
                            <div class="rating-bar">
                                <div class="rating-label">5 Stars</div>
                                <div class="rating-progress">
                                    <div class="rating-progress-fill" style="width: 80%;"></div>
                                </div>
                                <div class="rating-percent">80%</div>
                            </div>
                            <div class="rating-bar">
                                <div class="rating-label">4 Stars</div>
                                <div class="rating-progress">
                                    <div class="rating-progress-fill" style="width: 15%;"></div>
                                </div>
                                <div class="rating-percent">15%</div>
                            </div>
                            <div class="rating-bar">
                                <div class="rating-label">3 Stars</div>
                                <div class="rating-progress">
                                    <div class="rating-progress-fill" style="width: 5%;"></div>
                                </div>
                                <div class="rating-percent">5%</div>
                            </div>
                            <div class="rating-bar">
                                <div class="rating-label">2 Stars</div>
                                <div class="rating-progress">
                                    <div class="rating-progress-fill" style="width: 0%;"></div>
                                </div>
                                <div class="rating-percent">0%</div>
                            </div>
                            <div class="rating-bar">
                                <div class="rating-label">1 Star</div>
                                <div class="rating-progress">
                                    <div class="rating-progress-fill" style="width: 0%;"></div>
                                </div>
                                <div class="rating-percent">0%</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="reviews-list">
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-name">Sarah Johnson</div>
                                <div class="review-date">June 15, 2024</div>
                            </div>
                            <div class="review-rating">★★★★★</div>
                            <div class="review-content">
                                <p>This dress is absolutely perfect! The fabric is lightweight and comfortable, perfect for hot summer days. The floral pattern is beautiful and the colors are vibrant. I've received so many compliments when wearing it. Highly recommend!</p>
                            </div>
                        </div>
                        
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-name">Emily Davis</div>
                                <div class="review-date">June 10, 2024</div>
                            </div>
                            <div class="review-rating">★★★★★</div>
                            <div class="review-content">
                                <p>Love this dress! The fit is true to size and very flattering. The material is good quality and doesn't wrinkle easily. Perfect for vacation or summer events.</p>
                            </div>
                        </div>
                        
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-name">Jessica Williams</div>
                                <div class="review-date">May 28, 2024</div>
                            </div>
                            <div class="review-rating">★★★★☆</div>
                            <div class="review-content">
                                <p>Beautiful dress with a lovely pattern. The only reason I'm giving 4 stars instead of 5 is that it runs slightly large. I would recommend sizing down if you're between sizes. Otherwise, great purchase!</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="write-review">
                        <h4>Write a Review</h4>
                        <form class="review-form">
                            <div class="form-group">
                                <label>Your Rating</label>
                                <div class="rating-select">
                                    <span>☆</span>
                                    <span>☆</span>
                                    <span>☆</span>
                                    <span>☆</span>
                                    <span>☆</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Your Review</label>
                                <textarea placeholder="Write your review here..."></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" placeholder="Your name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" placeholder="Your email">
                                </div>
                            </div>
                            <button type="submit" class="btn">Submit Review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="related-products">
            <h2 class="section-title">You May Also Like</h2>
            
            <div class="products-grid">
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
    <script src="product-details.js"></script>
</body>
</html>
