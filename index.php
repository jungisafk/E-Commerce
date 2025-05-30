<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION TRENDS | Modern Clothes Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Summer Collection 2024</h1>
            <p>Discover the latest trends in fashion and explore our new collection of clothing that define the season.</p>
            <div class="hero-buttons">
                <a href="shop.php" class="btn">Shop Now</a>
                <a href="#" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section class="section categories">
        <div class="container">
            <h2 class="section-title">Browse Categories</h2>
            <p class="section-subtitle">Find exactly what you're looking for by shopping our curated collections</p>
            
            <div class="categories-grid">
                <div class="category" onclick="window.location.href='men.php'">
                    <img src="/placeholder.svg?height=250&width=300" alt="Men's Fashion">
                    <div class="category-name">Men</div>
                </div>
                <div class="category" onclick="window.location.href='women.php'">
                    <img src="/placeholder.svg?height=250&width=300" alt="Women's Fashion">
                    <div class="category-name">Women</div>
                </div>
                <div class="category" onclick="window.location.href='kids.php'">
                    <img src="/placeholder.svg?height=250&width=300" alt="Kid's Fashion">
                    <div class="category-name">Kids</div>
                </div>
                <div class="category" onclick="window.location.href='accessories.php'">
                    <img src="/placeholder.svg?height=250&width=300" alt="Accessories">
                    <div class="category-name">Accessories</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Products -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Shop our most popular and trending items</p>
            
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
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="shop.php" class="btn">View All Products</a>
            </div>
        </div>
    </section>
    
    <!-- Benefits Section -->
    <section class="section benefits">
        <div class="container">
            <h2 class="section-title">Why Shop With Us</h2>
            
            <div class="benefits-grid">
                <div class="benefit">
                    <div class="benefit-icon">🚚</div>
                    <h3 class="benefit-title">Free Shipping</h3>
                    <p class="benefit-description">Free shipping on all orders over $50</p>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">⟲</div>
                    <h3 class="benefit-title">Easy Returns</h3>
                    <p class="benefit-description">30 days return policy for all items</p>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">🔒</div>
                    <h3 class="benefit-title">Secure Payment</h3>
                    <p class="benefit-description">All transactions are safe and secure</p>
                </div>
                
                <div class="benefit">
                    <div class="benefit-icon">💬</div>
                    <h3 class="benefit-title">24/7 Support</h3>
                    <p class="benefit-description">Customer support available 24/7</p>
                </div>
            </div>
        </div>
    </section>
    
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
