<?php
session_start();

include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$json = array();
$recebetabela = $mysqli->query("SELECT employeeEmail, employeeName, employeeFunction, User_email, Project_NameProject FROM Employee WHERE User_email = '$userName' ORDER BY employeeName");

while ($row = mysqli_fetch_array($recebetabela)){
	 $bus = array(
	 			'employeeEmail'=> $row['employeeEmail'],
	 			'employeeName'=> $row['employeeName'],
	 			'employeeFunction'=> $row['employeeFunction'],
	 			'Project_NameProject'=> $row['Project_NameProject'],
	 			'edit' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="' . $row['employeeEmail'] . '" onClick="employee.modalEditarEmployee(name);"><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
	 			'delete' => '<button type="button" id="deleteProject" class="btn btn-default btn-circle" data-toggle="modal" name="' . $row['employeeEmail'] . '" onClick="employee.deleteEmployee(name);"><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>'
	 			);
    array_push($json, $bus);
}
echo urldecode(json_encode($json));
$mysqli->close();
?>
