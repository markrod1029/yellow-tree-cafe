<?php
session_start();
require_once(__DIR__ . '/../init.php'); // Database connection

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query para hanapin ang user sa database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) >= 1) {
        $row = mysqli_fetch_assoc($query);

        // I-verify ang password
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role']; // Set role sa session

            if ($row['role'] == 'admin') {
                $_SESSION['admin'] = $row['id'];
                header('location: ../../index.php'); 
			} else if ($row['role'] == 'staff') {
				$_SESSION['staff'] = $row['id'];
				header('location: ../../index.php'); 
			} 
			else {
				$_SESSION['error'] = 'Invalid account';
				header('location: ../../index.php');
            }
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password';
        }
    } else {
        $_SESSION['error'] = 'Cannot find account with that email';
    }
} else {
    $_SESSION['error'] = 'Please login first';
}

// Redirect back to login page kung may error
header('location: ../../index.php'); 

exit();
?>
