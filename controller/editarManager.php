<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$inputEditarProjectManager = $_POST['inputEditarProjectManager'];

$recebeTabela = $mysqli->query("SELECT projectManager FROM Project WHERE User_email = '$userName' AND NameProject = '$inputProjectName'");
$row = $recebeTabela->fetch_array(MYSQLI_ASSOC);

if($recebeTabela == NULL){
	$mysqli->query("UPDATE Project SET projectManager = '$inputEditarProjectManager' WHERE User_email = '$userName' AND NameProject = '$inputProjectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$inputProjectName' WHERE employeeName = '$inputEditarProjectManager' AND User_email = '$userName'");
} else {
	$mysqli->query("SET foreign_key_checks = 0");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '0', Project_NameProject = NULL WHERE User_email ='$userName' AND Project_NameProject = '$inputProjectName' AND employeeName = (SELECT projectManager FROM Project WHERE User_email = '$userName' AND NameProject = '$inputProjectName')");
	$mysqli->query("SET foreign_key_checks = 1");
	$mysqli->query("UPDATE Project SET projectManager = '$inputEditarProjectManager' WHERE User_email = '$userName' AND NameProject = '$inputProjectName'");
	$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$inputProjectName' WHERE employeeName = '$inputEditarProjectManager' AND User_email = '$userName'");
}

$mysqli->close();
?>
