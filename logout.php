<?php
session_start();
session_unset();  // Unset all session variables
session_destroy(); // Destroy the session
echo "<script>alert('Logout!!!');</script>";
// Redirect to login page
header("Location: Login1/login.php");
exit();
?>