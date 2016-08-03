<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$inputEditarProductOwner = $_POST['inputEditarProductOwner'];

$recebeTabelaTeam = $mysqli->query("SELECT productOwner FROM Team WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName'");

if($recebeTabelaTeam == NULL){
	$mysqli->query("UPDATE Team SET productOwner = '$inputEditarProductOwner' WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$inputProjectName' WHERE employeeName = '$inputEditarProductOwner'");
} else {
	$mysqli->query("SET foreign_key_checks = 0");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '0', Project_NameProject = NULL WHERE User_email ='$userName' AND Project_NameProject = '$inputProjectName' AND employeeName = (SELECT productOwner FROM Team WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName')");
	$mysqli->query("SET foreign_key_checks = 1");
	$mysqli->query("UPDATE Team SET productOwner = '$inputEditarProductOwner' WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$inputProjectName' WHERE employeeName = '$inputEditarProductOwner'");
}

$mysqli->close();
?>
