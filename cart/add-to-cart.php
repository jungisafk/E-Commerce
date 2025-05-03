<?php
// Start the session
session_start();

// Include database connection
require_once '../config/db.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode([
        'success' => false,
        'message' => 'Please log in to add items to your cart.'
    ]);
    exit;
}

// Check if product_id and quantity are set
if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Missing product ID or quantity.'
    ]);
    exit;
}

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Validate quantity
if ($quantity <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Quantity must be greater than zero.'
    ]);
    exit;
}

try {
    // Check if product exists and is in stock
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id AND stock > 0");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found or out of stock.'
        ]);
        exit;
    }
    
    // Check if quantity is available
    if ($product['stock'] < $quantity) {
        echo json_encode([
            'success' => false,
            'message' => 'Not enough stock available. Only ' . $product['stock'] . ' items left.'
        ]);
        exit;
    }
    
    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product is already in cart
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] === $product_id) {
            // Update quantity
            $item['quantity'] += $quantity;
            $product_exists = true;
            break;
        }
    }
    
    // If product is not in cart, add it
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'quantity' => $quantity,
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image_url']
        ];
    }
    
    // Get cart count
    $cart_count = count($_SESSION['cart']);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart successfully.',
        'cart_count' => $cart_count
    ]);
    
} catch (PDOException $e) {
    // Log error
    error_log('Database error: ' . $e->getMessage());
    
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while adding the product to your cart. Please try again.'
    ]);
}
?>
