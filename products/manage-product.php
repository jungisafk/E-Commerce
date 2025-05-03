<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is a seller
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "seller") {
    header("location: ../auth/login.php");
    exit;
}

// Get seller's products
try {
    $stmt = $pdo->prepare("
        SELECT p.*, c.name as category_name, 
               (SELECT image_path FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as image
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.seller_id = :seller_id
        ORDER BY p.created_at DESC
    ");
    $stmt->bindParam(':seller_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Handle delete product
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $product_id = $_GET['delete'];
    
    try {
        // Check if product belongs to the seller
        $stmt = $pdo->prepare("SELECT id FROM products WHERE id = :id AND seller_id = :seller_id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':seller_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Start transaction
            $pdo->beginTransaction();
            
            // Delete product images
            $stmt = $pdo->prepare("SELECT image_path FROM product_images WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            $images = $stmt->fetchAll();
            
            foreach ($images as $image) {
                // Delete image file
                $file_path = '../' . $image['image_path'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            
            // Delete from product_images table
            $stmt = $pdo->prepare("DELETE FROM product_images WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Delete from product_variations table
            $stmt = $pdo->prepare("DELETE FROM product_variations WHERE product_id = :product_id");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Delete from products table
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id AND seller_id = :seller_id");
            $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':seller_id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            
            // Commit the transaction
            $pdo->commit();
            
            $success = "Product deleted successfully!";
            header("location: manage-products.php?success=" . urlencode($success));
            exit;
        }
    } catch(PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | FASHION TRENDS</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="../account-styles.css">
</head>
<body>
    <!-- Header -->
    <?php include '../includes/header.php'; ?>
    
    <!-- Dashboard -->
    <div class="container">
        <div class="dashboard-container">
            <!-- Sidebar -->
            <?php include '../includes/seller-sidebar.php'; ?>
            
            <div class="dashboard-content">
                <div class="dashboard-header">
                    <h1 class="dashboard-title">My Products</h1>
                    <div class="dashboard-actions">
                        <button class="btn" onclick="window.location.href='add-product.php'">Add New Product</button>
                    </div>
                </div>
                
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <div class="product-list">
                    <?php if(count($products) > 0): ?>
                        <?php foreach($products as $product): ?>
                            <div class="product-card">
                                <div class="product-card-image">
                                    <img src="<?php echo !empty($product['image']) ? '../' . $product['image'] : '../uploads/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <div class="product-card-status status-<?php echo $product['status']; ?>">
                                        <?php echo ucfirst($product['status']); ?>
                                    </div>
                                </div>
                                <div class="product-card-content">
                                    <h3 class="product-card-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <div class="product-card-price">
                                        $<?php echo number_format($product['price'], 2); ?>
                                        <?php if(!empty($product['old_price'])): ?>
                                            <span class="old-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-card-meta">
                                        <span><?php echo htmlspecialchars($product['category_name']); ?></span>
                                        <span>Stock: <?php echo $product['quantity']; ?></span>
                                    </div>
                                    <div class="product-card-actions">
                                        <button class="edit-btn" onclick="window.location.href='edit-product.php?id=<?php echo $product['id']; ?>'">Edit</button>
                                        <button class="delete-btn" onclick="confirmDelete(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>')">Delete</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-products">
                            <p>You haven't added any products yet.</p>
                            <button class="btn" onclick="window.location.href='add-product.php'">Add Your First Product</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../script.js"></script>
    <script>
        function confirmDelete(productId, productName) {
            if (confirm(`Are you sure you want to delete "${productName}"? This action cannot be undone.`)) {
                window.location.href = `manage-products.php?delete=${productId}`;
            }
        }
    </script>
</body>
</html>
