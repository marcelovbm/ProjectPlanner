<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$nameProject = $_POST['nameProject'];

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject'");
$rowVerifyEmployee = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if(!isset($rowVerifyEmployee['employeeFunction'])){
	//ADMIN
	$recebeTabelaToDo = $mysqli->query("SELECT productBacklogcolItem FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'active'");
	$recebeTabelaIdSprint = $mysqli->query("SELECT MAX(idSprint) AS idSprint FROM Sprint WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName'");
	$recebeIdSprint = $recebeTabelaIdSprint->fetch_array(MYSQLI_ASSOC);
	$recebeTabelaDoing = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'warning'");
	$recebeTabelaDone = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = '$userName' AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'success'");
} else {
	//EMPLOYEE
	$recebeTabelaIdSprint = $mysqli->query("SELECT MAX(idSprint) AS idSprint FROM Sprint WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject')");
	$recebeIdSprint = $recebeTabelaIdSprint->fetch_array(MYSQLI_ASSOC);
	$recebeTabelaToDo = $mysqli->query("SELECT productBacklogcolItem FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject') AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'active'");
	$recebeTabelaDoing = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject') AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'warning'");
	$recebeTabelaDone = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog FROM ProductBacklog WHERE Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject') AND Sprint_idSprint = (SELECT MAX(idSprint) FROM Sprint) AND statusProductBacklog = 'success'");
}
echo '	<div class="row">
					<div class = "col-md-4" id="toDoColum">
						<div class="colum">
							<div class="sprintHeader">
								<h4>To Do</h4>
							</div>
							<ul id="bodyToDo" class="bodySprint">';
$contador = 1;
while ($rowToDo = $recebeTabelaToDo->fetch_array(MYSQLI_ASSOC)) {
		echo '			<li class = "cardSprint" id="'. $rowToDo['productBacklogcolItem'] .'" >
									<a class="titleDescription" value="'. $rowDoing['productBacklogcolItem'] .'">'. $rowToDo['productBacklogcolItem'] .' </a>
								</li>';
}
		echo '		</ul>
						</div>
					</div>
					<div class = "col-md-4">
						<div class = "colum">
							<div class="sprintHeader">
								<h4>Doing</h4>
							</div>
							<ul id="bodyDoing" class="bodySprint">';
while ($rowDoing = $recebeTabelaDoing->fetch_array(MYSQLI_ASSOC)) {
		echo '			<li class = "cardSprint" id="'. $rowDoing['productBacklogcolItem'] .'">
									<a class="titleDescription" value="'. $rowDoing['productBacklogcolItem'] .'">'. $rowDoing['productBacklogcolItem'] .'</a>
								</li>';
}
		echo '		</ul>
						</div>
					</div>
					<div class = "col-md-4">
						<div class="colum">
							<div class="sprintHeader">
								<h4>Done</h4>
							</div>
							<ul id="bodyDone" class="bodySprint">';
while ($rowDone = $recebeTabelaDone->fetch_array(MYSQLI_ASSOC)) {
		echo '			<li class = "cardSprint" id="'. $rowDone['productBacklogcolItem'] .'">
									<a class="titleDescription" value="'. $rowDoing['productBacklogcolItem'] .'">'. $rowDone['productBacklogcolItem'] .'</a>
								</li>';
}
		echo '		</ul>
						</div>
					</div>
				</div>';
if(!isset($rowVerifyEmployee['employeeFunction']) || $rowVerifyEmployee['employeeFunction'] == 'Scrum Master' || $rowVerifyEmployee['employeeFunction'] == 'Development Team'){
	//ADMIN
	echo '<button type="button" id="addButton" class="btn btn-circle btn-lg" name="'.$recebeIdSprint['idSprint'].'"onClick="sprint.finalizeSprint(name);">Finalize</button>';
} else {
	echo '<button type="button" id="addButton" class="btn btn-circle btn-lg" disabled">Finalize</button>';
}

$recebeTabelaDone->close();
$recebeTabelaDoing->close();
$recebeTabelaToDo->close();

$mysqli->close();
?>
