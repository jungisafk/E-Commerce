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
        'message' => 'Please log in to add items to your wishlist.'
    ]);
    exit;
}

// Check if product_id is set
if (!isset($_POST['product_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Missing product ID.'
    ]);
    exit;
}

$product_id = intval($_POST['product_id']);
$user_id = $_SESSION['user_id'];

try {
    // Check if product exists
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found.'
        ]);
        exit;
    }
    
    // Check if product is already in wishlist
    $stmt = $p
