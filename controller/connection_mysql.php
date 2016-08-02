<?php
/*
 * These are the database login details
 */
define("HOST", "localhost"); // The host you want to connect to.
define("USER", "root"); // The database username.
define("PASSWORD", "magrinelli*92"); // The database password.
define("DATABASE", "teste"); // The database name.

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

define("SECURE", FALSE); // FOR DEVELOPMENT ONLY!!!!

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

/* VERIFICA A CONEXAO COM O SERVIDOR */
if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>
