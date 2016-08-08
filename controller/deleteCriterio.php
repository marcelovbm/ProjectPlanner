<?php

session_start();

include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$inputNameCriterio = $_POST['inputNameCriterio'];

$mysqli->query("DELETE FROM Criterios WHERE criterioName = '$inputNameCriterio' AND User_email = '$userName'");

$mysqli->close();
?>
