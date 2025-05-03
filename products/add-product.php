<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in and is a seller
if (!isset($_SESSION["loggedin"]) || $_SESSION["role"] !== "seller") {
    header("location: ../auth/login.php");
    exit;
}

// Get categories for dropdown
try {
    $stmt = $pdo->query("SELECT id, name FROM categories WHERE parent_id IS NOT NULL ORDER BY name");
    $categories = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = trim($_POST['name']);
    $category_id = $_POST['category_id'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $old_price = !empty($_POST['old_price']) ? $_POST['old_price'] : null;
    $quantity = $_POST['quantity'];
    $sku = trim($_POST['sku']);
    $material = trim($_POST['material']);
    $status = $_POST['status'];
    
    // Get sizes and colors
    $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
    $colors = isset($_POST['colors']) ? $_POST['colors'] : [];
    
    // Validate input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Product name is required";
    }
    
    if (empty($category_id)) {
        $errors[] = "Category is required";
    }
    
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    
    if (empty($price) || !is_numeric($price) || $price <= 0) {
        $errors[] = "Valid price is required";
    }
    
    if (!empty($old_price) && (!is_numeric($old_price) || $old_price <= 0)) {
        $errors[] = "Old price must be a valid number";
    }
    
    if (empty($quantity) || !is_numeric($quantity) || $quantity < 0) {
        $errors[] = "Valid quantity is required";
    }
    
    // If no errors, proceed with adding the product
    if (empty($errors)) {
        try {
            // Start transaction
            $pdo->beginTransaction();
            
            // Insert into products table
            $sql = "INSERT INTO products (seller_id, category_id, name, description, price, old_price, quantity, sku, status, material) 
                    VALUES (:seller_id, :category_id, :name, :description, :price, :old_price, :quantity, :sku, :status, :material)";
            $stmt = $pdo->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':seller_id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':old_price', $old_price, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':sku', $sku, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':material', $material, PDO::PARAM_STR);
            
            // Execute the statement
            $stmt->execute();
            
            // Get the last inserted ID (product_id)
            $product_id = $pdo->lastInsertId();
            
            // Handle product variations (sizes and colors)
            if (!empty($sizes) && !empty($colors)) {
                foreach ($sizes as $size) {
                    foreach ($colors as $color) {
                        $sql = "INSERT INTO product_variations (product_id, size, color, quantity) 
                                VALUES (:product_id, :size, :color, :quantity)";
                        $stmt = $pdo->prepare($sql);
                        
                        // Divide quantity evenly among variations
                        $variation_quantity = ceil($quantity / (count($sizes) * count($colors)));
                        
                        // Bind parameters
                        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                        $stmt->bindParam(':size', $size, PDO::PARAM_STR);
                        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
                        $stmt->bindParam(':quantity', $variation_quantity, PDO::PARAM_INT);
                        
                        // Execute the statement
                        $stmt->execute();
                    }
                }
            }
            
            // Handle product images
            if (!empty($_FILES['images']['name'][0])) {
                $upload_dir = '../uploads/products/';
                
                // Create directory if it doesn't exist
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                // Loop through each uploaded file
                foreach ($_FILES['images']['name'] as $key => $name) {
                    $tmp_name = $_FILES['images']['tmp_name'][$key];
                    
                    // Generate unique filename
                    $filename = uniqid() . '_' . $name;
                    $destination = $upload_dir . $filename;
                    
                    // Move the uploaded file
                    if (move_uploaded_file($tmp_name, $destination)) {
                        // Set the first image as primary
                        $is_primary = ($key === 0) ? 1 : 0;
                        
                        // Insert into product_images table
                        $sql = "INSERT INTO product_images (product_id, image_path, is_primary) 
                                VALUES (:product_id, :image_path, :is_primary)";
                        $stmt = $pdo->prepare($sql);
                        
                        // Relative path for database
                        $relative_path = 'uploads/products/' . $filename;
                        
                        // Bind parameters
                        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                        $stmt->bindParam(':image_path', $relative_path, PDO::PARAM_STR);
                        $stmt->bindParam(':is_primary', $is_primary, PDO::PARAM_INT);
                        
                        // Execute the statement
                        $stmt->execute();
                    }
                }
            }
            
            // Commit the transaction
            $pdo->commit();
            
            // Redirect to product list
            $success = "Product added successfully!";
            header("location: manage-products.php?success=" . urlencode($success));
            exit;
            
        } catch(PDOException $e) {
            // Roll back the transaction if something failed
            $pdo->rollBack();
            $errors[] = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | FASHION TRENDS</title>
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
                    <h1 class="dashboard-title">Add New Product</h1>
                </div>
                
                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <form class="product-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="form-section">
                        <h2 class="form-section-title">Basic Information</h2>
                        
                        <div class="form-group">
                            <label for="name">Product Name*</label>
                            <input type="text" id="name" name="name" placeholder="Enter product name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="category_id">Category*</label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" id="sku" name="sku" placeholder="Enter product SKU" value="<?php echo isset($_POST['sku']) ? htmlspecialchars($_POST['sku']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description*</label>
                            <textarea id="description" name="description" placeholder="Enter product description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="material">Material</label>
                            <input type="text" id="material" name="material" placeholder="Enter product material" value="<?php echo isset($_POST['material']) ? htmlspecialchars($_POST['material']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h2 class="form-section-title">Pricing & Inventory</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Price ($)*</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" placeholder="Enter product price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="old_price">Old Price ($) <small>(Optional)</small></label>
                                <input type="number" id="old_price" name="old_price" step="0.01" min="0" placeholder="Enter old price if on sale" value="<?php echo isset($_POST['old_price']) ? htmlspecialchars($_POST['old_price']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="quantity">Quantity*</label>
                                <input type="number" id="quantity" name="quantity" min="0" placeholder="Enter available quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : ''; ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status*</label>
                                <select id="status" name="status" required>
                                    <option value="active" <?php echo (!isset($_POST['status']) || $_POST['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="draft" <?php echo (isset($_POST['status']) && $_POST['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h2 class="form-section-title">Variations</h2>
                        
                        <div class="form-group">
                            <label>Available Sizes</label>
                            <div class="checkbox-group-horizontal">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-xs" name="sizes[]" value="XS" <?php echo (isset($_POST['sizes']) && in_array('XS', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-xs">XS</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-s" name="sizes[]" value="S" <?php echo (isset($_POST['sizes']) && in_array('S', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-s">S</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-m" name="sizes[]" value="M" <?php echo (isset($_POST['sizes']) && in_array('M', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-m">M</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-l" name="sizes[]" value="L" <?php echo (isset($_POST['sizes']) && in_array('L', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-l">L</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-xl" name="sizes[]" value="XL" <?php echo (isset($_POST['sizes']) && in_array('XL', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-xl">XL</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="size-xxl" name="sizes[]" value="XXL" <?php echo (isset($_POST['sizes']) && in_array('XXL', $_POST['sizes'])) ? 'checked' : ''; ?>>
                                    <label for="size-xxl">XXL</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Available Colors</label>
                            <div class="checkbox-group-horizontal">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-black" name="colors[]" value="Black" <?php echo (isset($_POST['colors']) && in_array('Black', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-black">Black</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-white" name="colors[]" value="White" <?php echo (isset($_POST['colors']) && in_array('White', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-white">White</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-red" name="colors[]" value="Red" <?php echo (isset($_POST['colors']) && in_array('Red', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-red">Red</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-blue" name="colors[]" value="Blue" <?php echo (isset($_POST['colors']) && in_array('Blue', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-blue">Blue</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-green" name="colors[]" value="Green" <?php echo (isset($_POST['colors']) && in_array('Green', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-green">Green</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="color-yellow" name="colors[]" value="Yellow" <?php echo (isset($_POST['colors']) && in_array('Yellow', $_POST['colors'])) ? 'checked' : ''; ?>>
                                    <label for="color-yellow">Yellow</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h2 class="form-section-title">Product Images</h2>
                        
                        <div class="image-upload" id="image-upload-container">
                            <div class="image-upload-icon">📷</div>
                            <div class="image-upload-text">Click to upload product images</div>
                            <div class="image-upload-subtext">You can upload multiple images. First image will be the main product image.</div>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" style="display: none;">
                        </div>
                        
                        <div class="image-preview" id="image-preview-container"></div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" name="status" value="draft" class="save-draft-btn">Save as Draft</button>
                        <button type="submit" name="status" value="active" class="publish-btn">Publish Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../script.js"></script>
    <script>
        // Image upload preview
        const imageUploadContainer = document.getElementById('image-upload-container');
        const imageInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        
        imageUploadContainer.addEventListener('click', () => {
            imageInput.click();
        });
        
        imageInput.addEventListener('change', function() {
            imagePreviewContainer.innerHTML = '';
            
            if (this.files) {
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'image-preview-item';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('div');
                        removeBtn.className = 'image-preview-remove';
                        removeBtn.innerHTML = '✕';
                        removeBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            previewItem.remove();
                        });
                        
                        previewItem.appendChild(img);
                        previewItem.appendChild(removeBtn);
                        imagePreviewContainer.appendChild(previewItem);
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
</body>
</html>
