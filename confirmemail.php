<?php
	include "config.php";

	if(isset($_GET['email']) || isset($_GET['token']))
	{
		$email = mysqli_real_escape_string($conn, $_GET['email']);
		$token = mysqli_real_escape_string($conn, $_GET['token']);

		$result = mysqli_query($conn, "SELECT Email, token  FROM Accounts WHERE Email='$email' AND token='$token' AND isConfirmed=0");
		$query = mysqli_fetch_assoc($result)
		if($query->num_rows > 0)
		{
			mysqli_query("UPDATE Accounts SET token='', isConfirmed=0 WHERE Email='$email'");
			echo "working";
			//header("location: verified.php");
		} else
		{
			header("location: unverified.php");
		}
	}
?>