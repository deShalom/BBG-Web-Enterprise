<?php

session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include_once 'config.php'; // db connection string
include 'Browser.php';

if (isset($_POST['loginbtn'])) 
{
    if (empty($_POST['username']) || empty($_POST['password'])) 
    {
        $error = "Username or Password is invalid";
    }
    else {
        // Define $username, $password
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        // SQL query to fetch information of registerd users and finds user match.
        //AND Password='$password'--->
        $authquery = ("SELECT UserID, Username, Password, LastLoggedIn Level FROM Accounts WHERE Username='$username'");
        $result = mysqli_query($conn, $authquery);
        $rows = mysqli_num_rows($result);
    
        if ($rows == 1)
        {
            while ($row = mysqli_fetch_array($result))
            {

                if (password_verify ($password,$row['Password']))
                {
	                $_SESSION['login_user'] = $username; // Initializing Session
	                $_SESSION['userID'] = $row['UserID'];
	                $_SESSION['level_user'] = $row['Level'];
                	
		                $date = date('Y-m-d H:i:s'); //now you can save in DB
		                $updateTime = "UPDATE Accounts SET LastLoggedIn = '$date' WHERE username = '$username'";
		                mysqli_query($conn, $updateTime);
		                
		                $_SESSION['LastLogIn'] = $row['LastLoggedIn'];

						$browser = new Browser();
						$browsername = $browser->getBrowser();
 
						$queryBrowserInsert = ("SELECT BrowserName, NumberOfUses FROM Browser WHERE BrowserName = '$browsername'");
						$resultBrowserInsert = mysqli_query($conn, $queryBrowserInsert);
						$rowsBrowserInsert = mysqli_num_rows($resultBrowserInsert);
    
						if ($rowsBrowserInsert == 1)
						{
							while ($rowBrowserInsert = mysqli_fetch_array($resultBrowserInsert))
							{
								$addone = $rowBrowserInsert['NumberOfUses'] + 1;
								$queryBrowserAdd = "UPDATE Browser SET NumberOfUses = '$addone' WHERE BrowserName = '$browsername'";
								$resultToInsertBrowser = mysqli_query($conn, $queryBrowserAdd);


							}
						}
						else
						{
							$queryInsertWholeBrowser = "Insert into Browser (BrowserName, NumberOfUses) VALUES ('$browsername','1')";
							$resultBrowserInsert = mysqli_query($conn, $queryInsertWholeBrowser);
							$resultBrowserInsertPOO = mysqli_query($conn, $queryInsertWholeBrowserPOO);
						}
		
						
                }
            }
            header("location: welcome.php");
            // Redirecting To Other Page
        }
            else
        {
            $error = "Username or Password is invalid";
            echo $error;
        }
        mysqli_close($conn); // Closing Connection
    }
}

?>