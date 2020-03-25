<?php
session_start();
?>

<?php
include_once 'config.php';
include_once 'session.php';

$sql = "SELECT * FROM accounts;";
$result =  mysqli_query($conn, $sql);
$resultcheck = mysqli_num_rows($result);

if ($resultcheck > 0){
    while ($row = mysqli_fetch_assoc($result)){ // data imported from db is saved as array called $row
        echo $row['Username'].'<br>'.$row['pass']; // displays everything under "Username" and "pass"

    }

}

?>



// original authenticate:


<?php
    session_start();
?>

<?php

// Store data in session variables

include_once 'config.php';

 
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (isset($_POST['loginbtn']))
{
    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT userID, username, pass FROM accounts WHERE username = ?')) 
    {
	    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	    $stmt->bind_param('s', $_POST['username'], $_POST['pass']);
	    $stmt->execute();
	    // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
        
         if ($stmt->num_rows > 0) {
            $stmt->bind_result($userid, $password);
            $stmt->fetch();
            // if account exists, take us to main page, if not, show "incorrect passoword".
            if (password_verify($_POST['password']). $password) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $userid;
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
}
?>






// og session



<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php

$_SESSION["loggedin"] = true;
$_SESSION["userID"] = $userid;
$_SESSION["username"] = $username;
echo "Session variables are set.";
?>

</body>
</html>

