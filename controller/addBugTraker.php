<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];

$projectSelected = $_POST['inputProjectName'];
$bugName = $_POST['inputBugTrakerName'];
$sprintItem = $_POST['inputBugTrakerItem'];
$bugDescription = $_POST['inputBugTrakerDescription'];
$status = "danger";

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction, User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);
if (!isset($rowVerifyEmployee['employeeFunction'])) {
	#ADMIN
  $recebeTabela = $mysqli->query("SELECT MAX(idSprint) AS idSprint FROM Sprint WHERE Project_NameProject = '$projectSelected' AND Project_User_email = '$userName'");
  $row = $recebeTabela->fetch_array(MYSQLI_ASSOC);
  $idSprint = $row['idSprint'];
  $mysqli->query("INSERT INTO BugTraker(idBugTraker, Sprint_idSprint, BugTraker_Description, BugTraker_User, BugTraker_Status, ProductBacklog_productBacklogcolItem, ProductBacklog_Project_NameProject, ProductBacklog_Project_User_email) VALUES('$bugName', '$idSprint', '$bugDescription', '$userName', '$status', '$sprintItem', '$projectSelected', '$userName')");
} else {
	#EMPLOYEE
  $admin = $rowVerifyEmployee['User_email'];
  $recebeTabela = $mysqli->query("SELECT MAX(idSprint) AS idSprint FROM Sprint WHERE Project_NameProject = '$projectSelected' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected')");
  $row = $recebeTabela->fetch_array(MYSQLI_ASSOC);
  $idSprint = $row['idSprint'];
  $mysqli->query("INSERT INTO BugTraker(idBugTraker, Sprint_idSprint, BugTraker_Description, BugTraker_User, BugTraker_Status, ProductBacklog_productBacklogcolItem, ProductBacklog_Project_NameProject, ProductBacklog_Project_User_email) VALUES('$bugName', '$idSprint', '$bugDescription', '$userName', '$status', '$sprintItem', '$projectSelected', '$admin')");
}

$recebeFuncaoEmployee->close();
$recebeTabela->close();
$mysqli->close();
?>
