<?php
include 'connection_mysql.php';
session_start();

$user_email = $_SESSION['userName'];
$inputProjectName = $_POST['projectSelected'];

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$user_email' AND Project_NameProject = '$inputProjectName'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
  $recebeTabelaSprint = $mysqli->query("SELECT sprintStatus FROM Sprint WHERE Project_NameProject = '$inputProjectName' AND Project_User_email = '$user_email' AND idSprint = (SELECT MAX(idSprint) FROM Sprint)");
  $sprint = $recebeTabelaSprint->fetch_array(MYSQLI_ASSOC);
  $sprintStatus = $sprint['sprintStatus'];
} else {
	//EMPLOYEE
  $recebeTabelaSprint = $mysqli->query("SELECT sprintStatus FROM Sprint WHERE Project_NameProject = '$inputProjectName' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$user_email' AND Project_NameProject = '$inputProjectName') AND idSprint = (SELECT MAX(idSprint) FROM Sprint)");
  $sprint = $recebeTabelaSprint->fetch_array(MYSQLI_ASSOC);
  $sprintStatus = $sprint['sprintStatus'];
}
echo $sprintStatus;

$recebeTabelaSprint->close();
$mysqli->close();
?>
