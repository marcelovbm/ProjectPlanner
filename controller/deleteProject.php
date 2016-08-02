<?php
session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$nameProject = $_POST['name'];

$mysqli->query("UPDATE Employee
				SET limiteProjetos = '0'
				WHERE User_email = '$userName'
				AND Project_NameProject = '$nameProject'");

$mysqli->query("DELETE FROM `Project`
				WHERE NameProject = '$nameProject'
				AND User_email = '$userName'");

$mysqli->close();
?>