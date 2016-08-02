<?php
session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$employeeEmail = $_POST['employeeEmail'];

$recebeTabela = $mysqli->query("SELECT Project_NameProject
								FROM Employee
								WHERE employeeEmail = '$employeeEmail'
								AND User_email = '$userName'");

$row = $recebeTabela->fetch_array(MYSQLI_ASSOC);

if ($row['Project_NameProject'] != '') {
	echo 'User is in a project!';
} else {
	$mysqli->query("DELETE FROM Employee
					WHERE employeeEmail = '$employeeEmail'
					AND User_email = '$userName'");
}

$recebeTabela->close();
$mysqli->close();
?>