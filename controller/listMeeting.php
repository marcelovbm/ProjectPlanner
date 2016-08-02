<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$projectSelected = $_POST['nameProject'];
$contador = 1;

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	#ADMIN
	$recebeLista = $mysqli->query("SELECT idMeeting, MeetingMember, Meeting_Description, Meeting_Date FROM Meeting WHERE Project_NameProject = '$projectSelected' AND Project_User_email = '$userName' GROUP BY idMeeting,Meeting_Date");
} else {
	#EMPLOYEE
	$recebeLista = $mysqli->query("SELECT idMeeting, MeetingMember, Meeting_Description, Meeting_Date FROM Meeting WHERE Project_NameProject = '$projectSelected' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectSelected') GROUP BY idMeeting,Meeting_Date");
}
echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
while ($row = $recebeLista->fetch_array(MYSQLI_ASSOC)) {
	$reverseDate = date("d-m-Y", strtotime($row['Meeting_Date']));
	echo 	'<div class="panel">
				<div class="panel-heading panel-meeting-header" role="tab" id="heading' . $contador . '">
			        <h4 class="panel-title meeting-title" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $contador . '" aria-expanded="false" aria-controls="collapseOne">
				  		'. $row['idMeeting'] .' - '. $reverseDate .'</h4>
				</div>
				<div id="collapse' . $contador . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $contador . '">
          <div class="panel-body panel-body-meeting">
					<address>
						<strong>Members: </strong><br>';
						$date = $row['Meeting_Date'];
						$idMeeting = $row['idMeeting'];
						$recebeMembers = $mysqli->query("SELECT MeetingMember FROM Meeting WHERE idMeeting = '$idMeeting' AND Meeting_Date = '$date'");
						$numbeMembers = 1;
						$numberRows = mysqli_num_rows($recebeMembers);
						while($rowMember = $recebeMembers->fetch_array(MYSQLI_ASSOC)){
							echo '' . $rowMember['MeetingMember'] . ' ';
							if($numberRows == $numbeMembers){
								echo ' ';
								} else {
									echo ', ';
								}
							$numbeMembers++;
						}
						echo	'<br><strong>Description: </strong><br>
							<p>'. $row['Meeting_Description'] .'</p>
						</address>
					</div>
				</div>
			</div>';
	$contador++;
}
echo '</div>
			<button type="button" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#new-meeting"><i class="material-icons list-icons" aria-hidden="true">add</i></button>';
$mysqli->close();
?>
