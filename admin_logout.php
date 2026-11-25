<?php
session_start();
session_destroy(); // remove session
header("Location: admin_login.php"); // redirect to login
exit;
?>
