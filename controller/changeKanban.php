<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$nameProject = $_POST['inputProjectName'];
$idProductSprint = $_POST['id'];
$statusProductSprint = $_POST['box'];

$today = date("y-m-d");

if ($statusProductSprint == 'bodyDoing') {
	# code...
	$mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = 'warning', productBacklogDate = NULL WHERE productBacklogcolItem = '$idProductSprint' AND Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint)");

} else if($statusProductSprint == 'bodyToDo'){
	# code...
	$mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = 'active', productBacklogDate = NULL WHERE productBacklogcolItem = '$idProductSprint' AND Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint)");

} else if($statusProductSprint == 'bodyDone'){
	# code...
	$mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = 'success', productBacklogDate = '$today' WHERE productBacklogcolItem = '$idProductSprint' AND Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint)");
}

$mysqli->close();
?>
