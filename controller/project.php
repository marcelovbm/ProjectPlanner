<?php
include 'connection_mysql.php';
session_start();

$userName = $_SESSION['userName'];
$json = array();
$projetosEmployee = $mysqli->query("SELECT Project_NameProject, User_email FROM Employee WHERE employeeEmail = '$userName'");

$recebeTabela = $mysqli->query("SELECT NameProject,EndDate,Description FROM Project WHERE User_email = '$userName' ORDER BY NameProject");
$recebeTabelaData = $mysqli->query("SELECT DATE_FORMAT( EndDate, '%d/%m/%Y') AS EndDate FROM Project WHERE User_email = '$userName'");

while ($rowTeste = $projetosEmployee->fetch_array(MYSQLI_ASSOC)) {
	$rowUser_email = $rowTeste['User_email'];
	$rowProject_NameProject = $rowTeste['Project_NameProject'];

	$recebeTabelaEmployeeData = $mysqli->query("SELECT DATE_FORMAT( EndDate, '%d/%m/%Y') AS EndDate FROM Project WHERE User_email = '$rowUser_email' AND NameProject = '$rowProject_NameProject'");
	$recebeEmployeeProject = $mysqli->query("SELECT NameProject,EndDate,Description FROM Project WHERE User_email = '$rowUser_email' AND NameProject = '$rowProject_NameProject' ORDER BY NameProject");
	while ($rowEmployee = $recebeEmployeeProject->fetch_array(MYSQLI_ASSOC) AND $rowEmployeeData = $recebeTabelaEmployeeData->fetch_array(MYSQLI_ASSOC)) {
		$employee = array(
		 			'nameProject'=> $rowEmployee['NameProject'],
		 			'data'=> $rowEmployeeData['EndDate'],
		 			'table_comment'=> $rowEmployee['Description'],
					'Designar_Gerente' => '<button type="button" class="btn btn-default btn-circle" disabled><i class="material-icons list-icons" aria-hidden="true">perm_identity</i></button>',
					'Criterios' => '<button type="button" class="btn btn-default btn-circle" disabled><i class="material-icons list-icons" aria-hidden="true">list</i></button>',
		 			'edit' => '<button type="button" class="btn btn-default btn-circle" disabled><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
		 			'delete' => '<button type="button" class="btn btn-default btn-circle" disabled><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>'
		 			);
	    array_push($json, $employee);
	}
}
while ($row = $recebeTabela->fetch_array(MYSQLI_ASSOC) AND $rowData = $recebeTabelaData->fetch_array(MYSQLI_ASSOC)) {
	$bus = array(
	 			'nameProject'=> $row['NameProject'],
	 			'data'=> $rowData['EndDate'],
	 			'table_comment'=> $row['Description'],
				'Designar_Gerente' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['NameProject'].'" onClick="project.modalGerenteProject(name);"><i class="material-icons list-icons" aria-hidden="true">perm_identity</i></button>',
	 			'Criterios' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['NameProject'].'" onClick="project.modalCriteriosProject(name);"><i class="material-icons list-icons" aria-hidden="true">list</i></button>',
	 			'edit' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['NameProject'].'" onClick="project.modalEditarProject(name);"><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
	 			'delete' => '<button type="button" id="deleteProject" class="btn btn-default btn-circle" data-toggle="modal" name="'.$row['NameProject'].'" onClick="project.deletarProject(name);"><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>'
	 			);
    array_push($json, $bus);
}

echo urldecode(json_encode($json));
$mysqli->close();
?>
