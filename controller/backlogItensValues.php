<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$project = $_POST['projectSelected'];
$json = array();

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	$recebeSprint =	$mysqli->query("SELECT MAX(idSprint) AS idSprint, SprintTime, SprintStarted FROM Sprint WHERE Project_NameProject = '$project' AND Project_User_email = '$userName' AND idSprint = (SELECT MAX(idSprint) FROM Sprint)");
	$recebeIdSprint = $recebeSprint->fetch_array(MYSQLI_ASSOC);
	$idSprint = $recebeIdSprint['idSprint'];
	$recebetabela = $mysqli->query("SELECT productBacklogcolItem, PlanningPoker, statusProductBacklog, productBacklogDate FROM ProductBacklog WHERE Project_NameProject = '$project' AND Project_User_email = '$userName' AND Sprint_idSprint = '$idSprint'");
	$recebetabelaSuccess = $mysqli->query("SELECT productBacklogcolItem, PlanningPoker, productBacklogDate FROM ProductBacklog WHERE Project_NameProject = '$project' AND Project_User_email = '$userName' AND Sprint_idSprint = '$idSprint'");
} else {
	//EMPLOYEE
	$recebeSprint =	$mysqli->query("SELECT MAX(idSprint) AS idSprint, SprintTime, SprintStarted FROM Sprint WHERE Project_NameProject = '$project' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project') AND idSprint = (SELECT MAX(idSprint) FROM Sprint)");
	$recebeIdSprint = $recebeSprint->fetch_array(MYSQLI_ASSOC);
	$idSprint = $recebeIdSprint['idSprint'];
	$recebetabela = $mysqli->query("SELECT productBacklogcolItem, PlanningPoker, statusProductBacklog, productBacklogDate FROM ProductBacklog WHERE Project_NameProject = '$project' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project') AND Sprint_idSprint = '$idSprint'");
	$recebetabelaSuccess = $mysqli->query("SELECT productBacklogcolItem, PlanningPoker, productBacklogDate FROM ProductBacklog ORDER BY productBacklogDate WHERE Project_NameProject = '$project' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project') AND Sprint_idSprint = '$idSprint'");
}
while ($row = $recebetabela->fetch_array(MYSQLI_ASSOC) AND $recebeIdSprint) {
	 $bus = array(
	 			'item'=> $row['productBacklogcolItem'],
	 			'PlanningPoker'=> $row['PlanningPoker'],
	 			'SprintTime'=> $recebeIdSprint['SprintTime'],
	 			'SprintStarted'=> $recebeIdSprint['SprintStarted'],
	 			'statusProductBacklog'=> $row['statusProductBacklog'],
				'productBacklogDate'=> $row['productBacklogDate']
	 			);
    array_push($json, $bus);
}
echo urldecode(json_encode($json));
$recebeSprint->close();
$recebetabela->close();
$recebetabelaSuccess->close();
$mysqli->close();
?>
