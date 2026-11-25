<?php
session_start();

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = new mysqli("localhost", "root", "", "mysports");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM admins WHERE username='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['admin'] = $username;
      header("Location: admin.php");
      exit;
    } else {
      $login_error = "Incorrect password.";
    }
  } else {
    $login_error = "User not found.";
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card p-4">
          <h4 class="text-center mb-3">🔐 Admin Login</h4>

          <?php if (!empty($login_error)): ?>
            <div class="alert alert-danger"><?= $login_error ?></div>
          <?php endif; ?>

          <form action="admin_login.php" method="POST">
            <div class="mb-3">
              <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
