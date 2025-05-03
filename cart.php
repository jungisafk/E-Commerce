<?php
// Start the session
session_start();

// Check if user is logged in
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$user_role = $is_logged_in ? $_SESSION['role'] : '';
$user_name = $is_logged_in ? $_SESSION['name'] : '';

// Get cart items from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_count = count($cart_items);

// Calculate cart totals
$subtotal = 0;
$shipping = 0;
$discount = 0;

// If cart has items, calculate subtotal
if (!empty($cart_items)) {
    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    // Free shipping for orders over $50
    $shipping = $subtotal >= 50 ? 0 : 5.99;
}

// Apply discount if there's a coupon in session
if (isset($_SESSION['coupon'])) {
    $discount = $subtotal * ($_SESSION['coupon']['discount'] / 100);
}

// Calculate total
$total = $subtotal + $shipping - $discount;

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update cart quantities
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $id => $quantity) {
            if (isset($cart_items[$id])) {
                $cart_items[$id]['quantity'] = max(1, (int)$quantity);
            }
        }
        $_SESSION['cart'] = $cart_items;
        header('Location: cart.php?updated=1');
        exit;
    }
    
    // Apply coupon
    if (isset($_POST['apply_coupon']) && !empty($_POST['coupon_code'])) {
        $coupon_code = trim($_POST['coupon_code']);
        
        // In a real application, you would check the coupon code against a database
        // For this example, we'll use a simple hardcoded coupon
        if ($coupon_code === 'SAVE10') {
            $_SESSION['coupon'] = [
                'code' => $coupon_code,
                'discount' => 10
            ];
            header('Location: cart.php?coupon=applied');
            exit;
        } else {
            $coupon_error = 'Invalid coupon code';
        }
    }
}

// Handle item removal via AJAX
if (isset($_GET['remove']) && isset($cart_items[$_GET['remove']])) {
    unset($cart_items[$_GET['remove']]);
    $_SESSION['cart'] = $cart_items;
    
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'cart_count' => count($cart_items),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2)
        ]);
        exit;
    }
    
    header('Location: cart.php?removed=1');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <?php include 'includes/header.php'; ?>
    
    <!-- Cart Page -->
    <main>
        <div class="container cart-page">
            <h1 class="section-title">Shopping Cart</h1>
            
            <?php if (empty($cart_items)): ?>
                <div style="text-align: center; padding: 50px 0;">
                    <div style="font-size: 60px; margin-bottom: 20px;">🛒</div>
                    <h2>Your cart is empty</h2>
                    <p style="margin-bottom: 30px;">Looks like you haven't added any products to your cart yet.</p>
                    <a href="shop.php" class="btn">Continue Shopping</a>
                </div>
            <?php else: ?>
                <form method="post" action="cart.php" id="cart-form">
                    <div class="cart-header">
                        <div>Image</div>
                        <div>Product</div>
                        <div>Price</div>
                        <div>Quantity</div>
                        <div>Total</div>
                        <div></div>
                    </div>
                    
                    <div class="cart-items">
                        <?php foreach ($cart_items as $id => $item): ?>
                            <div class="cart-item" id="cart-item-<?php echo $id; ?>">
                                <div class="item-image">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                <div class="item-details">
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p>
                                        <?php if (isset($item['size'])): ?>
                                            Size: <?php echo htmlspecialchars($item['size']); ?> | 
                                        <?php endif; ?>
                                        <?php if (isset($item['color'])): ?>
                                            Color: <?php echo htmlspecialchars($item['color']); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                                <div class="item-quantity">
                                    <div class="quantity-btn-cart decrease">-</div>
                                    <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input-cart" data-id="<?php echo $id; ?>" data-price="<?php echo $item['price']; ?>">
                                    <div class="quantity-btn-cart increase">+</div>
                                </div>
                                <div class="item-total">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                                <div class="remove-item" data-id="<?php echo $id; ?>">✕</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cart-actions">
                        <div class="coupon">
                            <input type="text" name="coupon_code" placeholder="Coupon code" class="coupon-input" value="<?php echo isset($_SESSION['coupon']) ? $_SESSION['coupon']['code'] : ''; ?>">
                            <button type="submit" name="apply_coupon" class="btn">Apply Coupon</button>
                            <?php if (isset($coupon_error)): ?>
                                <div style="color: var(--danger); margin-top: 5px;"><?php echo $coupon_error; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <button type="submit" name="update_cart" class="btn">Update Cart</button>
                    </div>
                </form>
                
                <div style="display: grid; grid-template-columns: 1fr 400px; gap: 30px;">
                    <div></div>
                    <div class="cart-summary">
                        <h3 class="summary-title">Cart Total</h3>
                        
                        <div class="summary-row">
                            <div class="summary-label">Subtotal</div>
                            <div class="summary-value" id="cart-subtotal">$<?php echo number_format($subtotal, 2); ?></div>
                        </div>
                        
                        <div class="summary-row">
                            <div class="summary-label">Shipping</div>
                            <div class="summary-value" id="cart-shipping">
                                <?php echo $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free'; ?>
                            </div>
                        </div>
                        
                        <div class="summary-row">
                            <div class="summary-label">Discount</div>
                            <div class="summary-value" id="cart-discount">
                                <?php echo $discount > 0 ? '-$' . number_format($discount, 2) : '-$0.00'; ?>
                            </div>
                        </div>
                        
                        <div class="summary-row summary-total">
                            <div class="summary-label">Total</div>
                            <div class="summary-value" id="cart-total">$<?php echo number_format($total, 2); ?></div>
                        </div>
                        
                        <button class="btn checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <!-- Newsletter Section -->
    <?php include 'includes/newsletter.php'; ?>
    
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            // Quantity increase/decrease
            $('.increase').click(function() {
                const input = $(this).siblings('input');
                input.val(parseInt(input.val()) + 1).trigger('change');
            });
            
            $('.decrease').click(function() {
                const input = $(this).siblings('input');
                const currentVal = parseInt(input.val());
                if (currentVal > 1) {
                    input.val(currentVal - 1).trigger('change');
                }
            });
            
            // Update item total when quantity changes
            $('.quantity-input-cart').on('change', function() {
                const id = $(this).data('id');
                const price = $(this).data('price');
                const quantity = parseInt($(this).val());
                const total = price * quantity;
                
                $(this).closest('.cart-item').find('.item-total').text('$' + total.toFixed(2));
            });
            
            // Remove item from cart
            $('.remove-item').click(function() {
                const id = $(this).data('id');
                
                $.ajax({
                    url: 'cart.php?remove=' + id + '&ajax=1',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#cart-item-' + id).fadeOut(300, function() {
                                $(this).remove();
                                
                                // Update cart count
                                $('.cart-count').text(response.cart_count);
                                
                                // Update totals
                                $('#cart-subtotal').text('$' + response.subtotal);
                                $('#cart-total').text('$' + response.total);
                                
                                // If cart is empty, reload the page
                                if (response.cart_count === 0) {
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
