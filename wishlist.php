<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'config/db.php';

$user_id = $_SESSION['id'];

// Fetch wishlist items for the user
$stmt = $pdo->prepare("SELECT w.product_id, p.name, p.price, p.image_url FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <div class="container wishlist-page">
            <h1 class="section-title">My Wishlist</h1>
            <?php if (empty($wishlist_items)): ?>
                <div style="text-align: center; padding: 50px 0;">
                    <div style="font-size: 60px; margin-bottom: 20px;">💖</div>
                    <h2>Your wishlist is empty</h2>
                    <p style="margin-bottom: 30px;">Browse products and add your favorites to your wishlist!</p>
                    <a href="shop.php" class="btn">Go to Shop</a>
                </div>
            <?php else: ?>
                <div class="wishlist-items">
                    <?php foreach ($wishlist_items as $item): ?>
                        <div class="wishlist-item" id="wishlist-item-<?php echo $item['product_id']; ?>">
                            <div class="item-image">
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                            </div>
                            <div class="item-actions">
                                <button class="btn add-to-cart-btn" data-product-id="<?php echo $item['product_id']; ?>">Add to Cart</button>
                                <button class="btn remove-wishlist-btn" data-product-id="<?php echo $item['product_id']; ?>">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'includes/newsletter.php'; ?>
    <?php include 'includes/footer.php'; ?>
    <script>
    $(document).ready(function() {
        // Remove from wishlist
        $('.remove-wishlist-btn').click(function() {
            var productId = $(this).data('product-id');
            var btn = $(this);
            $.post('wishlist/add-to-wishlist.php', { product_id: productId, action: 'remove' }, function(response) {
                if (response.success) {
                    $('#wishlist-item-' + productId).fadeOut(300, function() { $(this).remove(); });
                } else {
                    alert(response.message);
                }
            }, 'json');
        });
        // Add to cart
        $('.add-to-cart-btn').click(function() {
            var productId = $(this).data('product-id');
            var btn = $(this);
            $.post('cart/add-to-cart.php', { product_id: productId, quantity: 1 }, function(response) {
                if (response.success) {
                    btn.text('Added!').prop('disabled', true);
                    setTimeout(function() { btn.text('Add to Cart').prop('disabled', false); }, 1500);
                    // Optionally update cart count in header
                    if (response.cart_count !== undefined) {
                        $('.cart-count').text(response.cart_count);
                    }
                } else {
                    alert(response.message);
                }
            }, 'json');
        });
    });
    </script>
</body>
</html>
