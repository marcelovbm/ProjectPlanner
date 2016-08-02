<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$nameProject = $_POST['nameProject'];
$json = array();

$recebeFuncaoEmployee = $mysqli->query("SELECT employeeFunction, User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$nameProject'");
$rowFuncao = $recebeFuncaoEmployee->fetch_array(MYSQLI_ASSOC);

if($rowFuncao['employeeFunction'] == 'Product Owner' || !isset($rowFuncao['employeeFunction'])){
	//ADMIN OR PRODUCT OWNER
	if($rowFuncao['employeeFunction'] == 'Product Owner'){
			$recebetabela = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog, ProductBacklogcologDescription, PlanningPoker, Sprint_idSprint FROM ProductBacklog WHERE  Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName') ORDER BY PlanningPoker");
	}
	else{
		$recebetabela = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog, ProductBacklogcologDescription, PlanningPoker, Sprint_idSprint FROM ProductBacklog WHERE  Project_NameProject = '$nameProject' AND Project_User_email = '$userName' ORDER BY PlanningPoker");
	}
	while ($row = $recebetabela->fetch_array(MYSQLI_ASSOC)){
		$bus = array(
		 			'productBacklogItem'=> $row['productBacklogcolItem'],
		 			'statusProductBacklog'=> $row['statusProductBacklog'],
		 			'ProductBacklogDescription'=> $row['ProductBacklogcologDescription'],
		 			'statusProductBacklog'=> $row['statusProductBacklog'],
		 			'PlanningPoker'=> $row['PlanningPoker'],
		 			'Sprint_idSprint'=> $row['Sprint_idSprint'],
		 			'edit' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['productBacklogcolItem'].'" onClick="productBacklog.editarBacklogModal(name);"><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
		 			'delete' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['productBacklogcolItem'].'" onClick="productBacklog.deleteBacklogItem(name);" id="'.$row['productBacklogcolItem'].'"><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>');
	    array_push($json, $bus);
	}
} else {
	//OTHERS
	$recebetabela = $mysqli->query("SELECT productBacklogcolItem, statusProductBacklog, ProductBacklogcologDescription, PlanningPoker, Sprint_idSprint FROM ProductBacklog WHERE  Project_NameProject = '$nameProject' AND Project_User_email = (SELECT User_email FROM Employee WHERE employeeEmail = '$userName') ORDER BY PlanningPoker");
	while ($row = $recebetabela->fetch_array(MYSQLI_ASSOC)){
		$bus = array(
		 			'productBacklogItem'=> $row['productBacklogcolItem'],
		 			'statusProductBacklog'=> $row['statusProductBacklog'],
		 			'ProductBacklogDescription'=> $row['ProductBacklogcologDescription'],
		 			'statusProductBacklog'=> $row['statusProductBacklog'],
		 			'PlanningPoker'=> $row['PlanningPoker'],
		 			'Sprint_idSprint'=> $row['Sprint_idSprint'],
		 			'edit' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" disabled><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
		 			'delete' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" disabled><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>');
	    array_push($json, $bus);
	}
}
echo urldecode(json_encode($json));
$recebeFuncaoEmployee->close();
$recebetabela->close();
$mysqli->close();
?>
