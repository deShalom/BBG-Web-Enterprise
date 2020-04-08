<?php
	include "config.php";

if(!isset($_GET['email']) || !isset($_GET['token']))
{
	header('Location: /registation.php');
	exit();
}
else {
	$email = mysqli_real_escape_string($conn, $_GET['email']);
	$Token = mysqli_real_escape_string($conn, $_GET['token']);
	
	$query = ("SELECT ID FROM Accounts WHERE Email = '$email' and token='$Token' AND isConfirmed=0");

	if($sql->num_rows > 0)
	{
		$query = ("UPDATE Accounts SET isConfirmed=1 AND token=''");
		redirect();
	} else 
	{
		redirect();
	}
}

?>