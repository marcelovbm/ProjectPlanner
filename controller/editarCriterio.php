<?php
include 'connection_mysql.php';

session_start();

$userName = $_SESSION['userName'];
$inputNameCriterio = $_POST['inputNameCriterio'];
$inputCriterioPeso = $_POST['inputCriterioPeso'];

$mysqli->query("UPDATE Criterios SET criterioPeso = '$inputCriterioPeso' WHERE criterioName = '$inputNameCriterio' AND User_email = '$userName'");

$mysqli->close();
?>
