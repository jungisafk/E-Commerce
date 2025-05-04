// Search functionality

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
    {
      id: 9,
      name: "Women's Yoga Pants",
      category: "Women",
      price: 39.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Comfortable yoga pants for workout or casual wear.",
      colors: ["Black", "Gray", "Blue", "Purple"],
      sizes: ["XS", "S", "M", "L", "XL"],
      rating: 4,
    },
    {
      id: 10,
      name: "Men's Formal Shirt",
      category: "Men",
      price: 54.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Elegant formal shirt for business or special occasions.",
      colors: ["White", "Blue", "Black", "Pink"],
      sizes: ["S", "M", "L", "XL", "XXL"],
      rating: 5,
    },
    {
      id: 11,
      name: "Women's Winter Coat",
      category: "Women",
      price: 129.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Warm and stylish winter coat with faux fur collar.",
      colors: ["Black", "Navy", "Burgundy"],
      sizes: ["S", "M", "L", "XL"],
      rating: 5,
    },
    {
      id: 12,
      name: "Kids Winter Boots",
      category: "Kids",
      price: 49.99,
      image: "/placeholder.svg?height=300&width=250",
      description: "Waterproof winter boots for kids.",
      colors: ["Black", "Pink", "Blue"],
      sizes: ["11", "12", "13", "1", "2", "3"],
      rating: 4,
    },
  ]
  
  // Toggle search bar visibility
  function toggleSearchBar() {
    const searchBar = document.querySelector(".search-bar")
    searchBar.classList.toggle("active")
  
    if (searchBar.classList.contains("active")) {
      document.getElementById("search-input").focus()
    }
  }
  
  // Initialize search functionality
  document.addEventListener("DOMContentLoaded", () => {
    // Add search bar styles
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
  
        // Filter products based on search query
        const filteredProducts = products
          .filter((product) => {
            return (
              product.name.toLowerCase().includes(query) ||
              product.category.toLowerCase().includes(query) ||
              product.description.toLowerCase().includes(query)
            )
          })
          .slice(0, 5) // Limit to 5 suggestions
  
        if (filteredProducts.length > 0) {
          searchSuggestions.innerHTML = ""
  
          filteredProducts.forEach((product) => {
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
  
      // Handle search form submission
      const searchForm = document.getElementById("search-form")
      if (searchForm) {
        searchForm.addEventListener("submit", (e) => {
          const query = searchInput.value.trim()
          if (query.length < 2) {
            e.preventDefault()
            return
          }
        })
      }
    }
  
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
  
        // Filter products based on search query
        const filteredProducts = products.filter((product) => {
          return (
            product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
            product.category.toLowerCase().includes(searchQuery.toLowerCase()) ||
            product.description.toLowerCase().includes(searchQuery.toLowerCase())
          )
        })
  
        // Update results count
        const resultsCountElement = document.getElementById("results-count")
        if (resultsCountElement) {
          resultsCountElement.textContent = `Found ${filteredProducts.length} products`
        }
  
        // Display search results
        const searchResultsContainer = document.getElementById("search-results")
        const noResultsElement = document.getElementById("no-results")
  
        if (searchResultsContainer) {
          if (filteredProducts.length > 0) {
            searchResultsContainer.innerHTML = ""
  
            filteredProducts.forEach((product) => {
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
  })
  