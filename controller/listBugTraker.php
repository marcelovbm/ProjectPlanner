<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$projectSelected = $_POST['nameProject'];
$contador = 1;

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

echo 		'<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

if (!isset($rowVerifyEmployee['employeeFunction'])) {
	# code...
	$recebeLista = $mysqli->query("SELECT idBugTraker, BugTraker_User, BugTraker_Status, BugTraker_Description FROM BugTraker WHERE ProductBacklog_Project_NameProject = '$projectSelected' AND ProductBacklog_Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint)");
} else {
	# code...
	$recebeLista = $mysqli->query("SELECT idBugTraker, BugTraker_User, BugTraker_Status, BugTraker_Description FROM BugTraker WHERE ProductBacklog_Project_NameProject = '$projectSelected' AND ProductBacklog_Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected') AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint)");
}
while ($row = $recebeLista->fetch_array(MYSQLI_ASSOC)) {
	echo 	'	<div class="panel panel-' . $row['BugTraker_Status'] . '">
						<div class="panel-heading" role="tab" id="heading' . $contador . '">
							<h4 class="panel-title" role="button"  data-toggle="collapse" data-parent="#accordion" href="#collapse' . $contador . '" aria-expanded="false" aria-controls="collapseOne">' . $row['idBugTraker'] . '
								<span class="badge badge-warning">';
								$user = $row['BugTraker_User'];
								$recebeUser = mysqli_fetch_object($mysqli->query("SELECT userName FROM User WHERE email = '$user'"));
								echo ''. $recebeUser->userName .'';
					echo '</span>
							</h4>
						</div>
						<div id="collapse' . $contador . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $contador . '">
							<div class="panel-body">' . $row['BugTraker_Description'] . '</div>
								<div class="panel-footer condensed text-right">
									<button type="button" class="btn btn-warning btn-circle" id="warning" value="' . $row['idBugTraker'] . '" onclick="bugTraker.changeStatus(id,value);"><i class="material-icons list-icons" aria-hidden="true">build</i></button>
									<button type="button" class="btn btn-success btn-circle" id="success" value="' . $row['idBugTraker'] . '" onclick="bugTraker.changeStatus(id,value);"><i class="material-icons list-icons" aria-hidden="true">done</i></button>
								</div>
							</div>
						</div>';
	$contador++;
}

if (!isset($rowVerifyEmployee['employeeFunction']) || $rowVerifyEmployee['employeeFunction'] == 'Scrum Master' || $rowVerifyEmployee['employeeFunction'] == 'Development Team') {
	# code...
	echo 			'</div>
						<button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-bugTraker">Add</button>';
} else {
	# code...
	echo 			'</div>
						<button type="button" id="addButton" class="btn btn-circle btn-lg" disabled>Add</button>';
}

$recebeLista->close();
$mysqli->close();
?>
