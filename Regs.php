<?php
	session_start();
	include "config.php";

	if (isset($_POST['registrationBtn'])) {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$Confirmpassword = mysqli_real_escape_string($conn, $_POST['confirm-password']);
		$Department = mysqli_real_escape_string($conn, $_POST['ResDept']);


			$Token = 'qwertyuiopasdfghjklzxcvbnm1234567890!$/()';
			$Token = str_shuffle($Token);
			$Token = Substr($Token, 0, 15);
			

			$hashPassword = password_hash($password, PASSWORD_DEFAULT);	

			$query = "INSERT INTO Accounts (Username, Password, Email, Department, Level, isConfirmed, token) 
					  VALUES('$username', '$hashPassword', '$email', '$Department', 0, 0, '$Token')";
			mysqli_query($conn, $query);

            include PHPMailer\PHPMailer\PHPMailer;
            include PHPMailer\PHPMailer\SMTP;

            require 'phpmailer/vendor/autoload.php';

        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        $mail->SMTPAutoTLS = true;
        $mail->SMTPAuto = true;
        $mail->Host = 'smtp.daredicing.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Username = 'noreply@daredicing.com';
        $mail->Password = 'fyC7~4}v@dCG';
        $mail->setFrom('noreply@daredicing.com', 'admin');
        $mail->addAddress($email, $username);
        $mail->Subject = 'Account Verification';
        $mail->AltBody = 'Verification Email';
        $mail->Body = "Hello, Nero. Thank for signing up on daredicing.com, you will recieve an email shortly.
                    <a href='http://daredicing.com/confirmemail.php?email=$email&token=$token'> </a>

                    By of luck from BigBoiGames Ltd";

        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;
        } else {
            echo 'Message sent!';
        }
            }
?>