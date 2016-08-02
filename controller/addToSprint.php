<?php
session_start();
include 'connection_mysql.php';

$user_email = $_SESSION['userName'];

$inputProjectName = $_POST['inputProjectName'];
$productBacklogcolItem = $_POST['productBacklogcolItem'];

$recebeTabela = $mysqli->query("SELECT idSprint, sprintStatus FROM  Sprint WHERE Project_User_email = '$user_email' AND Project_NameProject = '$inputProjectName' AND idSprint = (SELECT MAX(idSprint) FROM Sprint)");

$sprint = $recebeTabela->fetch_array(MYSQLI_ASSOC);

$idSprint = $sprint['idSprint'];

$mysqli->query("UPDATE ProductBacklog SET statusProductBacklog = 'active', Sprint_idSprint = '$idSprint'WHERE productBacklogcolItem = '$productBacklogcolItem' AND Project_NameProject = '$inputProjectName' AND Project_User_email = '$user_email'");
$recebeTabela->close();
$mysqli->close();
?>
