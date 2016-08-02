<?php
session_start();
include 'connection_mysql.php';

$user_email = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$status = 'started';

$statusSprint = 'started';
$idSprint = mysqli_fetch_array($mysqli->query("SELECT MAX(idSprint) AS idSprint FROM Sprint"));

$sprint = $idSprint['idSprint'];

$mysqli->query("UPDATE Sprint SET sprintStatus = '$statusSprint' WHERE idSprint = '$sprint' AND Project_NameProject = '$inputProjectName' AND Project_User_email = '$user_email'");

$mysqli->close();
?> 