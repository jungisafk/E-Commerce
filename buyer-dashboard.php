<?php
// Start the session
session_start();

// Check if user is logged in and is a buyer
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'buyer') {
    header('Location: login.php');
    exit;
}

// Get user information
$user_id = $_SESSION['id'];
$user_name = $_SESSION['name'];

// Connect to database
require_once 'config/db.php';

// Get buyer statistics
try {
    // Get order count
    $stmt = $pdo->prepare("SELECT COUNT(*) as order_count FROM orders WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $order_count = $stmt->fetch()['order_count'];
    
    // Get wishlist count
    $stmt = $pdo->prepare("SELECT COUNT(*) as wishlist_count FROM wishlist WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $wishlist_count = $stmt->fetch()['wishlist_count'];
    
    // Get recent orders
    $stmt = $pdo->prepare("
        SELECT o.id, o.created_at, o.status, o.total, 
               COUNT(oi.id) as item_count
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $recent_orders = $stmt->fetchAll();
    
    // Get wishlist items
    $stmt = $pdo->prepare("
        SELECT p.id, p.name, p.price, p.image, p.sale_price
        FROM wishlist w
        JOIN products p ON w.product_id = p.id
        WHERE w.user_id = ?
        ORDER BY w.created_at DESC
        LIMIT 4
    ");
    $stmt->execute([$user_id]);
    $wishlist_items = $stmt->fetchAll();
    
    // Get recently viewed products
    $recently_viewed = isset($_SESSION['recently_viewed']) ? $_SESSION['recently_viewed'] : [];
    
    if (!empty($recently_viewed)) {
        $placeholders = implode(',', array_fill(0, count($recently_viewed), '?'));
        $stmt = $pdo->prepare("
            SELECT id, name, price, image, sale_price
            FROM products
            WHERE id IN ($placeholders)
            ORDER BY FIELD(id, $placeholders)
            LIMIT 4
        ");
        $params = array_merge($recently_viewed, $recently_viewed);
        $stmt->execute($params);
        $recently_viewed_products = $stmt->fetchAll();
    } else {
        $recently_viewed_products = [];
    }
    
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Dashboard -->
    <main>
        <div class="container">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard | FASHION TRENDS</title>
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
            <a href="index.php" >Home</a>
            <a href="men.php" >Men</a>
            <a href="women.php" >Women</a>
            <a href="kids.php" >Kids</a>
            <a href="accessories.php" >Accessories</a>
            <a href="sale.php" >Sale</a>
        </nav>
        
        <div class="header-icons">
            <div class="icon search-icon" onclick="toggleSearchBar()">🔍</div>
            <div class="icon" onclick="window.location.href='buyer-dashboard.php'">
                👤
                                    <span class="user-badge buyer-badge">Buyer</span>
                            </div>
            <div class="icon" onclick="window.location.href='wishlist/add-to-wishlist.php'">💖</div>
            <div class="icon" onclick="window.location.href='cart.php'">
                🛒
                <span class="cart-count">0</span>
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
    
    <!-- Dashboard -->
    <main>
        <div class="container">
            <div class="dashboard-container">
                <div class="dashboard-sidebar">
                    <div class="dashboard-user">
                        <div class="user-avatar">JU</div>
                        <div class="user-info">
                            <div class="user-name">jung</div>
                            <div class="user-role">Buyer</div>
                        </div>
                    </div>
                    
                    <div class="dashboard-menu">
                        <a href="buyer-dashboard.php" class="dashboard-menu-item active">
                            <span class="menu-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                        <a href="buyer-orders.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-box"></i></span>
                            <span>My Orders</span>
                        </a>
                        <a href="wishlist.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-heart"></i></span>
                            <span>Wishlist</span>
                        </a>
                        <a href="buyer-profile.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-user"></i></span>
                            <span>Profile</span>
                        </a>
                        <a href="auth/logout.php" class="dashboard-menu-item logout" onclick="return confirm('Are you sure you want to log out?')">
                            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
                
                <div class="dashboard-content">
                    <div class="dashboard-header">
                        <h1 class="dashboard-title">My Dashboard</h1>
                        <div class="dashboard-actions">
                            <button class="btn" onclick="window.location.href='shop.php'">Continue Shopping</button>
                        </div>
                    </div>
                    
                                            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            Database error: SQLSTATE[42S22]: Column not found: 1054 Unknown column 'o.status' in 'field list'                        </div>
                                        
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-box"></i></div>
                            <div class="stat-info">
                                <div class="stat-value">0</div>
                                <div class="stat-label">Orders</div>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-heart"></i></div>
                            <div class="stat-info">
                                <div class="stat-value">0</div>
                                <div class="stat-label">Wishlist Items</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-orders" style="margin-top: 40px;">
                        <h2 class="section-title">Recent Orders</h2>
                        
                                                    <div style="text-align: center; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <p>You haven't placed any orders yet.</p>
                                <a href="shop.php" class="btn" style="margin-top: 15px;">Start Shopping</a>
                            </div>
                                                                </div>
                                
                                
                                </div>
                                </div>
                                </div>
                                </main>
        <!-- Newsletter Section -->
        <section class="section newsletter">
    <div class="container">
        <h2 class="section-title">Subscribe to Our Newsletter</h2>
        <p class="section-subtitle">Get the latest updates on new products and upcoming sales</p>
        
        <form class="newsletter-form" action="process-newsletter.php" method="post">
            <input type="email" name="email" placeholder="Your email address" class="newsletter-input" required>
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
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
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
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
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
            <p>&copy; 2025 FASHION TRENDS. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Add Font Awesome for better icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- JavaScript -->
<script>
    // Function to toggle search bar
    function toggleSearchBar() {
        const searchBar = document.querySelector('.search-bar');
        searchBar.classList.toggle('active');
        
        if (searchBar.classList.contains('active')) {
            document.getElementById('search-input').focus();
        }
    }
</script>

            <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
            <script src="script.js"></script>
    </body>
</html>
            <div class="dashboard-container">
                <div class="dashboard-sidebar">
                    <div class="dashboard-user">
                        <div class="user-avatar"><?php echo strtoupper(substr($user_name, 0, 2)); ?></div>
                        <div class="user-info">
                            <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
                            <div class="user-role">Buyer</div>
                        </div>
                    </div>
                    
                    <div class="dashboard-menu">
                        <a href="buyer-dashboard.php" class="dashboard-menu-item active">
                            <span class="menu-icon"><i class="fas fa-home"></i></span>
                            <span>Dashboard</span>
                        </a>
                        <a href="buyer-orders.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-box"></i></span>
                            <span>My Orders</span>
                        </a>
                        <a href="wishlist.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-heart"></i></span>
                            <span>Wishlist</span>
                        </a>
                        <a href="buyer-profile.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-user"></i></span>
                            <span>Profile</span>
                        </a>
                        <a href="auth/logout.php" class="dashboard-menu-item logout" onclick="return confirm('Are you sure you want to log out?')">
                            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
                
                <div class="dashboard-content">
                    <div class="dashboard-header">
                        <h1 class="dashboard-title">My Dashboard</h1>
                        <div class="dashboard-actions">
                            <button class="btn" onclick="window.location.href='shop.php'">Continue Shopping</button>
                        </div>
                    </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-box"></i></div>
                            <div class="stat-info">
                                <div class="stat-value"><?php echo $order_count; ?></div>
                                <div class="stat-label">Orders</div>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-heart"></i></div>
                            <div class="stat-info">
                                <div class="stat-value"><?php echo $wishlist_count; ?></div>
                                <div class="stat-label">Wishlist Items</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-orders" style="margin-top: 40px;">
                        <h2 class="section-title">Recent Orders</h2>
                        
                        <?php if (empty($recent_orders)): ?>
                            <div style="text-align: center; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                                <p>You haven't placed any orders yet.</p>
                                <a href="shop.php" class="btn" style="margin-top: 15px;">Start Shopping</a>
                            </div>
                        <?php else: ?>
                            <div style="background-color: white; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="background-color: #f8f9fa;">
                                            <th style="padding: 15px; text-align: left;">Order #</th>
                                            <th style="padding: 15px; text-align: left;">Date</th>
                                            <th style="padding: 15px; text-align: left;">Status</th>
                                            <th style="padding: 15px; text-align: left;">Items</th>
                                            <th style="padding: 15px; text-align: left;">Total</th>
                                            <th style="padding: 15px; text-align: left;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recent_orders as $order): ?>
                                            <tr style="border-bottom: 1px solid #dee2e6;">
                                                <td style="padding: 15px;">#<?php echo $order['id']; ?></td>
                                                <td style="padding: 15px;">
                                                    <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                                                </td>
                                                <td style="padding: 15px;">
                                                    <span style="
                                                        padding: 5px 10px;
                                                        border-radius: 4px;
                                                        font-size: 14px;
                                                        <?php
                                                            switch ($order['status']) {
                                                                case 'pending':
                                                                    echo 'background-color: #fff3cd; color: #856404;';
                                                                    break;
                                                                case 'processing':
                                                                    echo 'background-color: #cce5ff; color: #004085;';
                                                                    break;
                                                                case 'shipped':
                                                                    echo 'background-color: #d1ecf1; color: #0c5460;';
                                                                    break;
                                                                case 'completed':
                                                                    echo 'background-color: #d4edda; color: #155724;';
                                                                    break;
                                                                case 'cancelled':
                                                                    echo 'background-color: #f8d7da; color: #721c24;';
                                                                    break;
                                                                default:
                                                                    echo 'background-color: #e2e3e5; color: #383d41;';
                                                            }
                                                        ?>
                                                    ">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>

                                                <td style="padding: 15px;"><?php echo $order['item_count']; ?> items</td>
                                                <td style="padding: 15px;">$<?php echo number_format($order['total'], 2); ?></td>
                                                <td style="padding: 15px;">
                                                    <a href="order-details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm">View</a>
                                                </td>
                                                </tr>
                            <?php endforeach; ?>
                                </tbody>
                                    </table>
                                        </div>
                            <?php endif; ?>
                                        </div>
                                <?php if (!empty($wishlist_items)): ?>
                                <div class="wishlist-preview" style="margin-top: 40px;">
                                    <h2 class="section-title">Wishlist</h2>
                                    <div class="product-grid">
                                        <?php foreach ($wishlist_items as $product): ?>
                                            <div class="product-card">
                                                <div class="product-image">
                                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                                </div>
                                                <div class="product-info">
                                                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                                    <div class="product-price">
                                                        <?php if ($product['sale_price']): ?>
                                                            <span class="price-old">$<?php echo number_format($product['price'], 2); ?></span>
                                                            <span class="price-current">$<?php echo number_format($product['sale_price'], 2); ?></span>
                                                        <?php else: ?>
                                                            <span class="price-current">$<?php echo number_format($product['price'], 2); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="product-actions">
                                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm">View</a>
                                                        <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn btn-sm">Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div style="text-align: center; margin-top: 20px;">
                                        <a href="wishlist.php" class="btn">View All Wishlist Items</a>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($recently_viewed_products)): ?>
                                <div class="recently-viewed" style="margin-top: 40px;">
                                    <h2 class="section-title">Recently Viewed</h2>
                                    <div class="product-grid">
                                        <?php foreach ($recently_viewed_products as $product): ?>
                                            <div class="product-card">
                                                <div class="product-image">
                                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                                </div>
                                                <div class="product-info">
                                                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                                    <div class="product-price">
                                                        <?php if ($product['sale_price']): ?>
                                                            <span class="price-old">$<?php echo number_format($product['price'], 2); ?></span>
                                                            <span class="price-current">$<?php echo number_format($product['sale_price'], 2); ?></span>
                                                        <?php else: ?>
                                                            <span class="price-current">$<?php echo number_format($product['price'], 2); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="product-actions">
                                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm">View</a>
                                                        <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn btn-sm">Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                </div>
                                </div>
                                </div>
                                </main>
        <!-- Newsletter Section -->
        <?php include 'includes/newsletter.php'; ?>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>

            <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
            <script src="script.js"></script>
    </body>
</html>