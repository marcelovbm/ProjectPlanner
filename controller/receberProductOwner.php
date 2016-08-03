<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$nameProject = $_POST['name'];

echo '<div class="modal-header btn-primary">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title text-center" id="myModalLabel">Product Owner</h2>
			</div>
			<div class="modal-body">
				<!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
				<div id="mybox" class="alert alert text-center hide" role="alert"></div>
				<!-- FIM CAIXA DE ALERTA -->
				<!-- FORMULARIO DO MODAL DE CADASTRAR -->
				<form class="form-horizontal" role="form" name="editarProductOwner" id="editarProductOwner" method="GET">
					<div class="form-group" id="divInputProductOwner">
						<label for="inputProductOwner" class="col-xs-2 col-sm-4 control-label">Product Owner</label>
						<div class="col-xs-7 col-sm-5">
							<select class="form-control" name="inputEditarProductOwner" id="inputEditarProductOwner">
								<option disabled selected value=""> -- select an option -- </option>';

$recebeOwner = $mysqli->query("SELECT employeeName, limiteProjetos, employeeFunction FROM Employee WHERE User_email = '$userName' AND employeeFunction = 'Product Owner'");

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
				<button type="button" class="btn btn-primary" name="done" id="done"onclick="team.editProductOwner();">Select</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal" onClick="team.removerEditarProductOwner();">Cancelar</button>
			</div>';

$mysqli->close();
?>
