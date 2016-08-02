<?php
include 'connection_mysql.php';

$userName = $_POST['inputUsername'];
$email = $_POST['inputEmail'];
$password = $_POST['inputPassword'];
$passwordConfirm = $_POST['inputPasswordConfirmed'];
if ($userName == '') {
	echo "<p><strong>User Name</strong> was not inserted!</p>";
} else {
	if ($email == '') {
		echo "<p><strong>Email</strong> was not inserted!</p>";
	} else {
		if ($password == '') {
			echo "<p><strong>Password</strong> was not inserted!</p>";
		} else {
			if ($passwordConfirm == '') {
				echo "<p><strong>Confirm your password</strong> was not inserted!</p>";
			} else {
				$veririficaUser = $mysqli->query("SELECT *
												FROM `User`
												WHERE email = '$email'");

				if (mysqli_num_rows($veririficaUser) > 0) {
					echo "<p><strong>Email has already been used!</strong></p>";
				} else {
					if ($password == $passwordConfirm) {
						$mysqli->query("INSERT INTO User(userName,email,password)
										values('$userName','$email','$password')");

						echo "<p><strong>User successfully registered!</strong></p>";
					} else {
						echo "<p><strong>Password and Confirm your password are not the same!</strong></p>";
					}
				}
			}
		}
	}
}

$mysqli->close();

?>
