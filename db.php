<?php
// Database Connection File: db.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "housingsociety";

// Establish database connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
