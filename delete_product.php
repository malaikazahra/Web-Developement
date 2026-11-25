<?php
$conn = new mysqli("localhost", "root", "", "mysports");
if ($conn->connect_error) die("Connection failed");
$id = $_POST['id'];
$conn->query("DELETE FROM products WHERE id=$id");
$conn->close();
header("Location: admin.php");
exit;
?>