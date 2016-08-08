<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$nameProject = $_POST['name'];

echo '<div class="modal-header btn-primary">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title text-center" id="myModalLabel">Project Manager</h2>
			</div>
			<div class="modal-body">
				<!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
				<div id="mybox" class="alert alert text-center hide" role="alert"></div>
				<!-- FIM CAIXA DE ALERTA -->
				<!-- FORMULARIO DO MODAL DE CADASTRAR -->
				<form class="form-horizontal" role="form" name="editarProjectManager" id="editarProjectManager" method="GET">
					<div class="form-group" id="divInputProjectManager">
						<label for="inputProjectManager" class="col-xs-2 col-sm-4 control-label">Project Manager</label>
						<div class="col-xs-7 col-sm-5">
							<select class="form-control" name="inputEditarProjectManager" id="inputEditarProjectManager">';

$recebeManager = $mysqli->query("SELECT projectManager FROM Project WHERE User_email = '$userName' AND NameProject = '$nameProject'");
while ($rowManager = $recebeManager->fetch_array(MYSQLI_ASSOC)) {
	if ($rowManager['projectManager'] == '') {
    echo '<option disabled selected value=""> -- select an option -- </option>';
	} else {
    echo '<option value="' . $rowManager['projectManager'] . '">' . $rowManager['projectManager'] . '</option>';
  }
}

$recebeOwner = $mysqli->query("SELECT employeeName, limiteProjetos, employeeFunction FROM Employee WHERE User_email = '$userName' AND employeeFunction = 'Project Manager'");

while ($rowOwner = $recebeOwner->fetch_array(MYSQLI_ASSOC)) {
	if ($rowOwner['limiteProjetos'] == 0) {
					echo '<option value="' . $rowOwner['employeeName'] . '">' . $rowOwner['employeeName'] . '</option>';
	}
}
echo 				'	</select>
						</div>
					</div>
				</form>
				<!-- FIM DO FORMULARIO -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" name="'. $nameProject .'" id="done" onclick="project.editProjectManager(name);">Select</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
			</div>';

$mysqli->close();
?>
