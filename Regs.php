<?php
	session_start();
	include "config.php";
    // Load Composer's autoloader

    $message = "";


	if (isset($_POST['registrationBtn']))
    {
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn ,$_POST['email']);
		$password = mysqli_real_escape_string($conn ,$_POST['password']);
		$Confirmpassword = mysqli_real_escape_string($conn ,$_POST['confirm-password']);
		$Department = mysqli_real_escape_string($conn ,$_POST['ResDept']);

        if($username == "" || $email == "" || $password !== $Confirmpassword || $Department == "")
        {
            $messages = "Check Fields" ;
        }  else
        {
               $mysqli->query = ("SELECT * FROM Accounts WHERE Email= '$email'");
               if($mysqli->num_rows > 0)
               {
                     $message = "Email already in database";
               }
               else
               {
                    $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!$/()';
			        $token = str_shuffle($token);
			        $token = Substr($token, 0, 15);

			        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                    $conn->query($query = "INSERT INTO Accounts (Username, Password, Email, Department, Level, isConfirmed, token)
					  VALUES('$username', '$hashPassword', '$email', '$Department', 0, 0, '$token')

                      ");

                      include "PHPMailer/PHPMailer.php";
                      include_once "PHPMailer/Exception.php";


                     $mail = new PHPMailer(true);

                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host = 'n3plcpnl0054.prod.ams3.secureserver.net';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'noreply@daredicing.com';
                    $mail->Password   = 'fyC7~4}v@dCG';
                    $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
                    $mail->Port       = 587 ;

                    $mail->SetFrom('Noreply@DareDicing.com', 'Noreply');
                    $mail->addAddress($email, $username);
                    $mail->isHTML(true);
                    $mail->Subject = 'Sign Up Link';
                    $mail->Body = "Hello, $username. Thank for signing up on daredicing.com, you will recieve an email shortly.
                    <a href=\"http://daredicing.com/confirmemail.php?email=$email&token=$Token\">Click Here</a><p> Best of luck from BigBoiGames Ltd";

                    if($mail->send())
                    {
                      $message = "You have been registred! Please verify your email!";

                    }
                    else
                    {
                      $message = "Something went wrong";
                    }

               }
        }
    };

?>