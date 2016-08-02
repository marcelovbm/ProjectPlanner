<?php

session_start();

include 'connection_mysql.php';

$userEmail = $_POST['inputEmail'];
$password = $_POST['inputPassword'];

//$userName = stripslashes($userName);
//$password = stripslashes($password);

if ($userEmail == '') {
	echo "<p><strong>Email</strong> was not inserted!</p>";
} else {
	if ($password == '') {
		echo "<p><strong>Password</strong> was not inserted!</p>";
	} else {
		$veririficaUser = $mysqli->query("SELECT * FROM `User`
											WHERE email = '$userEmail'
											AND password = '$password'");

		if (mysqli_num_rows($veririficaUser) > 0) {
			$_SESSION['userName'] = $userEmail;
		} else {
			echo "<p><strong>Email or password are wrong</strong></p>";
		}
	}
}
$mysqli->close();
?>
