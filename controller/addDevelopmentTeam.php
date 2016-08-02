<?php
session_start();
$userName = $_SESSION['userName'];

include 'connection_mysql.php';

$projectName = $_POST['inputProjectName'];
$developerName = $_POST['inputDeveloperName'];

$recebeTabela = $mysqli->query("SELECT idTeam FROM Team WHERE Project_NameProject = '$projectName' AND Project_User_email = '$userName'");

$row = $recebeTabela->fetch_array(MYSQLI_ASSOC);

$idTeam = $row['idTeam'];

$mysqli->query("INSERT INTO DevelopmentTeam(name,cargo,Team_idTeam) values('$developerName',NULL,'$idTeam')");

$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$projectName' WHERE employeeName = '$developerName'");

$recebeTabela->close();
$mysqli->close();
?>
