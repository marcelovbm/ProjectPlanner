<?php
include 'connection_mysql.php';
session_start();
$userName = $_SESSION['userName'];
$inputProjectName = $_POST['inputProjectName'];
$inputEditarProductOwner = $_POST['inputEditarProductOwner'];

/*$mysqli->query("UPDATE `Team`
				SET `productOwner` = '$inputEditarProductOwner'
				WHERE `Project_NameProject` ='$inputProjectName'");
*/
$recebeTabela = $mysqli->query("SELECT productOwner FROM Project WHERE NameProject = '$inputProjectName' AND User_email = '$userName'");

$row = $recebeTabela->fetch_array(MYSQLI_ASSOC);

$owner = $row['productOwner'];
//MUDA OS DADOS DE CADA FUNCIONARIO SELECIONADO ANTERIORMENTE
$mysqli->query("SET foreign_key_checks = 0");

$mysqli->query("UPDATE Employee SET limiteProjetos = '0', Project_NameProject = NULL WHERE User_email ='$userName' AND Project_NameProject = '$inputProjectName' AND employeeName = '$owner'");

$mysqli->query("SET foreign_key_checks = 1");

//INSERI OS NOVOS DADOS AO PROJETO
$mysqli->query("UPDATE Project SET productOwner = '$inputEditarProductOwner' WHERE NameProject ='$inputProjectName'");

//SELECIONA OS NOVOS FUNCIONARIOS RELACIONADOS AO PROJETO
$recebeOwner = $mysqli->query("SELECT productOwner FROM Project WHERE NameProject = '$inputProjectName'");

$rowProject = $recebeOwner->fetch_array(MYSQLI_ASSOC);

$rowProductOwner = $rowProject['productOwner'];

//ATUALIZA OS DADOS DOS FUNCIONARIOS INSERIDOS NO PROJETO
$mysqli->query("UPDATE Employee SET limiteProjetos = '1', Project_NameProject = '$inputProjectName' WHERE User_email ='$userName' AND employeeName = '$rowProductOwner'");

$mysqli->query("UPDATE Team SET productOwner = '$rowProductOwner' WHERE Project_User_email ='$userName' AND Project_NameProject = '$inputProjectName'");

$recebeTabela->close();
$recebeOwner->close();
$mysqli->close();
?>
