<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "mysports");

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $cartItems = $conn->real_escape_string($_POST['cartItems']);
    $totalAmount = $conn->real_escape_string($_POST['totalAmount']);

    $sql = "INSERT INTO orders (name, email, address, cart_items, total_amount) 
            VALUES ('$name', '$email', '$address', '$cartItems', '$totalAmount')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Order placed successfully!'); localStorage.clear(); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - SportEase</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Checkout</h2>
  <form id="checkoutForm" method="POST">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required />
    </div>
    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="3" required></textarea>
    </div>

    <input type="hidden" name="cartItems" id="cartItemsInput" />
    <input type="hidden" name="totalAmount" id="totalAmountInput" />

    <button type="submit" class="btn btn-success">Place Order</button>
  </form>
</div>

<script>
  const cart = JSON.parse(localStorage.getItem('cart')) || {};
  let items = [];
  let total = 0;

  for (const name in cart) {
    const item = cart[name];
    items.push(`${name} x${item.quantity}`);
    total += item.price * item.quantity;
  }

  document.getElementById('cartItemsInput').value = items.join(', ');
  document.getElementById('totalAmountInput').value = total.toFixed(2);
</script>

</body>
</html>
