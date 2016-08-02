<?php
session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$inputSprintTime = $_POST['inputSprintTime'];
$inputTodaySprint = $_POST['inputTodaySprint'];
$inputEndSprint = $_POST['inputEndSprint'];

$sprint = mysqli_fetch_array($mysqli->query("SELECT idSprint, sprintStatus FROM  Sprint WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName' AND idSprint = (SELECT MAX(idSprint) FROM Sprint)"));

$idSprint = $sprint['idSprint'];

$mysqli->query("UPDATE Sprint SET SprintTime = '$inputEndSprint', SprintStarted = '$inputTodaySprint' WHERE Project_NameProject = '$inputProjectName' AND Project_User_email = '$userName' AND idSprint = '$idSprint'");

$mysqli->close();
?>
