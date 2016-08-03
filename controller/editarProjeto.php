<?php
include 'connection_mysql.php';

session_start();
$userName = $_SESSION['userName'];

$inputProjectName = $_POST['inputProjectName'];
$inputProjectDescription = $_POST['inputProjectDescription'];
$inputEditStartDate = $_POST['inputEditStartDate'];
$inputEditEndDate = $_POST['inputEditEndDate'];

//INSERI OS NOVOS DADOS AO PROJETO
$mysqli->query("UPDATE `Project`
	SET `StartDate` = '$inputEditStartDate', `EndDate`='$inputEditEndDate', `Description`='$inputProjectDescription'
	WHERE NameProject ='$inputProjectName'");
$mysqli->close();
?>
