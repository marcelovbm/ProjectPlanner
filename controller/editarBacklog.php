<?php
include 'connection_mysql.php';

session_start();

$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$inputBackLogName = $_POST['inputBackLogName'];
$inputPlanningPoker = $_POST['inputPlanningPoker'];
$inputBackLogDescription = $_POST['inputBackLogDescription'];

$mysqli->query("UPDATE ProductBacklog
				SET ProductBacklogcologDescription = '$inputBackLogDescription', PlanningPoker = '$inputPlanningPoker'
				WHERE productBacklogcolItem = '$inputBackLogName'
				AND Project_NameProject = '$inputProjectName'
				AND Project_User_email = '$userName'");

$mysqli->close();
?>