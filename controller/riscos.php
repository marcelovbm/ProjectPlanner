<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$projectSelected = $_POST['nameProject'];
$contador = 1;

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction
  FROM Employee
  WHERE employeeEmail = '$userName'
  AND Project_NameProject = '$projectSelected'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	#ADMIN
	$recebeLista = $mysqli->query("SELECT nameRiscos, Riscos_Description
    FROM Riscos
    WHERE Project_NameProject = '$projectSelected'
    AND Project_User_email = '$userName'");
} else {
	#EMPLOYEE
	$recebeLista = $mysqli->query("SELECT nameRiscos, Riscos_Description
    FROM Riscos
    WHERE Project_NameProject = '$projectSelected'
    AND Project_User_email = (SELECT User_email
      FROM Employee
      WHERE employeeEmail = '$userName'
      AND Project_NameProject = '$projectSelected')");
}
echo '  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
while ($row = $recebeLista->fetch_array(MYSQLI_ASSOC)) {
	echo '  <div class="panel">
				    <div class="panel-heading panel-meeting-header" role="tab" id="heading' . $contador . '">
			        <h4 class="panel-title meeting-title" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $contador . '" aria-expanded="false" aria-controls="collapseOne">
				  		'. $row['nameRiscos'] .'</h4>
				    </div>
				    <div id="collapse' . $contador . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' . $contador . '">
              <div class="panel-body panel-body-meeting">
					      <address>
	                <br><strong>Description: </strong><br>
					        <p>'. $row['Riscos_Description'] .'</p>
						    </address>
					    </div>
				    </div>
		      </div>';
	$contador++;
}
echo '  </div>
			  <button type="submit" id="addButton" class="btn btn-circle btn-lg" data-toggle="modal"><i class="material-icons list-icons" aria-hidden="true">add</i></button>';
$mysqli->close();
?>
