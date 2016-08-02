<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$inputProjectName'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	$recebetabela = $mysqli->query("SELECT productBacklogcolItem FROM ProductBacklog WHERE Project_User_email = '$userName' AND Project_NameProject = '$inputProjectName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'warning'");
}else{
	//EMPLOYEE
	$recebetabela = $mysqli->query("SELECT productBacklogcolItem FROM ProductBacklog WHERE Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$inputProjectName') AND Project_NameProject = '$inputProjectName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'warning'");
}
echo '<option disabled selected value> -- select an option -- </option>';

while ($row = mysqli_fetch_array($recebetabela)) {
		echo '<option>' . $row['productBacklogcolItem'] . '</option>';
}

$recebetabela->close();
$mysqli->close();
?>
