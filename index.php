<?php
// Start the session
session_start();

// Check if user is logged in
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$user_role = $is_logged_in ? $_SESSION['role'] : '';
$user_name = $is_logged_in ? $_SESSION['name'] : '';

// Get cart count from session
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Include database connection
require_once 'config/db.php';

// Fetch featured products
try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE featured = 1 LIMIT 4");
    $stmt->execute();
    $featured_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If database error, use default products
    $featured_products = [];
}

// Page title
$page_title = "FASHION TRENDS | Modern Clothes Shop";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
    <meta name="description" content="Discover the latest fashion trends at FASHION TRENDS. Shop stylish clothing and accessories for men, women, and kids.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <?php if($is_logged_in): ?>
    <!-- Welcome Banner for Logged-in Users -->
    <div class="welcome-banner">
        <div class="container">
            <div class="welcome-content">
                <h2>Welcome back, <?php echo htmlspecialchars($user_name); ?>!</h2>
                <?php if($user_role === 'buyer'): ?>
                    <p>Continue shopping or check your recent orders.</p>
                    <div class="welcome-actions">
                        <a href="shop.php" class="btn">Continue Shopping</a>
                        <a href="buyer-dashboard.php" class="btn btn-outline">My Account</a>
                    </div>
                <?php elseif($user_role === 'seller'): ?>
                    <p>Manage your products or check your recent orders.</p>
                    <div class="welcome-actions">
                        <a href="seller-dashboard.php" class="btn">Seller Dashboard</a>
                        <a href="products/add-product.php" class="btn btn-outline">Add New Product</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Summer Collection 2024</h1>
            <p>Discover the latest trends in fashion and explore our new collection of clothing that define the season.</p>
            <div class="hero-buttons">
                <a href="shop.php" class="btn">Shop Now</a>
                <a href="about.php" class="btn btn-outline">Learn More</a>
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
    
    <?php if($is_logged_in && $user_role === 'buyer'): ?>
    <!-- Recommended for You Section (Buyers Only) -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Recommended for You</h2>
            <p class="section-subtitle">Based on your browsing history and preferences</p>
            
            <div class="products-grid">
                <?php
                // Get user's browsing history or preferences from database
                try {
                    $user_id = $_SESSION['user_id'];
                    $stmt = $pdo->prepare("
                        SELECT p.* FROM products p
                        JOIN product_views pv ON p.id = pv.product_id
                        WHERE pv.user_id = :user_id
                        ORDER BY pv.viewed_at DESC
                        LIMIT 4
                    ");
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $recommended_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // If no viewed products, get products from user's preferred categories
                    if (count($recommended_products) === 0) {
                        $stmt = $pdo->prepare("
                            SELECT p.* FROM products p
                            JOIN categories c ON p.category_id = c.id
                            JOIN user_preferences up ON c.id = up.category_id
                            WHERE up.user_id = :user_id
                            ORDER BY RAND()
                            LIMIT 4
                        ");
                        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                        $stmt->execute();
                        $recommended_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    
                    // If still no products, get random featured products
                    if (count($recommended_products) === 0) {
                        $stmt = $pdo->prepare("SELECT * FROM products WHERE featured = 1 ORDER BY RAND() LIMIT 4");
                        $stmt->execute();
                        $recommended_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    
                    // Display recommended products
                    foreach ($recommended_products as $product) {
                        echo '<div class="product" onclick="window.location.href=\'product-details.php?id=' . $product['id'] . '\'">';
                        echo '<div class="product-image">';
                        echo '<img src="' . htmlspecialchars($product['image_url']) . '" alt="' . htmlspecialchars($product['name']) . '">';
                        echo '<div class="product-tag">Recommended</div>';
                        echo '</div>';
                        echo '<div class="product-info">';
                        echo '<h3 class="product-name">' . htmlspecialchars($product['name']) . '</h3>';
                        echo '<div class="product-price">';
                        echo '<div class="current-price">$' . number_format($product['price'], 2) . '</div>';
                        if ($product['old_price'] > 0) {
                            echo '<div class="old-price">$' . number_format($product['old_price'], 2) . '</div>';
                        }
                        echo '</div>';
                        echo '<div class="product-rating">' . str_repeat('★', $product['rating']) . str_repeat('☆', 5 - $product['rating']) . '</div>';
                        echo '<div class="product-actions">';
                        echo '<button class="btn add-to-cart" onclick="addToCart(' . $product['id'] . '); event.stopPropagation();">Add to Cart</button>';
                        echo '<div class="wishlist" onclick="addToWishlist(' . $product['id'] . '); event.stopPropagation();">❤️</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    // If database error, show default message
                    echo '<p class="error-message">Personalized recommendations are currently unavailable. Please try again later.</p>';
                }
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <?php if($is_logged_in && $user_role === 'seller'): ?>
    <!-- Seller Stats Section -->
    <section class="section seller-stats">
        <div class="container">
            <h2 class="section-title">Your Store Performance</h2>
            <p class="section-subtitle">Quick overview of your store's performance</p>
            
            <div class="stats-grid">
                <?php
                // Get seller stats from database
                try {
                    $seller_id = $_SESSION['user_id'];
                    
                    // Get product views
                    $stmt = $pdo->prepare("
                        SELECT COUNT(*) as view_count 
                        FROM product_views pv
                        JOIN products p ON pv.product_id = p.id
                        WHERE p.seller_id = :seller_id
                        AND pv.viewed_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    ");
                    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $views = $stmt->fetch(PDO::FETCH_ASSOC);
                    $view_count = $views ? $views['view_count'] : 0;
                    
                    // Get order count
                    $stmt = $pdo->prepare("
                        SELECT COUNT(DISTINCT o.id) as order_count
                        FROM orders o
                        JOIN order_items oi ON o.id = oi.order_id
                        JOIN products p ON oi.product_id = p.id
                        WHERE p.seller_id = :seller_id
                        AND o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    ");
                    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $orders = $stmt->fetch(PDO::FETCH_ASSOC);
                    $order_count = $orders ? $orders['order_count'] : 0;
                    
                    // Get revenue
                    $stmt = $pdo->prepare("
                        SELECT SUM(oi.price * oi.quantity) as revenue
                        FROM order_items oi
                        JOIN orders o ON oi.order_id = o.id
                        JOIN products p ON oi.product_id = p.id
                        WHERE p.seller_id = :seller_id
                        AND o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                    ");
                    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $revenue = $stmt->fetch(PDO::FETCH_ASSOC);
                    $revenue_amount = $revenue ? $revenue['revenue'] : 0;
                    
                    // Get average rating
                    $stmt = $pdo->prepare("
                        SELECT AVG(r.rating) as avg_rating
                        FROM reviews r
                        JOIN products p ON r.product_id = p.id
                        WHERE p.seller_id = :seller_id
                    ");
                    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $rating = $stmt->fetch(PDO::FETCH_ASSOC);
                    $avg_rating = $rating ? round($rating['avg_rating'], 1) : 0;
                    
                } catch (PDOException $e) {
                    // If database error, use default values
                    $view_count = 0;
                    $order_count = 0;
                    $revenue_amount = 0;
                    $avg_rating = 0;
                }
                ?>
                
                <div class="stat-card">
                    <div class="stat-icon">👁️</div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo number_format($view_count); ?></div>
                        <div class="stat-label">Product Views</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $order_count; ?></div>
                        <div class="stat-label">Orders This Month</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-info">
                        <div class="stat-value">$<?php echo number_format($revenue_amount, 2); ?></div>
                        <div class="stat-label">Monthly Revenue</div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-info">
                        <div class="stat-value"><?php echo $avg_rating; ?></div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
            
            <div class="seller-actions">
                <a href="seller-dashboard.php" class="btn">View Full Dashboard</a>
                <a href="products/add-product.php" class="btn btn-outline">Add New Product</a>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Featured Products -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Shop our most popular and trending items</p>
            
            <div class="products-grid">
                <?php
                // Display featured products
                if (!empty($featured_products)) {
                    foreach ($featured_products as $product) {
                        ?>
                        <div class="product" onclick="window.location.href='product-details.php?id=<?php echo $product['id']; ?>'">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image_url'] ?: '/placeholder.svg?height=300&width=250'); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php if ($product['tag']) { ?>
                                    <div class="product-tag"><?php echo htmlspecialchars($product['tag']); ?></div>
                                <?php } ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <div class="product-price">
                                    <div class="current-price">$<?php echo number_format($product['price'], 2); ?></div>
                                    <?php if ($product['old_price'] > 0) { ?>
                                        <div class="old-price">$<?php echo number_format($product['old_price'], 2); ?></div>
                                    <?php } ?>
                                </div>
                                <div class="product-rating">
                                    <?php echo str_repeat('★', $product['rating']) . str_repeat('☆', 5 - $product['rating']); ?>
                                </div>
                                <div class="product-actions">
                                    <button class="btn add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>); event.stopPropagation();">Add to Cart</button>
                                    <div class="wishlist" onclick="addToWishlist(<?php echo $product['id']; ?>); event.stopPropagation();">❤️</div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    // Default products if database fetch failed
                    ?>
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
                                <button class="btn add-to-cart" onclick="addToCart(1); event.stopPropagation();">Add to Cart</button>
                                <div class="wishlist" onclick="addToWishlist(1); event.stopPropagation();">❤️</div>
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
                                <button class="btn add-to-cart" onclick="addToCart(2); event.stopPropagation();">Add to Cart</button>
                                <div class="wishlist" onclick="addToWishlist(2); event.stopPropagation();">❤️</div>
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
                                <button class="btn add-to-cart" onclick="addToCart(3); event.stopPropagation();">Add to Cart</button>
                                <div class="wishlist" onclick="addToWishlist(3); event.stopPropagation();">❤️</div>
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
                                <button class="btn add-to-cart" onclick="addToCart(4); event.stopPropagation();">Add to Cart</button>
                                <div class="wishlist" onclick="addToWishlist(4); event.stopPropagation();">❤️</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
    <?php include 'includes/newsletter.php'; ?>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="js/script.js"></script>
    <script>
        // Function to toggle search bar
        function toggleSearchBar() {
            const searchBar = document.querySelector('.search-bar');
            searchBar.classList.toggle('active');
            
            if (searchBar.classList.contains('active')) {
                document.getElementById('search-input').focus();
            }
        }
        
        // Function to add item to cart
        function addToCart(productId) {
            // AJAX request to add item to cart
            fetch('cart/add-to-cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId + '&quantity=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    document.querySelector('.cart-count').textContent = data.cart_count;
                    
                    // Show success message
                    showNotification('Product added to cart!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add product to cart.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        }
        
        // Function to add item to wishlist
        function addToWishlist(productId) {
            // AJAX request to add item to wishlist
            fetch('wishlist/add-to-wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Product added to wishlist!', 'success');
                } else {
                    showNotification(data.message || 'Failed to add product to wishlist.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        }
        
        // Function to show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <div class="notification-message">${message}</div>
                    <button class="notification-close" onclick="this.parentElement.parentElement.remove()">✕</button>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('fade-out');
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 5000);
        }
    </script>
</body>
</html>
