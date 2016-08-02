<?php

session_start();

include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$nameProject = $_POST['inputProjectName'];
$nameBacklogItem = $_POST['keyBacklog'];

$mysqli->query("DELETE FROM ProductBacklog
				WHERE productBacklogcolItem = '$nameBacklogItem'
				AND Project_NameProject = '$nameProject'
				AND Project_User_email = '$userName'");

$mysqli->close();
?>