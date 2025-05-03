document.addEventListener("DOMContentLoaded", () => {
    // Get product ID from URL
    const urlParams = new URLSearchParams(window.location.search)
    const productId = urlParams.get("id")
  
    if (productId) {
      // Find the product in our database
      const product = findProductById(Number.parseInt(productId))
  
      if (product) {
        // Update page with product details
        updateProductDetails(product)
      } else {
        console.error("Product not found")
      }
    }
  
    // Set up thumbnail image click handlers
    document.querySelectorAll(".thumbnail").forEach((thumbnail) => {
      thumbnail.addEventListener("click", function () {
        // Remove active class from all thumbnails
        document.querySelectorAll(".thumbnail").forEach((t) => t.classList.remove("active"))
  
        // Add active class to clicked thumbnail
        this.classList.add("active")
  
        // Update main image
        const mainImage = document.querySelector(".main-image img")
        const thumbnailImage = this.querySelector("img")
        mainImage.src = thumbnailImage.src
        mainImage.alt = thumbnailImage.alt
      })
    })
  
    // Set up quantity buttons
    const quantityInput = document.querySelector(".quantity-input")
    document.querySelectorAll(".quantity-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        const currentValue = Number.parseInt(quantityInput.value)
  
        if (this.textContent === "+") {
          quantityInput.value = currentValue + 1
        } else if (this.textContent === "-" && currentValue > 1) {
          quantityInput.value = currentValue - 1
        }
      })
    })
  
    // Set up color and size variation clicks
    document.querySelectorAll(".color-variation").forEach((color) => {
      color.addEventListener("click", function () {
        document.querySelectorAll(".color-variation").forEach((c) => c.classList.remove("active"))
        this.classList.add("active")
      })
    })
  
    document.querySelectorAll(".size-variation").forEach((size) => {
      size.addEventListener("click", function () {
        document.querySelectorAll(".size-variation").forEach((s) => s.classList.remove("active"))
        this.classList.add("active")
      })
    })
  
    // Set up tab switching
    document.querySelectorAll(".tab-item").forEach((tab, index) => {
      tab.addEventListener("click", function () {
        // Remove active class from all tabs
        document.querySelectorAll(".tab-item").forEach((t) => t.classList.remove("active"))
        document.querySelectorAll(".tab-pane").forEach((p) => p.classList.remove("active"))
  
        // Add active class to clicked tab and corresponding pane
        this.classList.add("active")
        document.querySelectorAll(".tab-pane")[index].classList.add("active")
      })
    })
  })
  
  // Function to find product by ID
  function findProductById(id) {
    // This would typically come from an API or database
    // Using the same product data from script.js
    const products = [
      {
        id: 1,
        name: "Casual Cotton T-Shirt",
        category: "Men",
        price: 29.99,
        oldPrice: 39.99,
        image: "/placeholder.svg?height=400&width=400",
        description: "Comfortable cotton t-shirt for everyday wear.",
        colors: ["Black", "White", "Blue", "Red"],
        sizes: ["S", "M", "L", "XL"],
        rating: 4,
        sku: "CCT-2024-001",
        availability: "In Stock (20 items)",
        material: "100% Cotton",
      },
      {
        id: 2,
        name: "Floral Summer Dress",
        category: "Women",
        price: 49.99,
        oldPrice: 69.99,
        image: "/placeholder.svg?height=400&width=400",
        description: "Beautiful floral dress perfect for summer days.",
        colors: ["Pink", "Blue", "Yellow"],
        sizes: ["XS", "S", "M", "L"],
        rating: 5,
        sku: "FSD-2024-001",
        availability: "In Stock (12 items)",
        material: "95% Cotton, 5% Elastane",
      },
      {
        id: 3,
        name: "Classic Denim Jacket",
        category: "Men",
        price: 79.99,
        oldPrice: null,
        image: "/placeholder.svg?height=400&width=400",
        description: "Timeless denim jacket that goes with everything.",
        colors: ["Blue", "Black"],
        sizes: ["S", "M", "L", "XL", "XXL"],
        rating: 4,
        sku: "CDJ-2024-001",
        availability: "In Stock (8 items)",
        material: "100% Cotton Denim",
      },
      {
        id: 4,
        name: "Casual Sneakers",
        category: "Accessories",
        price: 59.99,
        oldPrice: 89.99,
        image: "/placeholder.svg?height=400&width=400",
        description: "Comfortable sneakers for everyday wear.",
        colors: ["White", "Black", "Red", "Blue"],
        sizes: ["7", "8", "9", "10", "11", "12"],
        rating: 5,
        sku: "CSN-2024-001",
        availability: "In Stock (15 items)",
        material: "Synthetic Leather, Rubber Sole",
      },
      {
        id: 5,
        name: "Summer Straw Hat",
        category: "Accessories",
        price: 24.99,
        oldPrice: null,
        image: "/placeholder.svg?height=400&width=400",
        description: "Stylish straw hat for sun protection.",
        colors: ["Natural", "Black", "White"],
        sizes: ["One Size"],
        rating: 4,
        sku: "SSH-2024-001",
        availability: "In Stock (25 items)",
        material: "100% Natural Straw",
      },
      {
        id: 6,
        name: "Slim Fit Jeans",
        category: "Men",
        price: 69.99,
        oldPrice: null,
        image: "/placeholder.svg?height=400&width=400",
        description: "Modern slim fit jeans for a stylish look.",
        colors: ["Blue", "Black", "Gray"],
        sizes: ["28", "30", "32", "34", "36"],
        rating: 4,
        sku: "SFJ-2024-001",
        availability: "In Stock (18 items)",
        material: "98% Cotton, 2% Elastane",
      },
      {
        id: 10,
        name: "Formal Cotton Shirt",
        category: "Men",
        price: 39.99,
        oldPrice: 49.99,
        image: "/placeholder.svg?height=400&width=400",
        description: "Elegant formal shirt for business or special occasions.",
        colors: ["White", "Blue", "Black", "Pink"],
        sizes: ["S", "M", "L", "XL", "XXL"],
        rating: 4,
        sku: "FCS-2024-001",
        availability: "In Stock (22 items)",
        material: "100% Cotton",
      },
    ]
  
    return products.find((product) => product.id === id)
  }
  
  // Function to update product details on the page
  function updateProductDetails(product) {
    // Update page title
    document.title = `${product.name} | FASHION TRENDS`
  
    // Update breadcrumb
    const breadcrumbCategory = document.querySelector(".breadcrumb a:nth-child(3)")
    breadcrumbCategory.textContent = product.category
    breadcrumbCategory.href = `${product.category.toLowerCase()}.html`
  
    document.querySelector(".breadcrumb span:last-child").textContent = product.name
  
    // Update product details
    document.querySelector(".product-category").textContent = `${product.category} / ${product.name.split(" ")[0]}`
    document.querySelector(".product-title").textContent = product.name
  
    // Update rating
    const ratingStars = "★".repeat(product.rating) + "☆".repeat(5 - product.rating)
    document.querySelector(".rating-stars").textContent = ratingStars
  
    // Update price
    document.querySelector(".current-price-details").textContent = `$${product.price.toFixed(2)}`
  
    if (product.oldPrice) {
      document.querySelector(".old-price-details").textContent = `$${product.oldPrice.toFixed(2)}`
      document.querySelector(".old-price-details").style.display = "inline-block"
  
      // Calculate discount percentage
      const discountPercentage = Math.round(((product.oldPrice - product.price) / product.oldPrice) * 100)
      document.querySelector(".discount-badge").textContent = `-${discountPercentage}%`
      document.querySelector(".discount-badge").style.display = "inline-block"
    } else {
      document.querySelector(".old-price-details").style.display = "none"
      document.querySelector(".discount-badge").style.display = "none"
    }
  
    // Update description
    document.querySelector(".product-description p").textContent = product.description
  
    // Update meta information
    document.querySelector(".meta-item:nth-child(1) .meta-value").textContent = product.sku
    document.querySelector(".meta-item:nth-child(2) .meta-value").textContent = product.availability
    document.querySelector(".meta-item:nth-child(3) .meta-value").textContent = product.material
  
    // Update main image
    document.querySelector(".main-image img").src = product.image
    document.querySelector(".main-image img").alt = product.name
  
    // Update thumbnail images (would need actual different images in a real implementation)
    document.querySelectorAll(".thumbnail img").forEach((img, index) => {
      img.src = product.image.replace("400&width=400", "80&width=80")
      img.alt = `${product.name} - View ${index + 1}`
    })
  
    // Update tab content
    document.querySelector(".tab-pane.active p:first-child").textContent = product.description
  }
  