<?php
include 'connection_mysql.php';

session_start();
$userName = $_SESSION['userName'];

$inputProjectName = $_POST['inputProjectName'];
$inputProductOwner = $_POST['inputEditarProductOwner'];
$InputProjectManager = $_POST['inputEditarProjectManager'];
$inputProjectDescription = $_POST['inputProjectDescription'];
$inputEditEndDate = $_POST['inputEditEndDate'];

//SELECIONA O PRODUCT OWNER E PROJECT MANAGER ANTES DA EDICAO
$row = mysqli_fetch_array($mysqli->query("SELECT productOwner, projectManager
											FROM `Project`
											WHERE NameProject = '$inputProjectName'
											AND User_email = '$userName'"));
$owner = $row['productOwner'];
$manager = $row['projectManager'];

//MUDA OS DADOS DE CADA FUNCIONARIO SELECIONADO ANTERIORMENTE
$mysqli->query("SET foreign_key_checks = 0");
$mysqli->query("UPDATE `Employee`
					SET limiteProjetos = '0', Project_NameProject = NULL
					WHERE User_email ='$userName'
					AND Project_NameProject = '$inputProjectName'
					AND employeeName = '$owner'
					OR employeeName = '$manager'");

$mysqli->query("SET foreign_key_checks = 1");

//INSERI OS NOVOS DADOS AO PROJETO
$mysqli->query("UPDATE `Project`
					SET productOwner = '$inputProductOwner',`EndDate`='$inputEditEndDate', `projectManager`='$InputProjectManager',
					`Description`='$inputProjectDescription'
					WHERE NameProject ='$inputProjectName'");

//SELECIONA OS NOVOS FUNCIONARIOS RELACIONADOS AO PROJETO
$rowProject = mysqli_fetch_array($mysqli->query("SELECT productOwner, projectManager
													FROM `Project`
													WHERE NameProject = '$inputProjectName'"));
$rowProductOwner = $rowProject['productOwner'];
$rowProjectManager = $rowProject['projectManager'];

//ATUALIZA OS DADOS DOS FUNCIONARIOS INSERIDOS NO PROJETO
$mysqli->query("UPDATE `Employee`
					SET limiteProjetos = '1', Project_NameProject = '$inputProjectName'
					WHERE User_email ='$userName'
					AND employeeName = '$rowProductOwner'
					OR employeeName = '$rowProjectManager'");

$mysqli->close();
?>