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





<?php // code from ideasub.php at the end; gotta add more shit when the db is properly connected!

// SQL statement to insert Post data from the website to the Post db.
        $sqlpost = "INSERT INTO Posts ('Department','Title','Category','Problemtxt','Body','isAnonymous') VALUES ('$ideaDept','$posttitle','$category','$problem','$idea','$anon')";
    
    
    // This runs the mysqli DB connection string found in config.php and my $sql statement above.
        mysqli_query($conn, $sqlpost, $sqldocs);

?>


<?php

if ($fileError === 0)
            {
                if ($fileSize < 10000)
                {
                    $fileNameNew = uniqid('', true).".".$fileActualExt; // This creates a unique name for each file and adds the extention back (which is now in lower case).
                    $fileDestination = $target_dir.$fileNameNew;
                    move_uploaded_file($fileTempName, $fileDestination); // Function which uploads the file using the temporary space and our final file destination.  
                    header("Location: ../index.html?UploadSuccess"); // If all goes well, we are take to the Index page with "UploadSuccess" written in the address bar.
                    // If statement to update the column in Posts table to True if the post has documents attached to it.
                    if ($docupload = TRUE){
                        $sqldoctrue = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('True')";
                        mysqli_query($conn, $sqldoctrue);
                        // Selecting the most recent PostID (which was created 1 line up when updating the boolean) and assigning it to the uploaded documents.
                        $postIDget = "SELECT PostID FROM Posts GROUP BY userID LIMIT 1";  
                        mysqli_query($conn, $postIDget);
                        mysqli_real_escape_string($conn, $postID = $_POST[$postIDget]);
                        // SQL statement to update the Post ID and User ID in the Documents table                        
                        $sqlupdatepost = "INSERT INTO Documents ('FileName','FileType','PostID','UserID') VALUES ('$fileNameNew','$fileActualExt','$postID','$userID')"; // grabbing userID from session (whoever is logged in)
                        mysqli_query($conn, $sqlupdatepost);
                    }
                    else{
                        $sqldoctfalse = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('False')";
                        mysqli_query($conn, $sqldocfalse);
                    }
                }    
                else{
                    echo "The file you are trying to upload is too big!";
                }
            }
            else {
                echo "There is an error with the upload of your files! Please try again.";

?>



<?php

// for ideasub
// If statement to update the column in Posts table to True if the post has documents attached to it.
if ($docupload = TRUE){
    $sqldoctrue = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('True')";
    mysqli_query($conn, $sqldoctrue);
    // Selecting the most recent PostID (which was created 1 line up when updating the boolean) and assigning it to the uploaded documents.
    $postIDget = "SELECT PostID FROM Posts GROUP BY userID LIMIT 1";  
    mysqli_query($conn, $postIDget);
    mysqli_real_escape_string($conn, $postID = $_POST[$postIDget]);
    // SQL statement to update the Post ID and User ID in the Documents table                        
    $sqlupdatepost = "INSERT INTO Documents ('FileName','FileType','PostID','UserID') VALUES ('$fileNameNew','$fileActualExt','$postID','$userID')"; // grabbing userID from session (whoever is logged in)
    mysqli_query($conn, $sqlupdatepost);

?>