<?php
session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}
?>

<?php

// opens a connection to the DB via the config file
    include 'config.php';
    
// Creating a super global variable allowing us to use the data from the html file.
// Creating a boolean variable to let us know if a post has documents attached. With FALSE as default.
    $category = mysqli_real_escape_string($conn, $_POST['category']) ;
    $problem = mysqli_real_escape_string($conn, $_POST['problem']);
    $idea = mysqli_real_escape_string($conn, $_POST['idea']);
    $docupload = FALSE;
    $posttitle = mysqli_real_escape_string($conn, $_POST['posttitle']);
    $ideadept = $_POST['department'];
// Checks if user wants to be anon; if checked return 1, if not return 0.
    if (isset($_POST['anon'])){
    $anon = $_POST['anon'] ? 1 : 0;
    }
    
// Grabs the userID from the sessions.
    $userID = $_SESSION['userID'];
   
// IF File upload statement; gathering the file information, formatting it and sending it to the target directory with a new unique name.

    if (isset($_POST['submitidea']))
    { // Checks if the button "submitidea" has been pressed, "isset" does this for us.
        $docupload = TRUE;
        // Variables assinged to super globals allowing us to utilise the file details.

        $file =$_FILES['fileToUpload']; // $_Files helps us get all the information from the file that we want to upload. - I also use $file for each other variable to shorten the process
        $fileName = $file['name'];      // Same shit as above but instead of writing out $_FILES infront of each variable, I set it to $file for conveniences sake.
        $fileTempName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error']; // this pops up in the file information when uploading it
        $fileType = $file['type'];

        // Setting the target directory for the files.
        $target_dir = ('uploadedDocs/');

        // This seperates the file name and the file extention (its type)(whatever is before and after the ".")
        $fileExt = explode('.',$fileName);

        // This takes the extention of the file, which could be in capital letters, such as JPEG or w/e and makes it all lower case
        // by grabbing it from the last place in the created array above (via the use of explode).
        $fileActualExt = strtolower(end($fileExt));

        // This is an array which sets what file extentions we allow to be uploaded. (add whatever we want to be allowed)
        $allowed = array('jpg','pdf','png','doc','gif','jpeg','tif');
        
        // Checking if uploaded file is allowed by us, file size (10000kbs) check, and unique name changing
        // and error checking with a nested IF and error msgs.
            if (in_array($fileActualExt, $allowed))
            {
                if ($fileSize < 1000000)
                {
                    $fileNameNew = uniqid('', true).".".$fileActualExt; // This creates a unique name for each file and adds the extention back (which is now in lower case).
                    $fileDestination = $target_dir.$fileNameNew;
                    move_uploaded_file($fileTempName, $fileDestination); // Function which uploads the file using the temporary space and our final file destination.  
                    header("Location: index.php?UploadSuccess"); // If all goes well, we are take to the Index page with "UploadSuccess" written in the address bar.              
                }
                else
                {
                    echo "The file you are trying to upload is too big!";
                }               
            }
            else {
                echo "You are trying to upload a file type we do not support!";
            }
    
    }
    else
    {

    }

        

    
    


     // everything within these curly brackets happens upon the "submitidea" button press 

    // my own notes:
    // does the table "Categories" really need to exist? There's no other information on Categories except
    // the name, wouldn't it be easier to just have it as a unique column in table "Posts"?

    // For uploads, would it be easier to make a folder act as a target directory for documents? Rather than creating a table.

    // Does anyone understand how to use Prepared Statements instead of copying "mysql_real_escape_string" infront of every variable? :) shits confusing 


?>