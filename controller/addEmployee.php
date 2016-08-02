<?php
session_start();
include 'connection_mysql.php';

$User_email = $_SESSION['userName'];

$employeeName = $_POST['inputNameEmployee'];
$employeeEmail = $_POST['inputEmailEmployee'];
$employeeFunction = $_POST['inputEmployeeFunction'];

$mysqli->query("INSERT INTO Employee(`employeeEmail`,`employeeName`,`employeeFunction`, `limiteProjetos`, `User_email`,`Project_NameProject`) values('$employeeEmail', '$employeeName', '$employeeFunction', '0', '$User_email', null)");

$mysqli->close();
?>
