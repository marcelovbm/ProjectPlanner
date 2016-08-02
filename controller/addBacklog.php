<?php
session_start();
include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$projectSelected = $_POST['inputProjectName'];
$backlogName = $_POST['inputBackLogName'];
$planningPoker = $_POST['inputPlanningPoker'];
$backlogDescription = $_POST['inputBackLogDescription'];

$mysqli->query("INSERT INTO `ProductBacklog`(`productBacklogcolItem`,`statusProductBacklog`,`ProductBacklogcologDescription`,`PlanningPoker`,`Project_NameProject`,`Project_User_email`) VALUES ('$backlogName','','$backlogDescription','$planningPoker','$projectSelected', '$userName')");

$mysqli->close();
?>
