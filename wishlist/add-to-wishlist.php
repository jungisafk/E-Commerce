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
        'message' => 'Please log in to manage your wishlist.'
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
$user_id = $_SESSION['id']; // Use correct session key
$action = isset($_POST['action']) ? $_POST['action'] : 'toggle'; // add, remove, or toggle

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
    $stmt = $pdo->prepare("SELECT * FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $wishlist_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($action === 'remove' || ($action === 'toggle' && $wishlist_item)) {
        // Remove from wishlist if exists
        if ($wishlist_item) {
            $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode([
                'success' => true,
                'action' => 'removed',
                'message' => 'Product removed from your wishlist.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product was not in your wishlist.'
            ]);
        }
        exit;
    }

    if ($action === 'add' || ($action === 'toggle' && !$wishlist_item)) {
        // Add to wishlist if not already present
        if (!$wishlist_item) {
            $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id, created_at) VALUES (:user_id, :product_id, NOW())");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode([
                'success' => true,
                'action' => 'added',
                'message' => 'Product added to your wishlist.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product is already in your wishlist.'
            ]);
        }
        exit;
    }

    // If action is not recognized
    echo json_encode([
        'success' => false,
        'message' => 'Invalid action.'
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
    exit;
}
