<?php
// If session is not started, start it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$user_role = $is_logged_in ? $_SESSION['role'] : '';
$user_name = $is_logged_in ? $_SESSION['name'] : '';

// Get cart count from session
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// Get current page for active navigation
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<header>
    <div class="container header-container">
        <div class="logo"><a href="index.php" style="text-decoration: none; color: inherit;">FASHION<span>TRENDS</span></a></div>
        
        <div class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">
            ☰
        </div>
        
        <nav class="nav-links">
            <a href="index.php" <?php echo $current_page === 'index' ? 'class="active"' : ''; ?>>Home</a>
            <a href="men.php" <?php echo $current_page === 'men' ? 'class="active"' : ''; ?>>Men</a>
            <a href="women.php" <?php echo $current_page === 'women' ? 'class="active"' : ''; ?>>Women</a>
            <a href="kids.php" <?php echo $current_page === 'kids' ? 'class="active"' : ''; ?>>Kids</a>
            <a href="accessories.php" <?php echo $current_page === 'accessories' ? 'class="active"' : ''; ?>>Accessories</a>
            <a href="sale.php" <?php echo $current_page === 'sale' ? 'class="active"' : ''; ?>>Sale</a>
        </nav>
        
        <div class="header-icons">
            <div class="icon search-icon" onclick="toggleSearchBar()">🔍</div>
            <div class="icon" onclick="window.location.href='<?php echo $is_logged_in ? ($user_role === 'seller' ? 'seller-dashboard.php' : 'buyer-dashboard.php') : 'login.php'; ?>'">
                👤
                <?php if($is_logged_in): ?>
                    <span class="user-badge <?php echo $user_role; ?>-badge"><?php echo ucfirst($user_role); ?></span>
                <?php endif; ?>
            </div>
            <div class="icon" onclick="window.location.href='wishlist.php'">💖</div>
            <div class="icon" onclick="window.location.href='cart.php'">
                🛒
                <span class="cart-count"><?php echo $cart_count; ?></span>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="container">
            <form id="search-form" action="search.php" method="get">
                <input type="text" id="search-input" name="q" placeholder="Search for products..." autocomplete="off">
                <button type="submit" class="search-btn">Search</button>
                <div class="close-search" onclick="toggleSearchBar()">✕</div>
            </form>
            <div class="search-suggestions" id="search-suggestions"></div>
        </div>
    </div>
</header>
