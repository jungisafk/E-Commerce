<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3>FASHION TRENDS</h3>
                <p>Discover the latest fashion trends and get inspired by our collection of stylish clothing and accessories.</p>
                <div class="footer-social">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Shopping</h3>
                <ul class="footer-links">
                    <li><a href="men.php">Men's Clothing</a></li>
                    <li><a href="women.php">Women's Clothing</a></li>
                    <li><a href="kids.php">Kid's Clothing</a></li>
                    <li><a href="accessories.html">Accessories</a></li>
                    <li><a href="shop.html">New Arrivals</a></li>
                    <li><a href="sale.html">Sale</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Information</h3>
                <ul class="footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="faq.php">FAQs</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li>123 Fashion Street, New York, NY 10001</li>
                    <li>Email: info@fashiontrends.com</li>
                    <li>Phone: +1 (123) 456-7890</li>
                    <li>Hours: Mon-Fri 9am-6pm</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> FASHION TRENDS. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Add Font Awesome for better icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- JavaScript -->
<script>
    // Function to toggle search bar
    function toggleSearchBar() {
        const searchBar = document.querySelector('.search-bar');
        searchBar.classList.toggle('active');
        
        if (searchBar.classList.contains('active')) {
            document.getElementById('search-input').focus();
        }
    }
</script>
