<?php
session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$projectSelected = $_POST['inputProjectName'];
$inputBugName = $_POST['inputBugName'];
$status = $_POST['status'];

$mysqli->query("UPDATE BugTraker SET BugTraker_Status = '$status' WHERE idBugTraker = '$inputBugName' AND ProductBacklog_Project_NameProject = '$projectSelected' AND ProductBacklog_Project_User_email = '$userName'");
$mysqli->close();
?>