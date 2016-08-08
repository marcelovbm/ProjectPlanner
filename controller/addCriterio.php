<?php
session_start();
include 'connection_mysql.php';

$User_email = $_SESSION['userName'];

$inputNameCriterio = $_POST['inputNameCriterio'];
$inputCriterioPeso = $_POST['inputCriterioPeso'];

$mysqli->query("INSERT INTO Criterios(`criterioName`,`criterioPeso`, `User_email`) VALUES('$inputNameCriterio', '$inputCriterioPeso', '$User_email')");

$tabelaProjects = $mysqli->query("SELECT NameProject
  FROM Project
  WHERE User_email = '$User_email'");

if ($tabelaProjects->num_rows > 0) {
  # code...
  while ($rowProject =  $tabelaProjects->fetch_array(MYSQLI_ASSOC)) {
    # code...
    $thisProject = $rowProject['NameProject'];
    $mysqli->query("INSERT INTO Project_has_Criterios(`Project_NameProject`,`Project_User_email`,`Criterios_criterioName`,`criterioAvaliacao`)
    VALUES('$thisProject','$User_email','$inputNameCriterio',NULL)");
  }
}

$mysqli->close();
?>
