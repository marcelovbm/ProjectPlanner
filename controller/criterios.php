<?php
session_start();

include 'connection_mysql.php';
$userName = $_SESSION['userName'];

$json = array();
$recebetabela = $mysqli->query("SELECT criterioName, criterioPeso FROM Criterios WHERE User_email = '$userName'");

while ($row = mysqli_fetch_array($recebetabela)){
	 $bus = array(
	 			'criterioName'=> $row['criterioName'],
	 			'criterioPeso'=> $row['criterioPeso'],
	 			'edit' => '<button type="button" class="btn btn-default btn-circle" data-toggle="modal" name="' . $row['criterioName'] . '" onClick="criterio.modalEditarCriterio(name)"><i class="material-icons list-icons" aria-hidden="true">mode_edit</i></button>',
	 			'delete' => '<button type="button" id="deleteProject" class="btn btn-default btn-circle" data-toggle="modal" name="' . $row['criterioName'] . '" onClick="criterio.deleteCriterio(name);"><i class="material-icons list-icons" aria-hidden="true">delete_forever</i></button>'
	 			);
    array_push($json, $bus);
}
echo urldecode(json_encode($json));
$mysqli->close();
?>
