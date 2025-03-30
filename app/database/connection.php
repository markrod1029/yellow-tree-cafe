<?php
// Set time zone
date_default_timezone_set("Asia/Kolkata");

// Define the site root
// define('SITE_ROOT', 'http://localhost/');

// Database Information
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_NAME', 'yellow-tree');
define('DATABASE_PASS', '');

// Create database connection
$conn = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to UTF-8
mysqli_set_charset($conn, "utf8");
?>
