<?php

session_start();
include 'connection_mysql.php';
$userName = $_SESSION['userName'];
$nameProject = $_POST['inputProjectName'];
$backlogName = $_POST['bakclogName'];

$receberLinha = $mysqli->query("SELECT `productBacklogcolItem`, `ProductBacklogcologDescription`, `PlanningPoker`
									FROM `ProductBacklog`
									WHERE  `Project_NameProject` = '$nameProject'
									AND `Project_User_email` = '$userName'
									AND `productBacklogcolItem` = '$backlogName'");

$row = $receberLinha->fetch_array(MYSQLI_ASSOC);

echo '<div class="modal-header btn-primary">
				<button type="button" class="close" onclick="removerClassBackLog();" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title text-center" id="myModalLabel">Edit Item</h2>
			</div>
			<div class="modal-body">
				<!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
				<div id="myboxBackLog" class="alert alert text-center hide" role="alert"></div>
					<!-- FIM CAIXA DE ALERTA -->
					<!-- FORMULARIO DO MODAL DE CADASTRAR -->
					<form class="form-horizontal" role="form" name="editBackLog" id="editBackLog" method="POST">
						<div class="form-group" id="divInputBackLogName">
							<label for="inputBackLogName" class="col-xs-2 col-sm-4 control-label">Item Name</label>
							<div class="col-xs-7 col-sm-5">
								<input value="' . $row['productBacklogcolItem'] . '" type="text" class="form-control " id="inputBackLogName" name="inputBackLogName" disabled="disabled" placeholder="Item Name" required="" autofocus="" >
							</div>
						</div>
						<div class="form-group" id="divInputPlanningPoker">
							<label for="inputPlanningPoker" class="col-xs-2 col-sm-4 control-label">Planning Poker Value</label>
							<div class="col-xs-7 col-sm-5">
								<select name="inputPlanningPoker" id="inputPlanningPoker" class="form-control">';
if ($row['PlanningPoker'] == '0') {
	echo '					<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '1/2') {
	echo '					<option value="1/2">1/2</option>
									<option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '1') {
	echo '					<option value="1">1</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '2') {
	echo '					<option value="2">2</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '3') {
	echo '					<option value="3">3</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '5') {
	echo '					<option value="5">5</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '8') {
	echo '					<option value="8">8</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '13') {
	echo '					<option value="13">13</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="20">20</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '20') {
	echo '					<option value="20">20</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="40">40</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '40') {
	echo '					<option value="40">40</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="100">100</option>';
} else if ($row['PlanningPoker'] == '100') {
	echo '					<option value="100">100</option>
									<option value="0">0</option>
									<option value="1/2">1/2</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="5">5</option>
									<option value="8">8</option>
									<option value="13">13</option>
									<option value="20">20</option>
									<option value="40">40</option>';
}

echo '					</select>
							</div>
						</div>
						<div class="form-group" id="divInputBackLogDescription">
							<label for="inputBackLogDescription" class="col-xs-2 col-sm-4 control-label">Description</label>
							<div class="col-xs-7 col-sm-5">
								<textarea type="text"class="form-control" rows="5" name="inputBackLogDescription" id="inputBackLogDescription">' . $row['ProductBacklogcologDescription'] . '</textarea>
							</div>
						</div>
					</form>
					<!-- FIM DO FORMULARIO -->
				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-primary btn-lg" onclick="productBacklog.editBacklog(name);" name="' . $row['productBacklogcolItem'] . '" id="submit">Edit</button>
					<button type="button" class="btn btn-danger btn-lg" onclick="productBacklog.clearModalBackLog();" data-dismiss="modal">Cancel</button>
				</div>';

$receberLinha->close();
$mysqli->close();
?>
