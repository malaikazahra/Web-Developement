<?php
$conn = new mysqli("localhost", "root", "", "mysports");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'];
$desc = $_POST['description'];

$sql = "INSERT INTO products (name, price, image, description) VALUES ('$name', '$price', '$image', '$desc')";
$conn->query($sql);
$conn->close();

header("Location: admin.php");
exit;
?>