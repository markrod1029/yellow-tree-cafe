<?php
	session_start();
    require_once(__DIR__ . '/../init.php'); // Database connection

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location:../../index.php');
	} 
	
	$sql = "SELECT * FROM users WHERE id = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();

	
	
?>