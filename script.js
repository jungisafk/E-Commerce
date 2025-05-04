// Main JavaScript file for FASHION TRENDS e-commerce website

document.addEventListener("DOMContentLoaded", () => {
    // Initialize cart from localStorage
    initializeCart()
  
    // Initialize product filters if on shop page
    if (document.querySelector(".filters")) {
      initializeFilters()
    }
  
    // Initialize form validation if forms exist
    if (document.querySelector("form")) {
      initializeFormValidation()
    }
  
    // Initialize product details page functionality
    if (document.querySelector(".product-details")) {
      initializeProductDetails()
    }
  
    // Initialize mobile menu toggle
    const menuToggle = document.querySelector(".menu-toggle")
    if (menuToggle) {
      menuToggle.addEventListener("click", () => {
        document.querySelector(".nav-links").classList.toggle("active")
      })
    }
  
    // Initialize search functionality
    initializeSearch()
  })
  
  // Dummy functions to prevent errors. Replace with actual implementations.
  function initializeFilters() {
    console.log("initializeFilters function called")
  }
  
  function initializeFormValidation() {
    console.log("initializeFormValidation function called")
  }
  
  function initializeProductDetails() {
    console.log("initializeProductDetails function called")
  }
  
  // =============== CART OPERATIONS ===============
  
  // Cart object to store items and methods
  const cart = {
    items: [],
    total: 0,
  
    // Add item to cart
    addItem: function (id, name, price, image, quantity = 1, size = "M", color = "Default") {
      // Check if item already exists in cart
      const existingItemIndex = this.items.findIndex(
        (item) => item.id === id && item.size === size && item.color === color,
      )
  
      if (existingItemIndex > -1) {
        // Update quantity if item exists
        this.items[existingItemIndex].quantity += quantity
      } else {
        // Add new item if it doesn't exist
        this.items.push({
          id,
          name,
          price,
          image,
          quantity,
          size,
          color,
        })
      }
  
      // Update cart
      this.updateCart()
  
      // Show notification
      showNotification(`${name} added to cart!`)
    },
  
    // Remove item from cart
    removeItem: function (index) {
      if (index > -1 && index < this.items.length) {
        const removedItem = this.items[index]
        this.items.splice(index, 1)
        this.updateCart()
        showNotification(`${removedItem.name} removed from cart!`)
      }
    },
  
    // Update item quantity
    updateQuantity: function (index, quantity) {
      if (index > -1 && index < this.items.length) {
        this.items[index].quantity = Number.parseInt(quantity)
        if (this.items[index].quantity < 1) {
          this.items[index].quantity = 1
        }
        this.updateCart()
      }
    },
  
    // Calculate cart total
    calculateTotal: function () {
      this.total = this.items.reduce((total, item) => {
        return total + item.price * item.quantity
      }, 0)
      return this.total
    },
  
    // Get cart item count
    getItemCount: function () {
      return this.items.reduce((count, item) => {
        return count + item.quantity
      }, 0)
    },
  
    // Update cart UI and localStorage
    updateCart: function () {
      // Update cart count in header
      const cartCount = document.querySelector(".cart-count")
      if (cartCount) {
        cartCount.textContent = this.getItemCount()
      }
  
      // Update cart page if on cart page
      if (document.querySelector(".cart-items")) {
        this.renderCartItems()
      }
  
      // Update cart summary if on cart or checkout page
      if (document.querySelector(".cart-summary") || document.querySelector(".order-summary")) {
        this.renderCartSummary()
      }
  
      // Save cart to localStorage
      localStorage.setItem("fashionTrendsCart", JSON.stringify(this.items))
    },
  
    // Render cart items on cart page
    renderCartItems: function () {
      const cartItemsContainer = document.querySelector(".cart-items")
      if (!cartItemsContainer) return
  
      // Clear current items
      cartItemsContainer.innerHTML = ""
  
      if (this.items.length === 0) {
        cartItemsContainer.innerHTML = `
                  <div class="empty-cart" style="text-align: center; padding: 40px;">
                      <div style="font-size: 24px; margin-bottom: 20px;">Your cart is empty</div>
                      <a href="shop.php" class="btn">Continue Shopping</a>
                  </div>
              `
        return
      }
  
      // Add each item to the cart
      this.items.forEach((item, index) => {
        const cartItemElement = document.createElement("div")
        cartItemElement.className = "cart-item"
        cartItemElement.innerHTML = `
                  <div class="item-image">
                      <img src="${item.image}" alt="${item.name}">
                  </div>
                  <div class="item-details">
                      <h3>${item.name}</h3>
                      <p>Size: ${item.size} | Color: ${item.color}</p>
                  </div>
                  <div class="item-price">$${item.price.toFixed(2)}</div>
                  <div class="item-quantity">
                      <div class="quantity-btn-cart" data-action="decrease" data-index="${index}">-</div>
                      <input type="number" value="${item.quantity}" min="1" class="quantity-input-cart" data-index="${index}">
                      <div class="quantity-btn-cart" data-action="increase" data-index="${index}">+</div>
                  </div>
                  <div class="item-total">$${(item.price * item.quantity).toFixed(2)}</div>
                  <div class="remove-item" data-index="${index}">✕</div>
              `
  
        cartItemsContainer.appendChild(cartItemElement)
      })
  
      // Add event listeners to quantity buttons and remove buttons
      document.querySelectorAll(".quantity-btn-cart").forEach((btn) => {
        btn.addEventListener("click", function () {
          const index = Number.parseInt(this.getAttribute("data-index"))
          const action = this.getAttribute("data-action")
          const currentQuantity = cart.items[index].quantity
  
          if (action === "increase") {
            cart.updateQuantity(index, currentQuantity + 1)
          } else if (action === "decrease" && currentQuantity > 1) {
            cart.updateQuantity(index, currentQuantity - 1)
          }
        })
      })
  
      document.querySelectorAll(".quantity-input-cart").forEach((input) => {
        input.addEventListener("change", function () {
          const index = Number.parseInt(this.getAttribute("data-index"))
          cart.updateQuantity(index, this.value)
        })
      })
  
      document.querySelectorAll(".remove-item").forEach((btn) => {
        btn.addEventListener("click", function () {
          const index = Number.parseInt(this.getAttribute("data-index"))
          cart.removeItem(index)
        })
      })
    },
  
    // Render cart summary on cart and checkout pages
    renderCartSummary: function () {
      // Calculate total
      this.calculateTotal()
  
      // Update subtotal and total on cart page
      const cartSummary = document.querySelector(".cart-summary")
      if (cartSummary) {
        const subtotalElement = cartSummary.querySelector(".summary-row:first-child .summary-value")
        const totalElement = cartSummary.querySelector(".summary-total .summary-value")
  
        if (subtotalElement) subtotalElement.textContent = `$${this.total.toFixed(2)}`
        if (totalElement) totalElement.textContent = `$${this.total.toFixed(2)}`
      }
  
      // Update order summary on checkout page
      const orderSummary = document.querySelector(".order-summary")
      if (orderSummary) {
        const orderItemsContainer = orderSummary.querySelector(".order-items")
        const subtotalElement = orderSummary.querySelector(".summary-row:first-child .summary-value")
        const totalElement = orderSummary.querySelector(".summary-total .summary-value")
  
        // Clear and render order items
        if (orderItemsContainer) {
          orderItemsContainer.innerHTML = ""
  
          this.items.forEach((item) => {
            const orderItemElement = document.createElement("div")
            orderItemElement.className = "order-item"
            orderItemElement.innerHTML = `
                          <div class="order-item-name">
                              <div class="item-quantity-badge">${item.quantity}</div>
                              <div>${item.name}</div>
                          </div>
                          <div class="order-item-price">$${(item.price * item.quantity).toFixed(2)}</div>
                      `
  
            orderItemsContainer.appendChild(orderItemElement)
          })
        }
  
        // Update subtotal and total
        if (subtotalElement) subtotalElement.textContent = `$${this.total.toFixed(2)}`
  
        // Calculate tax (8%)
        const tax = this.total * 0.08
        const taxElement = orderSummary.querySelector(".summary-row:nth-child(3) .summary-value")
        if (taxElement) taxElement.textContent = `$${tax.toFixed(2)}`
  
        // Update final total with tax
        if (totalElement) totalElement.textContent = `$${(this.total + tax).toFixed(2)}`
      }
    },
  }
  
  // Initialize cart from localStorage
  function initializeCart() {
    const savedCart = localStorage.getItem("fashionTrendsCart")
    if (savedCart) {
      cart.items = JSON.parse(savedCart)
      cart.updateCart()
    }
  
    // Add event listeners to "Add to Cart" buttons
    document.querySelectorAll(".add-to-cart, .add-to-cart-details").forEach((button) => {
      button.addEventListener("click", function (e) {
        e.preventDefault()
        e.stopPropagation()
  
        // Get product details
        let productElement = this.closest(".product")
  
        // If on product details page
        if (this.classList.contains("add-to-cart-details")) {
          productElement = document.querySelector(".product-details")
  
          // Get selected size and color
          const selectedSize = document.querySelector(".size-variation.active")?.textContent || "M"
          const selectedColor = document.querySelector(".color-variation.active")?.getAttribute("title") || "Default"
  
          // Get quantity
          const quantity = Number.parseInt(document.querySelector(".quantity-input").value) || 1
  
          // Get product details
          const productName = document.querySelector(".product-title").textContent
          const productPrice = Number.parseFloat(
            document.querySelector(".current-price-details").textContent.replace("$", ""),
          )
          const productImage = document.querySelector(".main-image img").getAttribute("src")
  
          // Add to cart
          cart.addItem(
            generateProductId(productName),
            productName,
            productPrice,
            productImage,
            quantity,
            selectedSize,
            selectedColor,
          )
        } else {
          // For product cards on home or shop page
          const productName = productElement.querySelector(".product-name").textContent
          const productPrice = Number.parseFloat(
            productElement.querySelector(".current-price").textContent.replace("$", ""),
          )
          const productImage = productElement.querySelector(".product-image img").getAttribute("src")
  
          // Add to cart with default options
          cart.addItem(generateProductId(productName), productName, productPrice, productImage)
        }
      })
    })
  }
  
  // =============== SEARCH FUNCTIONALITY ===============
  
  // Initialize search functionality
  function initializeSearch() {
    // Add search bar HTML if it doesn't exist
    if (!document.querySelector(".search-bar")) {
      const header = document.querySelector("header")
      const searchBarHTML = `
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
          `
      header.insertAdjacentHTML("beforeend", searchBarHTML)
  
      // Update search icon to toggle search bar
      const searchIcon = document.querySelector(".header-icons .icon:first-child")
      searchIcon.classList.add("search-icon")
      searchIcon.setAttribute("onclick", "toggleSearchBar()")
    }
  
    // Set up search input event listeners
    const searchInput = document.getElementById("search-input")
    const searchSuggestions = document.getElementById("search-suggestions")
  
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const query = this.value.trim().toLowerCase()
  
        if (query.length < 2) {
          searchSuggestions.style.display = "none"
          return
        }
  
        // Get product suggestions (in a real app, this would come from an API)
        const suggestions = getProductSuggestions(query)
  
        if (suggestions.length > 0) {
          searchSuggestions.innerHTML = ""
  
          suggestions.forEach((product) => {
            const suggestion = document.createElement("div")
            suggestion.className = "search-suggestion"
  
            // Highlight the matching text
            const highlightedName = product.name.replace(
              new RegExp(query, "gi"),
              (match) => `<span class="highlight">${match}</span>`,
            )
  
            suggestion.innerHTML = highlightedName
  
            suggestion.addEventListener("click", () => {
              window.location.href = `product-details.php?id=${product.id}`
            })
  
            searchSuggestions.appendChild(suggestion)
          })
  
          searchSuggestions.style.display = "block"
        } else {
          searchSuggestions.style.display = "none"
        }
      })
  
      // Hide suggestions when clicking outside
      document.addEventListener("click", (e) => {
        if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
          searchSuggestions.style.display = "none"
        }
      })
    }
  
    // Add search styles
    const styleSheet = document.createElement("style")
    styleSheet.textContent = `
          .search-bar {
              position: absolute;
              top: 100%;
              left: 0;
              width: 100%;
              background-color: white;
              box-shadow: 0 5px 15px rgba(0,0,0,0.1);
              padding: 20px 0;
              z-index: 100;
              display: none;
              transition: all 0.3s ease;
          }
  
          .search-bar.active {
              display: block;
          }
  
          .search-bar form {
              display: flex;
              position: relative;
          }
  
          .search-bar input {
              flex: 1;
              padding: 15px;
              border: 1px solid #e5e5e5;
              border-radius: 4px 0 0 4px;
              font-size: 16px;
          }
  
          .search-bar .search-btn {
              padding: 0 20px;
              background-color: #e83e8c;
              color: white;
              border: none;
              border-radius: 0 4px 4px 0;
              cursor: pointer;
              font-weight: 600;
          }
  
          .close-search {
              position: absolute;
              right: 70px;
              top: 50%;
              transform: translateY(-50%);
              cursor: pointer;
              font-size: 18px;
              color: #666;
          }
  
          .search-suggestions {
              position: absolute;
              top: 100%;
              left: 0;
              width: 100%;
              background-color: white;
              border: 1px solid #e5e5e5;
              border-top: none;
              border-radius: 0 0 4px 4px;
              max-height: 300px;
              overflow-y: auto;
              z-index: 101;
              display: none;
          }
  
          .search-suggestion {
              padding: 10px 15px;
              cursor: pointer;
              border-bottom: 1px solid #f5f5f5;
          }
  
          .search-suggestion:hover {
              background-color: #f9f9f9;
          }
  
          .search-suggestion .highlight {
              font-weight: bold;
              color: #e83e8c;
          }
      `
    document.head.appendChild(styleSheet)
  
    // Handle search results page
    if (window.location.pathname.includes("search.php")) {
      const urlParams = new URLSearchParams(window.location.search)
      const searchQuery = urlParams.get("q")
  
      if (searchQuery) {
        // Display search query
        const searchTermElement = document.getElementById("search-term")
        if (searchTermElement) {
          searchTermElement.textContent = searchQuery
        }
  
        // Get search results
        const searchResults = getSearchResults(searchQuery)
  
        // Update results count
        const resultsCountElement = document.getElementById("results-count")
        if (resultsCountElement) {
          resultsCountElement.textContent = `Found ${searchResults.length} products`
        }
  
        // Display search results
        const searchResultsContainer = document.getElementById("search-results")
        const noResultsElement = document.getElementById("no-results")
  
        if (searchResultsContainer) {
          if (searchResults.length > 0) {
            searchResultsContainer.innerHTML = ""
  
            searchResults.forEach((product) => {
              const productElement = document.createElement("div")
              productElement.className = "product"
              productElement.setAttribute("onclick", `window.location.href='product-details.php?id=${product.id}'`)
  
              productElement.innerHTML = `
                              <div class="product-image">
                                  <img src="${product.image}" alt="${product.name}">
                              </div>
                              <div class="product-info">
                                  <h3 class="product-name">${product.name}</h3>
                                  <div class="product-price">
                                      <div class="current-price">$${product.price.toFixed(2)}</div>
                                  </div>
                                  <div class="product-rating">${"★".repeat(product.rating)}${"☆".repeat(5 - product.rating)}</div>
                                  <div class="product-actions">
                                      <button class="btn add-to-cart">Add to Cart</button>
                                      <div class="wishlist">❤️</div>
                                  </div>
                              </div>
                          `
  
              searchResultsContainer.appendChild(productElement)
            })
  
            searchResultsContainer.style.display = "grid"
            if (noResultsElement) {
              noResultsElement.style.display = "none"
            }
          } else {
            searchResultsContainer.style.display = "none"
            if (noResultsElement) {
              noResultsElement.style.display = "block"
            }
          }
        }
      }
    }
  }
  
  // Toggle search bar visibility
  function toggleSearchBar() {
    const searchBar = document.querySelector(".search-bar")
    searchBar.classList.toggle("active")
  
    if (searchBar.classList.contains("active")) {
      document.getElementById("search-input").focus()
    }
  }
  
  // Product database (in a real application, this would come from a server/database)
  const products = [
    {
      id: 1,
      name: "Casual Cotton T-Shirt",
      category: "Men",
      price: 29.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Comfortable cotton t-shirt for everyday wear.",
      colors: ["Black", "White", "Blue", "Red"],
      sizes: ["S", "M", "L", "XL"],
      rating: 4,
    },
    {
      id: 2,
      name: "Floral Summer Dress",
      category: "Women",
      price: 49.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Beautiful floral dress perfect for summer days.",
      colors: ["Blue", "Pink", "Yellow"],
      sizes: ["XS", "S", "M", "L"],
      rating: 5,
    },
    {
      id: 3,
      name: "Classic Denim Jacket",
      category: "Men",
      price: 79.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Timeless denim jacket that goes with everything.",
      colors: ["Blue", "Black"],
      sizes: ["S", "M", "L", "XL", "XXL"],
      rating: 4,
    },
    {
      id: 4,
      name: "Casual Sneakers",
      category: "Accessories",
      price: 59.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Comfortable sneakers for everyday wear.",
      colors: ["White", "Black", "Red", "Blue"],
      sizes: ["7", "8", "9", "10", "11", "12"],
      rating: 5,
    },
    {
      id: 5,
      name: "Summer Straw Hat",
      category: "Accessories",
      price: 24.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Stylish straw hat for sun protection.",
      colors: ["Natural", "Black", "White"],
      sizes: ["One Size"],
      rating: 4,
    },
    {
      id: 6,
      name: "Slim Fit Jeans",
      category: "Men",
      price: 69.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Modern slim fit jeans for a stylish look.",
      colors: ["Blue", "Black", "Gray"],
      sizes: ["28", "30", "32", "34", "36"],
      rating: 4,
    },
    {
      id: 7,
      name: "Leather Handbag",
      category: "Accessories",
      price: 89.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Elegant leather handbag with multiple compartments.",
      colors: ["Brown", "Black", "Red"],
      sizes: ["One Size"],
      rating: 5,
    },
    {
      id: 8,
      name: "Kids Cartoon T-Shirt",
      category: "Kids",
      price: 19.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Fun cartoon print t-shirt for kids.",
      colors: ["Blue", "Red", "Yellow", "Green"],
      sizes: ["3-4Y", "5-6Y", "7-8Y", "9-10Y"],
      rating: 4,
    },
  ]
  
  // Get product suggestions based on search query
  function getProductSuggestions(query) {
    return products
      .filter((product) => {
        return (
          product.name.toLowerCase().includes(query) ||
          product.category.toLowerCase().includes(query) ||
          product.description.toLowerCase().includes(query)
        )
      })
      .slice(0, 5) // Limit to 5 suggestions
  }
  
  // Get search results based on search query
  function getSearchResults(query) {
    return products.filter((product) => {
      return (
        product.name.toLowerCase().includes(query.toLowerCase()) ||
        product.category.toLowerCase().includes(query.toLowerCase()) ||
        product.description.toLowerCase().includes(query.toLowerCase())
      )
    })
  }
  
  // Generate a simple product ID from name
  function generateProductId(name) {
    return name.toLowerCase().replace(/[^a-z0-9]/g, "-")
  }
  
  // Show notification
  function showNotification(message) {
    // Create notification element if it doesn't exist
    let notification = document.querySelector(".notification")
    if (!notification) {
      notification = document.createElement("div")
      notification.className = "notification"
      document.body.appendChild(notification)
  
      // Add styles
      notification.style.position = "fixed"
      notification.style.bottom = "20px"
      notification.style.right = "20px"
      notification.style.backgroundColor = "#e83e8c"
      notification.style.color = "white"
      notification.style.padding = "15px 20px"
      notification.style.borderRadius = "4px"
      notification.style.boxShadow = "0 4px 8px rgba(0,0,0,0.1)"
      notification.style.zIndex = "1000"
      notification.style.transition = "transform 0.3s, opacity 0.3s"
      notification.style.transform = "translateY(100px)"
      notification.style.opacity = "0"
    }
  
    // Set message and show notification
    notification.textContent = message
    notification.style.transform = "translateY(0)"
    notification.style.opacity = "1"
  
    // Hide notification after 3 seconds
    setTimeout(() => {
      notification.style.transform = "translateY(100px)"
      notification.style.opacity = "0"
    }, 3000)
  }
  
  // Update footer links to point to the new category pages
  document.addEventListener("DOMContentLoaded", () => {
    // Update all footer links to point to the correct category pages
    const footerLinks = document.querySelectorAll(".footer-links a")
    footerLinks.forEach((link) => {
      if (link.textContent.includes("Men's")) {
        link.href = "men.php"
      } else if (link.textContent.includes("Women's")) {
        link.href = "women.php"
      } else if (link.textContent.includes("Kid's")) {
        link.href = "kids.php"
      } else if (link.textContent.includes("Accessories")) {
        link.href = "accessories.php"
      } else if (link.textContent.includes("Sale")) {
        link.href = "sale.php"
      }
    })
  
    // Make logo clickable
    const logo = document.querySelector(".logo")
    if (logo && !logo.querySelector("a")) {
      const logoText = logo.innerHTML
      logo.innerHTML = `<a href="index.php" style="text-decoration: none; color: inherit;">${logoText}</a>`
    }
  })
  