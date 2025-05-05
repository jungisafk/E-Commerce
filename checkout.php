<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Get cart items from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_count = count($cart_items);

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping = $subtotal >= 50 ? 0 : 5.99;
$tax = round($subtotal * 0.08, 2); // 8% tax
$total = $subtotal + $shipping + $tax;

// Handle form submission
$order_success = false;
$order_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Validate required fields
    $required = ['firstName','lastName','country','address','city','state','zip','phone','email'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $order_error = 'Please fill in all required fields.';
            break;
        }
    }
    if (!$order_error && empty($cart_items)) {
        $order_error = 'Your cart is empty.';
    }
    if (!$order_error) {
        // (Mock) Save order details here if needed
        // Clear cart
        unset($_SESSION['cart']);
        $order_success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | FASHION TRENDS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container checkout-container">
        <?php if ($order_success): ?>
            <div style="text-align:center; padding:60px 0;">
                <div style="font-size:60px; margin-bottom:20px;">✅</div>
                <h2>Thank you for your order!</h2>
                <p>Your order has been placed successfully. A confirmation email will be sent to you.</p>
                <a href="shop.php" class="btn">Continue Shopping</a>
            </div>
        <?php else: ?>
        <div class="checkout-form">
            <h2 class="form-title">Billing Details</h2>
            <?php if ($order_error): ?>
                <div class="alert alert-danger" style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:20px;border-radius:4px;">
                    <?php echo htmlspecialchars($order_error); ?>
                </div>
            <?php endif; ?>
            <form method="post" action="checkout.php">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name *</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" required value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" required value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="company" class="form-label">Company Name (Optional)</label>
                    <input type="text" id="company" name="company" class="form-control" value="<?php echo isset($_POST['company']) ? htmlspecialchars($_POST['company']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="country" class="form-label">Country / Region *</label>
                    <select id="country" name="country" class="form-control" required>
                        <option value="">Select a country</option>
                        <option value="US" <?php if(isset($_POST['country']) && $_POST['country']==='US') echo 'selected'; ?>>United States</option>
                        <option value="CA" <?php if(isset($_POST['country']) && $_POST['country']==='CA') echo 'selected'; ?>>Canada</option>
                        <option value="UK" <?php if(isset($_POST['country']) && $_POST['country']==='UK') echo 'selected'; ?>>United Kingdom</option>
                        <option value="AU" <?php if(isset($_POST['country']) && $_POST['country']==='AU') echo 'selected'; ?>>Australia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="address" class="form-label">Street Address *</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="House number and street name" required value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '' ?>">
                </div>
                <div class="form-group">
                    <input type="text" id="address2" name="address2" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="<?php echo isset($_POST['address2']) ? htmlspecialchars($_POST['address2']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="city" class="form-label">Town / City *</label>
                    <input type="text" id="city" name="city" class="form-control" required value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '' ?>">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="state" class="form-label">State *</label>
                        <select id="state" name="state" class="form-control" required>
                            <option value="">Select a state</option>
                            <option value="NY" <?php if(isset($_POST['state']) && $_POST['state']==='NY') echo 'selected'; ?>>New York</option>
                            <option value="CA" <?php if(isset($_POST['state']) && $_POST['state']==='CA') echo 'selected'; ?>>California</option>
                            <option value="TX" <?php if(isset($_POST['state']) && $_POST['state']==='TX') echo 'selected'; ?>>Texas</option>
                            <option value="FL" <?php if(isset($_POST['state']) && $_POST['state']==='FL') echo 'selected'; ?>>Florida</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="zip" class="form-label">ZIP Code *</label>
                        <input type="text" id="zip" name="zip" class="form-control" required value="<?php echo isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : '' ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="createAccount" name="createAccount" class="form-check-input" <?php if(isset($_POST['createAccount'])) echo 'checked'; ?>>
                        <label for="createAccount">Create an account?</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="form-label">Order Notes (Optional)</label>
                    <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"><?php echo isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : '' ?></textarea>
                </div>
                <h2 class="form-title" style="margin-top: 40px;">Payment Method</h2>
                <div class="payment-methods">
                    <div class="payment-method active">
                        <input type="radio" name="payment" id="creditCard" class="payment-radio" checked>
                        <label for="creditCard">Credit Card</label>
                        <div class="payment-logo">
                            <img src="/placeholder.svg?height=24&width=36" alt="Visa">
                            <img src="/placeholder.svg?height=24&width=36" alt="MasterCard">
                            <img src="/placeholder.svg?height=24&width=36" alt="American Express">
                        </div>
                    </div>
                    <div class="payment-method">
                        <input type="radio" name="payment" id="paypal" class="payment-radio">
                        <label for="paypal">PayPal</label>
                        <div class="payment-logo">
                            <img src="/placeholder.svg?height=24&width=36" alt="PayPal">
                        </div>
                    </div>
                    <div class="payment-method">
                        <input type="radio" name="payment" id="bankTransfer" class="payment-radio">
                        <label for="bankTransfer">Direct Bank Transfer</label>
                    </div>
                </div>
                <div style="margin-top:30px;">
                    <button class="btn place-order-btn" type="submit" name="place_order">Place Order</button>
                </div>
            </form>
        </div>
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>
            <div class="order-items">
                <?php if (empty($cart_items)): ?>
                    <div style="padding:20px; text-align:center;">Your cart is empty.</div>
                <?php else: ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="order-item">
                            <div class="order-item-name">
                                <div class="item-quantity-badge"><?php echo $item['quantity']; ?></div>
                                <div><?php echo htmlspecialchars($item['name']); ?></div>
                            </div>
                            <div class="order-item-price">$<?php echo number_format($item['price'], 2); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="summary-row">
                <div class="summary-label">Subtotal</div>
                <div class="summary-value">$<?php echo number_format($subtotal, 2); ?></div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Shipping</div>
                <div class="summary-value"><?php echo $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free'; ?></div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Tax</div>
                <div class="summary-value">$<?php echo number_format($tax, 2); ?></div>
            </div>
            <div class="summary-row summary-total">
                <div class="summary-label">Total</div>
                <div class="summary-value">$<?php echo number_format($total, 2); ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
