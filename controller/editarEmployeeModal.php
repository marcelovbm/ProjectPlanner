<?php

session_start();
include 'connection_mysql.php';
$userName = $_SESSION['userName'];
$employeeEmail = $_POST['employeeEmail'];

$receberLinha = $mysqli->query("SELECT employeeEmail, employeeName, employeeFunction, User_email, Project_NameProject
								FROM Employee
								WHERE User_email = '$userName'
								AND employeeEmail = '$employeeEmail'");

$row = $receberLinha->fetch_array(MYSQLI_ASSOC);

echo 	'<div class="modal-header btn-primary">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h2 class="modal-title text-center" id="myModalLabel">Edit Employee</h2>
			</div>
			<div class="modal-body">
				<div id="myboxEditarEmployee" class="alert text-center hide" role="alert"></div>
					<form class="form-horizontal" role="form" name="cadEmployee" id="eidtarEmployee" method="POST">
						<div class="form-group" id="divInputNameEmployee">
							<label for="inputNameEmployee" class="col-xs-2 col-sm-4 control-label">Name</label>
							<div class="col-xs-7 col-sm-5">
								<input type="text" class="form-control " id="inputNameEmployee" name="inputNameEmployee" placeholder="Name" required="" autofocus="" value="' . $row['employeeName'] . '">
							</div>
						</div>
						<div class="form-group " id="divInputEmailEmployee">
							<label for="inputEmailEmployee" class="col-xs-3 col-sm-4 control-label">Email</label>
							<div class="col-xs-7 col-sm-5">
								<input value="' . $row['employeeEmail'] . '"type="text" class="form-control" disabled="disabled" placeholder="Email" required="" autofocus="">
								<input value="' . $row['employeeEmail'] . '"type="hidden" class="form-control" id="inputEmailEmployee" name="inputEmailEmployee" placeholder="Email" required="" autofocus="">
							</div>
						</div>
						<div class="form-group" id="divInputEmployeeFunction">
							<label for="inputEmployeeFunction" class="col-xs-2 col-sm-4 control-label">Function</label>
							<div class="col-xs-7 col-sm-5">
								<select class="form-control" id="inputEmployeeFunction" name="inputEmployeeFunction">';
if ($row['employeeFunction'] == "Scrum Master") {
	echo '					<option value="Scrum Master"> Scrum Master</option>
									<option value="Project Manager">Project Manager</option>
									<option value="Product Owner">Product Owner</option>
									<option value="Development Team">Development Team</option>
								</select>';
} else if ($row['employeeFunction'] == "Project Manager") {
	echo '					<option value="Project Manager">Project Manager</option>
									<option value="Scrum Master"> Scrum Master</option>
									<option value="Product Owner">Product Owner</option>
									<option value="Development Team">Development Team</option>
								</select>';
} else if ($row['employeeFunction'] == "Product Owner") {
	echo '					<option value="Product Owner">Product Owner</option>
									<option value="Project Manager">Project Manager</option>
									<option value="Scrum Master"> Scrum Master</option>
									<option value="Development Team">Development Team</option>
								</select>';
} else {
	echo '					<option value="Development Team">Development Team</option>
									<option value="Product Owner">Product Owner</option>
									<option value="Project Manager">Project Manager</option>
									<option value="Scrum Master"> Scrum Master</option>
								</select>';
}
echo '				</div>
						</div>
					</form>
					<!-- FIM DO FORMULARIO -->
				</div>
				<div class="modal-footer ">
					<button type="button" name="submit" id="submit" onclick="employee.editarEmployee();" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-danger" onclick="employee.clearModalEmployee();" data-dismiss="modal">Cancel</button>
				</div>';
$receberLinha->close();
$mysqli->close();
?>
