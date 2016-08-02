<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$projectName = $_POST['inputProjectName'];
$scrumMaster = $_POST['inputScrumMaster'];

$recebeTabelaTeam = $mysqli->query("SELECT scrumMaster FROM Team WHERE Project_User_email = '$userName' AND Project_NameProject = '$projectName'");
$rowScrumMasterTabelaTeam = $recebeTabelaTeam->fetch_array(MYSQLI_ASSOC);

if($recebeTabelaTeam == NULL){
	$mysqli->query("UPDATE Team SET scrumMaster = '$scrumMaster' WHERE Project_User_email = '$userName' AND Project_NameProject = '$projectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$projectName' WHERE employeeName = '$scrumMaster'");
} else {
	$mysqli->query("SET foreign_key_checks = 0");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '0', Project_NameProject = NULL WHERE User_email ='$userName' AND Project_NameProject = '$projectName' AND employeeName = (SELECT scrumMaster FROM Team WHERE Project_User_email = '$userName' AND Project_NameProject = '$projectName')");
	$mysqli->query("SET foreign_key_checks = 1");
	$mysqli->query("UPDATE Team SET scrumMaster = '$scrumMaster' WHERE Project_User_email = '$userName' AND Project_NameProject = '$projectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$projectName' WHERE employeeName = '$scrumMaster'");
}

$recebeTabelaTeam->close();
$mysqli->close();
?>
