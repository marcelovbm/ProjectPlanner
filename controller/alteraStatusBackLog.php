<?php
include 'connection_mysql.php';
$inputBackLogName = $_POST['inputBackLogName'];
$status = $_POST['status'];

$mysqli->query("UPDATE `Backlog`
				SET `statusBacklog`='$status'
				WHERE `idBacklog` ='$inputBackLogName'");

$mysqli->close();
?>