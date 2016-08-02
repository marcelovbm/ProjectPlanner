<?php
session_start();
$userName = $_SESSION['userName'];

include 'connection_mysql.php';

$recebetabela = $mysqli->query("SELECT employeeName, limiteProjetos, employeeFunction
									FROM `Employee`
									WHERE User_email = '$userName'
									AND employeeFunction = 'Scrum Master'");

echo '<option disabled selected value=""> -- select an option -- </option>';

while ($row = mysqli_fetch_array($recebetabela)) {
	if ($row['limiteProjetos'] == 0) {
		echo '<option>' . $row['employeeName'] . '</option>';
	} else {
		echo ' ';
	}
}

echo '';

$mysqli->close();

?>