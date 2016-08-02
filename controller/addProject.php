<?php

session_start();
include 'connection_mysql.php';

$projectName = $_POST['inputProjectName'];
$inputProductOwner = $_POST['inputProductOwner'];
$inputProjectManager = $_POST['inputProjectManager'];
$startDate = $_POST['daterangeStart'];
$endDate = $_POST['daterangeEnd'];
$projectDescription = $_POST['inputProjectDescription'];
$userName = $_SESSION['userName'];

$idTeam = mt_rand();

if ($projectName == '') {
	echo "<p><strong>Project Name</strong> não foi inserido!</p>";
} else {
	if ($inputProductOwner == '') {
		echo "<p><strong>Product Owner</strong> não foi inserido!</p>";
	} else {
		if ($inputProjectManager == '') {
			echo "<p><strong>Project Manager</strong> não foi inserido!</p>";
		} else {
			if ($startDate == '') {
				echo "<p><strong>Start date</strong> não foi inserido!</p>";
			} else {
				if ($endDate == '') {
					echo "<p><strong>End date</strong> não foi inserido!</p>";
				} else {
					$veririficaProjectAdmin = $mysqli->query("SELECT NameProject, User_email FROM Project WHERE NameProject = '$projectName' AND User_email = '$userName'");
					$verificarProjetosEmployee = $mysqli->query("SELECT User_email FROM Employee WHERE employeeEmail = '$userName' AND Project_NameProject = '$projectName'");
					if ($veririficaProjectAdmin->num_rows > 0 || $verificarProjetosEmployee->num_rows > 0) {
						echo "<p><strong>Project já existe!</strong></p>";
					} else {
						$mysqli->query("INSERT INTO `Project`(`NameProject`,`StartDate`,`EndDate`,`productOwner`,`projectManager`,`Description`,`User_email`)
														VALUES('$projectName','$startDate','$endDate','$inputProductOwner','$inputProjectManager','$projectDescription','$userName')");
						$mysqli->query("INSERT INTO `Team` (`idTeam`,`productOwner`,`scrumMaster`,`Project_NameProject`,`Project_User_email`)
														VALUES('$idTeam','$inputProductOwner','', '$projectName','$userName')");
						$mysqli->query("UPDATE `Employee` SET limiteProjetos = '1', Project_NameProject = '$projectName' WHERE employeeName = '$inputProductOwner' OR employeeName = '$inputProjectManager'");
						$mysqli->query("INSERT INTO Sprint (idSprint, sprintStatus, Project_NameProject, Project_User_email)
														VALUES ('1', null, '$projectName', '$userName')");
						echo "<p><strong>Project cadastrado com sucesso!</strong></p>";
					}
				}
			}
		}
	}
}
$mysqli->close();
?>
