<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$project = $_POST['nameProject'];

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	$recebeTabela = $mysqli->query("SELECT employeeName FROM Employee WHERE User_email = '$userName' AND Project_NameProject = '$project'");
} else {
	//EMPLOYEE
	$recebeTabela = $mysqli->query("SELECT employeeName FROM Employee WHERE User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$project') AND Project_NameProject = '$project'");
}
echo '<option></option>';
while ($row = mysqli_fetch_array($recebeTabela)) {
	if ($row['limiteProjetos'] == 0) {
		echo '<option>' . $row['employeeName'] . '</option>';
	} else {
		echo ' ';
	}
}
echo '';
$recebeTabela->close();
$mysqli->close();
?>
