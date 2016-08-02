<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$nameProject = $_POST['inputProjectName'];
$idSprint = $_POST['idSprint'];
$novaSprint = $idSprint + 1;

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction, User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

$admin = $rowVerifyEmployee['User_email'];

if(!isset($rowVerifyEmployee['employeeFunction'])){
  $mysqli->query("UPDATE Sprint SET sprintStatus = 'done' WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND idSprint = '$idSprint'");
  $mysqli->query("INSERT INTO Sprint (idSprint, sprintStatus, Project_NameProject, Project_User_email) VALUES ('$novaSprint', null, '$nameProject', '$userName')");
  $mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = '', Sprint_idSprint = null WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = '$idSprint' AND statusProductBacklog = 'active' OR statusProductBacklog = 'warning'");
} else{
  $mysqli->query("UPDATE Sprint SET sprintStatus = 'done' WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject') AND idSprint = '$idSprint'");
  $mysqli->query("INSERT INTO Sprint (idSprint, sprintStatus, Project_NameProject, Project_User_email) VALUES ('$novaSprint', null, '$nameProject', '$admin')");
  $mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = '', Sprint_idSprint = null WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject') AND Sprint_idSprint = '$idSprint' AND statusProductBacklog = 'active' OR statusProductBacklog = 'warning'");
}

$recebeFuncaoEmployee->close();
$mysqli->close();
?>
