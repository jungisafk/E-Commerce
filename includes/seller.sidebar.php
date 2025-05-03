<div class="dashboard-sidebar">
    <div class="dashboard-user">
        <div class="user-avatar"><?php echo substr($_SESSION['name'], 0, 1); ?></div>
        <div class="user-info">
            <div class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></div>
            <div class="user-role">Seller</div>
        </div>
    </div>
    
    <div class="dashboard-menu">
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>seller-dashboard.php" class="dashboard-menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'seller-dashboard.php' ? 'active' : ''; ?>">
            <span class="menu-icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>products/manage-products.php" class="dashboard-menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'manage-products.php' ? 'active' : ''; ?>">
            <span class="menu-icon">👕</span>
            <span>My Products</span>
        </a>
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>products/add-product.php" class="dashboard-menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'add-product.php' ? 'active' : ''; ?>">
            <span class="menu-icon">➕</span>
            <span>Add Product</span>
        </a>
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>orders/seller-orders.php" class="dashboard-menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'seller-orders.php' ? 'active' : ''; ?>">
            <span class="menu-icon">📦</span>
            <span>Orders</span>
        </a>
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>account/seller-profile.php" class="dashboard-menu-item <?php echo basename($_SERVER['PHP_SELF']) == 'seller-profile.php' ? 'active' : ''; ?>">
            <span class="menu-icon">👤</span>
            <span>Profile</span>
        </a>
        <a href="<?php echo isset($base_path) ? $base_path : ''; ?>auth/logout.php" class="dashboard-menu-item">
            <span class="menu-icon">🚪</span>
            <span>Logout</span>
        </a>
    </div>
</div>
