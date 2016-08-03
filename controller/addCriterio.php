<?php
session_start();
include 'connection_mysql.php';

$User_email = $_SESSION['userName'];

$inputNameCriterio = $_POST['inputNameCriterio'];
$inputCriterioPeso = $_POST['inputCriterioPeso'];

$mysqli->query("INSERT INTO Criterios(`criterioName`,`criterioPeso`, `User_email`) values('$inputNameCriterio', '$inputCriterioPeso','$User_email')");

$mysqli->close();
?>
