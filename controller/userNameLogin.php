<?php

session_start();
include 'connection_mysql.php';

if (!isset($_SESSION['userName'])) {
	echo "erro";
} else {
	$userEmail = $_SESSION['userName'];
	$recebeUserName = $mysqli->query("SELECT userName
										FROM `User`
										WHERE email = '$userEmail'");
	$row = mysqli_fetch_array($recebeUserName);
	$userName = $row['userName'];
	echo $userName;
}

?>