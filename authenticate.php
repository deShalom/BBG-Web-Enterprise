<?php

// Store data in session variables

include 'config.php';

 
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['pass']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT userID, pass FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $pass);
        $stmt->fetch();
        // if account exists, take us to main page, if not, show "incorrect passoword".
        if (password_verify($_POST['password']), $password) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;                         
            // login success, take us to index.php
            header('Location: index.php');
        } else {
            echo 'Incorrect password!';
        }
    } else {
        echo 'Incorrect username!';
    }

    
	$stmt->close();
}
?>
