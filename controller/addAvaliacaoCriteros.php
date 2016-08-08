<?php
session_start();
include 'connection_mysql.php';

$User_email = $_SESSION['userName'];
$myData = $_POST['myData'];
$inputProjectName = $myData['inputProjectName'];
$array = array_keys($myData);

for ($i = 0; $i < (count($array) - 1); $i++) {
  $avaliacao = $myData[$array[$i]];
  $criterioName = $array[$i];
  if ($avaliacao == '') {
    $mysqli->query("UPDATE `Project_has_Criterios`
    SET criterioAvaliacao = NULL
    WHERE Project_NameProject = '$inputProjectName'
    AND Project_User_email = '$User_email'
    AND Criterios_criterioName = '$criterioName'");
  } else {
    $mysqli->query("UPDATE `Project_has_Criterios`
    SET criterioAvaliacao = '$avaliacao'
    WHERE Project_NameProject = '$inputProjectName'
    AND Project_User_email = '$User_email'
    AND Criterios_criterioName = '$criterioName'");
  }
}

$mysqli->close();
?>
