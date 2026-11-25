<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: admin_login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SportEase Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
  <div class="d-flex justify-content-between mb-3">
  <h4>Welcome, <?= $_SESSION['admin']; ?></h4>
  <a href="admin_logout.php" class="btn btn-outline-danger">Logout</a>
</div>

    <h2 class="text-center">🛒 Add Product</h2>
    <form action="add_product.php" method="POST">
      <input type="text" name="name" class="form-control mb-2" placeholder="Product Name" required>
      <input type="number" name="price" class="form-control mb-2" placeholder="Price" required>
      <input type="text" name="image" class="form-control mb-2" placeholder="Image Filename (e.g. bat.jpg)" required>
      <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
      <button type="submit" class="btn btn-primary">Add Product</button>
    </form>

    <h3 class="mt-5">📦 Products List</h3>
    <table class="table table-bordered">
      <thead><tr><th>Name</th><th>Price</th><th>Image</th><th>Description</th><th>Action</th></tr></thead>
      <tbody>
        <?php
        $conn = new mysqli("localhost", "root", "", "mysports");
        $res = $conn->query("SELECT * FROM products");
        while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?= $row['name'] ?></td>
            <td>Rs.<?= $row['price'] ?></td>
            <td><img src="<?= $row['image'] ?>" width="50"></td>
            <td><?= $row['description'] ?></td>
            <td>
              <form action="delete_product.php" method="POST" onsubmit="return confirm('Delete this product?');">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
