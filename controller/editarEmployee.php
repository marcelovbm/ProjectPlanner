<?php
include 'connection_mysql.php';

session_start();

$userName = $_SESSION['userName'];

$inputNameEmployee = $_POST['inputNameEmployee'];
$inputEmailEmployee = $_POST['inputEmailEmployee'];
$inputEmployeeFunction = $_POST['inputEmployeeFunction'];

$recebeTabela = $mysqli->query("SELECT limiteProjetos
								FROM Employee
								WHERE User_email = '$userName'
								AND employeeEmail = '$inputEmailEmployee'");

$row = $recebeTabela->fetch_array(MYSQLI_ASSOC);

if ($row['limiteProjetos'] > 0) {
	echo 'Usuário está relacionado a um projeto!';
} else {
	$mysqli->query("UPDATE Employee
					SET employeeName = '$inputNameEmployee', employeeFunction = '$inputEmployeeFunction'
					WHERE employeeEmail = '$inputEmailEmployee'
					AND User_email = '$userName'");
}

$recebeTabela->close();
$mysqli->close();
?>