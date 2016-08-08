<?php
session_start();
include 'connection_mysql.php';
$user_email = $_SESSION['userName'];
// read JSon input
$data_back = json_decode(file_get_contents('php://input'));
// set json string to php variables
$inputTitleRiscos = $data_back->{"inputTitleRiscos"};
$inputRiscosDescription = $data_back->{"inputRiscosDescription"};
$projectName = $data_back->{"inputProjectName"};

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction, User_email FROM Employee WHERE employeeEmail = '$user_email' AND Project_NameProject = '$projectName'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	$mysqli->query("INSERT INTO Riscos(nameRiscos, Riscos_Description, Project_NameProject, Project_User_email)
  VALUES ('$inputTitleRiscos', '$inputRiscosDescription', '$projectName', '$user_email')");
} else {
	//EMPLOYEE
	$admin = $rowVerifyEmployee['User_email'];
	$mysqli->query("INSERT INTO Riscos(nameRiscos, Riscos_Description, Project_NameProject, Project_User_email)
  VALUES ('$inputTitleRiscos', '$inputRiscosDescription', '$projectName', '$admin')");	
}
$mysqli->close();
?>
