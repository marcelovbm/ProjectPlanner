<?php

session_start();
$userName = $_SESSION['userName'];
include 'connection_mysql.php';

$nameProject = $_POST['name'];

$receberLinha = $mysqli->query("SELECT * FROM `Project` WHERE  NameProject = '$nameProject'");
$row = mysqli_fetch_array($receberLinha);

echo '
		<div class="modal-header btn-primary">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h2 class="modal-title text-center" id="myModalLabel">Edit the project</h2>
		</div>
		<div class="modal-body">
			<!-- CAIXA DE ALERTA NO MODAL DE CADASTRO -->
			<div id="mybox" class="alert alert text-center hide" role="alert"></div>
			<form class="form-horizontal" role="form" name="editarProject" id="editarProject" method="POST">
				<div class="form-group" id="divInputEditProjectName">
					<label for="inputEditProjectName" class="col-xs-2 col-sm-4 control-label">Project Name</label>
					<div class="col-xs-7 col-sm-5">
						<input value="' . $row['NameProject'] . '"type="text" class="form-control " id="inputEditProjectName" name="inputEditProjectName" disabled="disabled" placeholder="Project Name" required="" autofocus="">
					</div>
				</div>				
				<div class="form-group" id="divInputEditStarDate">
					<label for="inputEditStartDate" class="col-xs-3 col-sm-4 control-label">Start Date</label>
					<div class="col-xs-7 col-sm-5">
						<input  value="' . $row['StartDate'] . '" type="date" class="form-control" id="inputEditStartDate" name="inputEditStartDate">
					</div>
				</div>
				<div class="form-group" id="diveInputEditEndtDate">
					<label for="inputEditEndDate" class="col-xs-3 col-sm-4 control-label">End Date</label>
					<div class="col-xs-7 col-sm-5">
						<input  value="' . $row['EndDate'] . '" type="date" name="inputEditEndDate" id="inputEditEndDate" class="form-control" placeholder="MM/DD/YYYY"/>
					</div>
				</div>
				<div class="form-group" id="divDescription">
					<label for="inputProjectDescription" class="col-xs-2 col-sm-4 control-label">Description</label>
					<div class="col-xs-7 col-sm-5">
						<textarea type="text"class="form-control" rows="5" name="inputProjectDescription" id="inputProjectDescription">' . $row['Description'] . '</textarea>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer ">
			<button type="button" name="done" id="done"onclick="project.editarProjeto();" class="btn btn-primary">Edit</button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" onClick="project.removerEditarProject();">Cancelar</button>
		</div>';
$mysqli->close();
?>
