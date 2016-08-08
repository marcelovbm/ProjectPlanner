<?php

session_start();
include 'connection_mysql.php';

$projectName = $_POST['inputProjectName'];
$startDate = $_POST['daterangeStart'];
$endDate = $_POST['daterangeEnd'];
$projectDescription = $_POST['inputProjectDescription'];
$userName = $_SESSION['userName'];

$idTeam = mt_rand();

if ($projectName == '') {
	echo "<p><strong>Project Name</strong> não foi inserido!</p>";
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
					$mysqli->query("INSERT INTO `Project`(`NameProject`,`StartDate`,`EndDate`,`projectManager`,`Description`,`User_email`)
													VALUES('$projectName','$startDate','$endDate', NULL ,'$projectDescription','$userName')");
					$mysqli->query("INSERT INTO `Team` (`idTeam`,`productOwner`,`scrumMaster`,`Project_NameProject`,`Project_User_email`)
													VALUES('$idTeam','','', '$projectName','$userName')");
					$mysqli->query("INSERT INTO Sprint (idSprint, sprintStatus, Project_NameProject, Project_User_email)
													VALUES ('1', null, '$projectName', '$userName')");

					$tabelaCriterios = $mysqli->query("SELECT criterioName
					FROM  Criterios
					WHERE User_email = '$userName'");
					if ($tabelaCriterios->num_rows > 0) {
						# code...
						while ($rowCriterio =  $tabelaCriterios->fetch_array(MYSQLI_ASSOC)) {
							# code...
							$thisCriterio = $rowCriterio['criterioName'];
							$mysqli->query("INSERT INTO Project_has_Criterios (Project_NameProject, Project_User_email, Criterios_criterioName, criterioAvaliacao)
					    VALUES('$projectName', '$userName', '$thisCriterio', NULL)");
						}
					}
					echo "<p><strong>Project cadastrado com sucesso!</strong></p>";
				}
			}
		}
	}
$mysqli->close();
?>
