<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli("localhost", "root", "", "mysports");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            if ($stmt->execute()) {
                $success = "Message sent successfully!";
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Prepare failed: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact - SportEase</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #222;
      color: white;
      padding: 20px;
      font-family: Arial;
    }
    .form-control {
      background: #444;
      color: white;
      border: 1px solid #666;
    }
    .form-control:focus {
      border-color: #f0c330;
      box-shadow: 0 0 5px rgba(240,195,48,0.5);
    }
    .btn {
      background: #f0c330;
      border: none;
      font-weight: bold;
      color: #000;
    }
	 nav ul {
      list-style: none;
     
      gap: 30px;
	  color: white;
    }
    .message {
      margin-top: 20px;
    }
  </style>
</head>
<body>
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
     
      <div class="collapse navbar-collapse" id="navbarNav">
       
     <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="booot.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="contact.html">Contact</a>
          </li>
        </ul>
       
      </div>
    </div>
  </nav>

  <div class="container">
    <h1 class="text-center">Contact Us</h1>

    <?php if ($success): ?>
      <div class="alert alert-success message text-center"><?= $success ?></div>
    <?php elseif ($error): ?>
      <div class="alert alert-danger message text-center"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email">
      </div>
      <div class="mb-3">
        <label class="form-label">Subject</label>
        <input type="text" class="form-control" name="subject" placeholder="Subject">
      </div>
      <div class="mb-3">
        <label class="form-label">Message</label>
        <textarea class="form-control" name="message" rows="5" placeholder="Your message"></textarea>
      </div>
      <button type="submit" class="btn btn-warning w-100">Send Message</button>
    </form>
  </div>

</body>
</html>
