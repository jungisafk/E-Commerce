<?php
// Start the session
session_start();

// Check if user is logged in and is a seller
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'seller') {
    header('Location: login.php');
    exit;
}

// Get user information
$user_id = $_SESSION['id'];
$user_name = $_SESSION['name'];

// Connect to database
require_once 'config/db.php';

// Get seller statistics
try {
    // Get product count
    $stmt = $pdo->prepare("SELECT COUNT(*) as product_count FROM products WHERE seller_id = ?");
    $stmt->execute([$user_id]);
    $product_count = $stmt->fetch()['product_count'];
    
    // Get order count
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as order_count 
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE p.seller_id = ?
    ");
    $stmt->execute([$user_id]);
    $order_count = $stmt->fetch()['order_count'];
    
    // Get total revenue
    $stmt = $pdo->prepare("
        SELECT SUM(oi.price * oi.quantity) as total_revenue
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE p.seller_id = ?
    ");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    $total_revenue = $result['total_revenue'] ? $result['total_revenue'] : 0;
    
    // Get average rating
    $stmt = $pdo->prepare("
        SELECT AVG(rating) as avg_rating
        FROM reviews r
        JOIN products p ON r.product_id = p.id
        WHERE p.seller_id = ?
    ");
    $stmt->execute([$user_id]);
    $result = $stmt->fetch();
    $avg_rating = $result['avg_rating'] ? number_format($result['avg_rating'], 1) : 'N/A';
    
    // Get recent activity
    $stmt = $pdo->prepare("
        (SELECT 'order' as type, o.id, o.created_at, p.name as product_name, o.status,
                CONCAT('Order #', o.id) as title,
                CONCAT(p.name, ' - Size ', oi.size, ', ', oi.color) as description
         FROM orders o
         JOIN order_items oi ON o.id = oi.order_id
         JOIN products p ON oi.product_id = p.id
         WHERE p.seller_id = ?)
        UNION
        (SELECT 'review' as type, r.id, r.created_at, p.name as product_name, 
                CASE WHEN r.rating >= 4 THEN 'Positive' ELSE 'Neutral' END as status,
                'New Review' as title,
                CONCAT(p.name, ' - ', r.rating, ' stars') as description
         FROM reviews r
         JOIN products p ON r.product_id = p.id
         WHERE p.seller_id = ?)
        UNION
        (SELECT 'payment' as type, o.id, o.updated_at as created_at, p.name as product_name, 'Completed' as status,
                'Payment Received' as title,
                CONCAT('Order #', o.id, ' - $', (oi.price * oi.quantity)) as description
         FROM orders o
         JOIN order_items oi ON o.id = oi.order_id
         JOIN products p ON oi.product_id = p.id
         WHERE p.seller_id = ? AND o.status = 'completed')
        UNION
        (SELECT 'product' as type, p.id, p.created_at, p.name as product_name, 'Active' as status,
                'Product Published' as title,
                p.name as description
         FROM products p
         WHERE p.seller_id = ?)
        ORDER BY created_at DESC
        LIMIT 4
    ");
    $stmt->execute([$user_id, $user_id, $user_id, $user_id]);
    $recent_activity = $stmt->fetchAll();
    
} catch (PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Dashboard -->
    <main>
        <div class="container">
            <div class="dashboard-container">
                <div class="dashboard-sidebar">
                    <div class="dashboard-user">
                        <div class="user-avatar"><?php echo strtoupper(substr($user_name, 0, 2)); ?></div>
                        <div class="user-info">
                            <div class="user-name"><?php echo htmlspecialchars($user_name); ?></div>
                            <div class="user-role">Seller</div>
                        </div>
                    </div>
                    
                    <div class="dashboard-menu">
                        <a href="seller-dashboard.php" class="dashboard-menu-item active">
                            <span class="menu-icon"><i class="fas fa-chart-line"></i></span>
                            <span>Dashboard</span>
                        </a>
                        <a href="seller-products.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-tshirt"></i></span>
                            <span>My Products</span>
                        </a>
                        <a href="seller-add-product.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-plus"></i></span>
                            <span>Add Product</span>
                        </a>
                        <a href="seller-orders.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-box"></i></span>
                            <span>Orders</span>
                        </a>
                        <a href="seller-profile.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-user"></i></span>
                            <span>Profile</span>
                        </a>
                        <a href="auth/logout.php" class="dashboard-menu-item">
                            <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
                
                <div class="dashboard-content">
                    <div class="dashboard-header">
                        <h1 class="dashboard-title">Dashboard</h1>
                        <div class="dashboard-actions">
                            <button class="btn btn-primary" onclick="window.location.href='seller-add-product.php'">Add New Product</button>
                        </div>
                    </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 4px;">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="dashboard-stats">
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-tshirt"></i></div>
                            <div class="stat-info">
                                <div class="stat-value"><?php echo $product_count; ?></div>
                                <div class="stat-label">Products</div>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-box"></i></div>
                            <div class="stat-info">
                                <div class="stat-value"><?php echo $order_count; ?></div>
                                <div class="stat-label">Orders</div>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                            <div class="stat-info">
                                <div class="stat-value">$<?php echo number_format($total_revenue, 2); ?></div>
                                <div class="stat-label">Revenue</div>
                            </div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon"><i class="fas fa-star"></i></div>
                            <div class="stat-info">
                                <div class="stat-value"><?php echo $avg_rating; ?></div>
                                <div class="stat-label">Rating</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="recent-activity">
                        <h2 class="section-title">Recent Activity</h2>
                        
                        <div class="activity-list">
                            <?php if (empty($recent_activity)): ?>
                                <div style="text-align: center; padding: 30px;">
                                    <p>No recent activity found.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($recent_activity as $activity): ?>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <?php if ($activity['type'] === 'order'): ?>
                                                <i class="fas fa-box"></i>
                                            <?php elseif ($activity['type'] === 'review'): ?>
                                                <i class="fas fa-star"></i>
                                            <?php elseif ($activity['type'] === 'payment'): ?>
                                                <i class="fas fa-dollar-sign"></i>
                                            <?php elseif ($activity['type'] === 'product'): ?>
                                                <i class="fas fa-tshirt"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-title"><?php echo htmlspecialchars($activity['title']); ?></div>
                                            <div class="activity-description"><?php echo htmlspecialchars($activity['description']); ?></div>
                                            <div class="activity-time">
                                                <?php 
                                                    $activity_time = new DateTime($activity['created_at']);
                                                    $now = new DateTime();
                                                    $interval = $activity_time->diff($now);
                                                    
                                                    if ($interval->d > 0) {
                                                        echo $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                                                    } elseif ($interval->h > 0) {
                                                        echo $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                                                    } elseif ($interval->i > 0) {
                                                        echo $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                                                    } else {
                                                        echo 'Just now';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="activity-status"><?php echo htmlspecialchars($activity['status']); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
