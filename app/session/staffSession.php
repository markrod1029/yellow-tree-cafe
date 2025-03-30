<?php
	session_start();
    require_once(__DIR__ . '/../init.php'); // Database connection

	if(!isset($_SESSION['staff']) || trim($_SESSION['staff']) == ''|| !isset($_SESSION['staff']) || trim($_SESSION['staff']) == ''){
		header('location: ../../index.php');
	} 
	
	$sql = "SELECT * FROM users WHERE id = '".$_SESSION['staff']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();

	
	
?>