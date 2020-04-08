<?php
	include "config.php";

if(!isset($_GET['email']) || !isset($_GET['token']))
{
	header('Location: /registration.php');
	exit();
}
else {
	$email = mysqli_real_escape_string($conn, $_GET['email']);
	$token = mysqli_real_escape_string($conn, $_GET['token']);

	$query = "SELECT ID FROM Accounts WHERE Email = '$email' and token='$token' AND isConfirmed=0";

	if($query->num_rows > 0)
	{
		$query = ("UPDATE Accounts SET  token='' AND isConfirmed=1");
		echo "Your account is now verified.";
	} else
	{
		echo "something went wrong";
	}
}

?>