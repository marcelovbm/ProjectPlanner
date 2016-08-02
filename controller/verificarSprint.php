<?php
session_start();
include 'connection_mysql.php';

$user_email = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];

$sprint = mysqli_fetch_array($mysqli->query("SELECT idSprint, sprintStatus FROM  Sprint WHERE Project_User_email = '$user_email' AND Project_NameProject = '$inputProjectName' AND idSprint = (SELECT MAX(idSprint) FROM Sprint)"));

if($sprint['sprintStatus'] == NULL){
	echo 'false';
} else{
	echo 'true';
}

$mysqli->close();
?> 