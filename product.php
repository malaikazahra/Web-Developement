<?php
$conn = new mysqli("localhost", "root", "", "mysports");
$products = $conn->query("SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>SportEase - Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .big-heading {
      font-size: 48px;
      text-align: center;
      margin: 40px 0 20px;
      font-weight: bold;
      color: #212529;
    }
    .product-card {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 20px;
      transition: transform 0.2s ease;
      background-color: white;
      height: 100%;
      cursor: default;
    }
    .product-card:hover {
      transform: scale(1.03);
    }
    .product-img {
      max-width: 100%;
      height: 180px;
      object-fit: contain;
      margin-bottom: 15px;
      cursor: pointer; /* pointer cursor for clickable images */
    }
    footer {
      background-color: #212529;
      color: white;
      padding: 20px;
      text-align: center;
      margin-top: 40px;
    }
    header {
      background-color: #212529;
      padding: 10px;
      text-align: center;
      font-size: 36px;
      color: white;
    }
    .cart-count {
      background: red;
      color: white;
      font-size: 12px;
      padding: 2px 6px;
      border-radius: 50%;
      position: absolute;
      top: -5px;
      right: -10px;
    }
    .search-bar {
      width: 300px;
    }
    /* Cart item qty buttons */
    .qty-controls button {
      min-width: 30px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <header>
    Step Up Your Game with Quality Equipment
  </header>

 
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark position-relative">
    <div class="container">
      <a class="navbar-brand" href="index.html">SportEase</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="booot.html">About Us</a>
          </li>
		   <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
        <form class="d-flex" role="search" onsubmit="event.preventDefault(); searchProducts();">
          <input class="form-control me-2 search-bar" type="search" id="searchInput" placeholder="Search products...">
          <button class="btn btn-outline-light" type="button" onclick="searchProducts()">Search</button>
        </form>
        <div class="position-relative ms-3">
          <button class="btn btn-outline-warning position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
            🛒 <span class="cart-count" id="cartCount">0</span>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Products Section -->
  <div class="container mt-5">
    <h1 class="big-heading">Cricket Products</h1>
    <div class="row g-4" id="productContainer">

   
	<?php while ($row = $products->fetch_assoc()): ?>
  <div class="col-md-4 product-item"
       data-name="<?= strtolower($row['name']) ?>"
       data-price="<?= $row['price'] ?>"
       data-desc="<?= htmlspecialchars($row['description']) ?>"
       data-img="<?= $row['image'] ?>">
       
    <div class="product-card text-center">
      <img src="<?= $row['image'] ?>" class="product-img" onclick="showProductDetails(this.parentElement.parentElement)" alt="<?= $row['name'] ?>">
      <h5 class="fw-bold"><?= $row['name'] ?></h5>
      <p class="text-muted">Rs.<?= $row['price'] ?></p>
      <p><?= $row['description'] ?></p>
      <button class="btn btn-outline-dark" onclick="addToCart('<?= $row['name'] ?>', <?= $row['price'] ?>)">Add to Cart</button>
    </div>
  </div>
<?php endwhile; ?>


  </div>

  <footer>
    ©️ 2025 SportEase | All Rights Reserved
  </footer>

  
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="cartModalLabel">Your Shopping Cart</h5>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul id="cartItems" class="list-group"></ul>
        </div>
        <div class="modal-footer d-flex justify-content-between align-items-center">
          <strong>Total: Rs. <span id="cartTotal">0</span></strong>
         <button type="button" class="btn btn-success" onclick="goToCheckout()">Checkout</button>

        </div>
      </div>
    </div>
  </div>
  
  <!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row">
        <div class="col-md-5 text-center">
          <img id="detailImg" src="" class="img-fluid rounded" style="max-height: 250px;" alt="Product Image">
        </div>
        <div class="col-md-7">
          <h4 id="detailName" class="fw-bold"></h4>
          <h5 id="detailPrice" class="text-success"></h5>
          <p id="detailDesc" class="mt-3"></p>
          <button class="btn btn-outline-dark mt-3" id="addToCartFromDetailsBtn">Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
</div>


 

 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let cart = {};

    function addToCart(name, price) {
      if (cart[name]) {
        cart[name].quantity += 1;
      } else {
        cart[name] = { price, quantity: 1 };
      }
      updateCartDisplay();
    }

    function updateCartDisplay() 
	{ 
      const cartItems = document.getElementById('cartItems');
      const cartCount = document.getElementById('cartCount');
      const cartTotal = document.getElementById('cartTotal');
      cartItems.innerHTML = '';
      let total = 0;
      let count = 0;

      for (const name in cart) 
      {
        const item = cart[name];
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        count += item.quantity;

        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';

        // Item name and price
        const itemInfo = document.createElement('div');
        itemInfo.innerHTML = `<strong>${name}</strong> - Rs.${item.price}`;

        // Quantity controls
        const qtyControls = document.createElement('div');
        qtyControls.className = 'qty-controls d-flex align-items-center';

        const minusBtn = document.createElement('button');
        minusBtn.className = 'btn btn-sm btn-outline-secondary me-2';
        minusBtn.textContent = '-';
        minusBtn.onclick = () => {
          if (cart[name].quantity > 1) {
            cart[name].quantity--;
          } else {
            delete cart[name];
          }
          updateCartDisplay();
        };

        const qtyDisplay = document.createElement('span');
        qtyDisplay.textContent = item.quantity;
        qtyDisplay.style.minWidth = '20px';
        qtyDisplay.style.textAlign = 'center';

        const plusBtn = document.createElement('button');
        plusBtn.className = 'btn btn-sm btn-outline-secondary ms-2';
        plusBtn.textContent = '+';
        plusBtn.onclick = () => {
          cart[name].quantity++;
          updateCartDisplay();
        };

        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.className = 'btn btn-sm btn-danger ms-3';
        removeBtn.textContent = 'Remove';
        removeBtn.onclick = () => {
          delete cart[name];
          updateCartDisplay();
        };

        qtyControls.appendChild(minusBtn);
        qtyControls.appendChild(qtyDisplay);
        qtyControls.appendChild(plusBtn);
        qtyControls.appendChild(removeBtn);

        // Total price for item
        const priceSpan = document.createElement('span');
        priceSpan.textContent = `Rs.${itemTotal}`;
        priceSpan.style.minWidth = '60px';
        priceSpan.style.textAlign = 'right';

        li.appendChild(itemInfo);
        li.appendChild(qtyControls);
        li.appendChild(priceSpan);

        cartItems.appendChild(li);
       }

      cartCount.textContent = count;
      cartTotal.textContent = total;
	  
	  localStorage.setItem('cart', JSON.stringify(cart));

    }  

    function searchProducts() 
	{
      const query = document.getElementById('searchInput').value.toLowerCase();
      const products = document.querySelectorAll('.product-item');
      products.forEach(product => {
        const name = product.dataset.name.toLowerCase();
        if (name.includes(query)) {
          product.style.display = '';
        } else {
          product.style.display = 'none';
        }
      });
    }

    // Show Product Details Modal on Image Click
    function showProductDetails(productElement) {
      const name = productElement.dataset.name;
      const price = productElement.dataset.price;
      const desc = productElement.dataset.desc;
      const img = productElement.dataset.img;

      document.getElementById('detailName').textContent = name;
      document.getElementById('detailPrice').textContent = 'Rs.' + price;
      document.getElementById('detailDesc').textContent = desc;
      document.getElementById('detailImg').src = img;

      // Store data on the Add to Cart button for convenience
      const addToCartBtn = document.getElementById('addToCartFromDetailsBtn');
      addToCartBtn.onclick = () => {
        addToCart(name, parseInt(price));
        const productModal = bootstrap.Modal.getInstance(document.getElementById('productDetailsModal'));
        productModal.hide();
      };

      // Show modal
      const productModal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
      productModal.show();
    }

    // Initialize cart display on page load (empty)
    updateCartDisplay();
	
function goToCheckout() {
  if (Object.keys(cart).length === 0) {
    alert("Your cart is empty. Please add items before checking out.");
    return;
  }

  localStorage.setItem('cart', JSON.stringify(cart));  // Save cart before moving
  window.location.href = "checkout.php"; 
}





 

  </script>
  
  
  

</body>
</html>
