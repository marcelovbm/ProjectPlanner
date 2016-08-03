<?php
session_start();

include 'connection_mysql.php';

$userName = $_SESSION['userName'];
$nameProject = $_POST['nameProject'];
//VERIFICA SE O USUARIO E FUNCIONARIO DO PROJETO
$recebeEmployeeProject = $mysqli->query("SELECT NameProject,projectManager,EndDate,Description FROM Project WHERE User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName') AND NameProject = '$nameProject'");
$rowVerify = $recebeEmployeeProject->fetch_array(MYSQLI_ASSOC);
//VERIFICA SE NÃO FOI INSERIDO UM VALOR EM "NameProject"
if(!isset($rowVerify['NameProject'])){
	//ADMIN
	$recebetabelaProductOwner = $mysqli->query("SELECT idTeam, productOwner, scrumMaster FROM Team WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName'");
	$row = $recebetabelaProductOwner->fetch_array(MYSQLI_ASSOC);
	$idTeam = $row['idTeam'];
	$recebeTabelaTeamDevelopment = $mysqli->query("SELECT name,cargo FROM DevelopmentTeam WHERE Team_idTeam = '$idTeam'");
	echo '<div class="row">
					<div class="col-md-4">
						<div id="productOwnerTable" class="plan">
							<div class="plan-name-productOwner">
								<h3>Product Owner</h3>
							</div>
							<ul>
								<li class="plan-feature">
									<a>' . $row['productOwner'] . '</a>
									<hr>
								</li>
							</ul>
							<button type="button" onClick="team.receberEditProductOwner();" class="btn btn-plan-select ">Select</button>
						</div>
					</div>
					<div class="col-md-4">
						<div id="scrumMasterTable" class="plan">
							<div class="plan-name-scrumMaster">
								<h3>Scrum Master</h3>
							</div>
							<ul>
								<li class="plan-feature">
									<a>' . $row['scrumMaster'] . '</a>
									<hr>
								</li>
							</ul>
							<button type="button" class="btn btn-plan-select" data-toggle="modal" data-target="#addScrumMaster">Select</button>
						</div>
					</div>
					<div class="col-md-4">
						<div id="developmenteTeamTable" class="plan">
							<div class="plan-name-developerTeam">
								<h3>Development Team</h3>
							</div>
							<ul>
								<li class="plan-feature">';
	if (mysqli_num_rows($recebeTabelaTeamDevelopment) > 0) {
		while ($row2 = $recebeTabelaTeamDevelopment->fetch_array(MYSQLI_ASSOC)) {
			echo '			<a>' . $row2['name'] . '</a>
									<hr>';
		}
	} else {
		echo '				<hr>';
	}
	echo '				</li>
							</ul>
							<button type="button" class="btn btn-plan-select" data-toggle="modal" data-target="#addDevelopmenteTeam">Add</button>
						</div>
					</div>
				</div>';
} else {
	//EMPLOYEE
	$recebetabelaProductOwnerEmployee = $mysqli->query("SELECT idTeam, productOwner, scrumMaster FROM Team WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject')");
	$rowEmployee = $recebetabelaProductOwnerEmployee->fetch_array(MYSQLI_ASSOC);
	$idTeamEmployee = $rowEmployee['idTeam'];
	$recebeTabelaTeamDevelopmentEmployee = $mysqli->query("SELECT name,cargo FROM DevelopmentTeam WHERE Team_idTeam = '$idTeamEmployee'");
	echo '<div class="row">
					<div class="col-md-4">
						<div id="productOwnerTable" class="plan">
							<div class="plan-name-productOwner">
								<h3>Product Owner</h3>
							</div>
							<ul>
								<li class="plan-feature">
									<a>' . $rowEmployee['productOwner'] . '</a>
									<hr>
								</li>
							</ul>
							<button type="button" onClick="team.receberEditProductOwner();" disabled class="btn btn-plan-select ">Edit</button>
						</div>
					</div>
					<div class="col-md-4">
						<div id="scrumMasterTable" class="plan">
							<div class="plan-name-scrumMaster">
								<h3>Scrum Master</h3>
							</div>
							<ul>
								<li class="plan-feature">
									<a>' . $rowEmployee['scrumMaster'] . '</a>
									<hr>
								</li>
							</ul>
							<button type="button" class="btn btn-plan-select" data-toggle="modal" disabled data-target="#addScrumMaster">Select</button>
						</div>
					</div>
					<div class="col-md-4">
						<div id="developmenteTeamTable" class="plan">
							<div class="plan-name-developerTeam">
								<h3>Development Team</h3>
							</div>
							<ul>
								<li class="plan-feature">';
	if (mysqli_num_rows($recebeTabelaTeamDevelopmentEmployee) > 0) {
		while ($rowEmployee2 = $recebeTabelaTeamDevelopmentEmployee->fetch_array(MYSQLI_ASSOC)) {
			echo '			<a>' . $rowEmployee2['name'] . '</a>
									<hr>';
		}
	} else {
		echo '				<hr>';
	}
	echo '				</li>
							</ul>
							<button type="button" class="btn btn-plan-select" data-toggle="modal" disabled data-target="#addDevelopmenteTeam">Add</button>
						</div>
					</div>
				</div>';
}

//ADMIN
//EMPLOYEE
$mysqli->close();
?>
