<?php
    session_start();

// opens a connection to the DB via the config file
    include_once 'config.php';
    include_once 'session.php';

    
// Creating a super global variable allowing us to use the data from the html file.
// Creating a boolean variable to let us know if a post has documents attached. With FALSE as default.
    $category = $_POST['category'];
    $problem = $_POST['problem'];
    $idea = $_POST['idea'];
    $docupload = FALSE;
    $posttitle = $_POST['posttitle'];
    $ideadept = $_POST['ideaDept'];
// Checks if user wants to be anon; if checked return 1, if not return 0.
    $anon = $_POST['anon'] ? 1 : 0;
// Grabs the userID from the sessions.
    $userID = $_SESSION['userID'];
   


// IF File upload statement; gathering the file information, formatting it and sending it to the target directory with a new unique name.

    if (isset($_POST['submitidea'])){ // Checks if the button "submitidea" has been pressed, "isset" does this for us.

        // Variables assinged to super globals allowing us to utilise the file details.

        $file = $_FILES['fileToUpload']; // $_Files helps us get all the information from the file that we want to upload.
        $fileName = $file['name'];      // Same shit as above but instead of writing out $_FILES infront of each variable, I set it to $file for conveniences sake.
        $fileTempName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

    // Setting the target directory for the files.
        $target_dir = "whatevertheuploadfolderis/";

    // This seperates the file name and the file extention (its type)(whatever is before and after the ".")
        $fileExt = explode('.'. $fileName);

 

    // This takes the extention of the file, which could be in capital letters, such as JPEG or w/e and makes it all lower case
    // by grabbing it from the last place in the created array above (via the use of explode).
        $fileActualExt = strtlower(end($fileExt));

    // This is an array which sets what file extentions we allow to be uploaded. (add whatever we want to be allowed)
        $allowed = array('jpg','pdf','png','doc','gif','jpeg','tif');
        
    // Checking if uploaded file is allowed by us, file size (10000kbs) check, and unique name changing
    // and error checking with a nested IF and error msgs.
        if (in_array($fileActualExt, $allowed)){
            if ($fileError === 0){
                if ($fileSize < 10000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt; // This creates a unique name for each file and adds the extention back (which is now in lower case).
                    $fileDestination = $target_dir.$fileNameNew;
                    move_uploaded_file($fileTempName, $fileDestination); // Function which uploads the file using the temporary space and our final file destination.  
                    header("Location: ../index.html?UploadSuccess") // If all goes well, we are take to the Index page with "UploadSuccess" written in the address bar.
                    // If statement to update the column in Posts table to True if the post has documents attached to it.
                    if ($docupload = TRUE){
                        $sqldoctrue = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('True')";
                        mysqli_query($conn, $sqldoctrue);
                        // Selecting the most recent PostID (which was created 1 line up when updating the boolean) and assigning it to the uploaded documents.
                        $postIDget = "SELECT PostID FROM Posts GROUP BY userID LIMIT 1";  
                        mysqli_query($conn, $postIDget)
                        $postID = $_POST[$postIDget];
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
            }
        }
        else {
            echo "You are trying to upload a file type we do not support!";
        }

    }
    
    
        
    // SQL statement to insert Post data from the website to the Post db.
        $sqlpost = "INSERT INTO Posts ('Department','Title','Category','Problemtxt','Body','isAnonymous') VALUES ('$ideaDept','$posttitle','$category','$problem','$idea','$anon')";
    
    
    // This runs the mysqli DB connection string found in config.php and my $sql statement above.
        mysqli_query($conn, $sqlpost, $sqldocs);
    
    


    } // everything within these curly brackets happens upon the "submitidea" button press 

    // my own notes:
    // does the table "Categories" really need to exist? There's no other information on Categories except
    // the name, wouldn't it be easier to just have it as a unique column in table "Posts"?

    // For uploads, would it be easier to make a folder act as a target directory for documents? Rather than creating a table.

    // Does anyone understand how to use Prepared Statements instead of copying "mysql_real_escape_string" infront of every variable? :) shits confusing 


?>




<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>GRE: Idea Submission</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<style>

    .page {
        align-content: center;
    }

    html {
        width: 100%;
        height: 100%;
    }

    body {
        width: 100%;
        height: 100%;
    }

    .navB {
    }

    .navR {
    }

    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
    }

    .bI {
        width: 100%;
    }

    #inputbox {
        height:200px;
        width:800px;
        font-size:12pt;
    }

    #titlebox {
        height:50px;
        width:800px;
        font-size:18pt;
    }

    @media only screen and (max-width:800px) {
        /* For tablets: */
        .main {
            width: 80%;
            padding: 0;
        }

        .right {
            width: 100%;
        }
    }

    @media only screen and (max-width:500px) {
        /* For mobile phones: */
        .menu, .main, .right, .flex-container, .bI, .hT {
            width: 100%;
            flex-direction: column;
        }
    }
</style>

<body>

    

    <!-- Page Content -->
    <div class="page w3-content" style="max-width:1500px">

        <!-- Gre header -->
        <div class="w3-white w3-border-bottom w3-center">
            <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
        </div>

        <!--Header of the page-->
        <h1 align="center">Your Idea Submission Form</h1>

        <!-- This is the form for the Ideas Submission area -->
        <form action="PHP/IdeaSubmission.php" method="post" class="w3-container w3-margin-top w3-margin-right w3-margin-left w3-margin-bottom w3-card-4 w3-dark-grey" enctype="multipart/form-data">
            <!--I've seperated each main CW spec using a field set to ensure that we have everything we need-->
            <!--Inluced everything within a form for now for simplicity; straight up copied Elion's form style to make it all look the same smile xd finger my ass its 2am I should have stopped playing tarkov-->
            <!--The Header of the page-->
            <h3 class="w3-center">Enter and submit your idea on how we can improve our services!</h3>
            <br />
            <!--Fieldset including a dropdown menu to select a Category-->
            <fieldset>
                <p class="w3-center">
                    <label for="IdeaCategory">Choose a Category:</label>
                    <select id="IdeaCategory" name="category" class="w3-dropdown-click">
                        <option value="cat1">category1</option>
                        <option value="cat2">cat2</option>
                        <option value="cat3">cat3</option>
                        <option value="cat4">cat4</option>
                    </select>
                    <label for="IdeaDept">Choose a Department:</label>
                    <select id="ideaDept" name="department" class="w3-dropdown-click">
                        <option value="cat1">Department1</option>
                        <option value="cat2">Dept2</option>
                        <option value="cat3">Dept3</option>
                        <option value="cat4">Dept4</option>
                    </select>
                </p>
            </fieldset>
            
            <br />
            <!--Setting the title of the Post-->
            <fieldset>
                <p class="w3-center">
                    <label for="fname">Title of Post</label><br />
                    <textarea class="w3-center" type=text name=posttitle placeholder="Title of Post: " id="titlebox" required></textarea>
                </p>
            </fieldset>
            <br />

            <!--Fieldset including the ability for the user to describe the problem and enter their idea-->
            <fieldset>
                <p class="w3-center">
                    <label for="fname">What is the current problem?:</label><br />
                    <textarea class="w3-left-align" type="text" name="problem" placeholder="Type Here" id="inputbox" required></textarea>
                </p>

                <p class="w3-center">
                    <label for="fname">Describe Your Idea on how to fix the problem here:</label><br />
                    <textarea class="w3-left-align" type="text" name="idea" placeholder="Type Here" id="inputbox" required></textarea>
                </p>
            </fieldset>
            <br />
            <!--Fieldset for Terms and Conditions; made sure that it is a "required" attribute as said in CW spec-->
            <fieldset>
                <p class="w3-left-align">Please read and agree to the Terms and Conditions: (add link later to show T&Cs)</p>
                <p><input type="checkbox" required name="terms"> I accept the <u>Terms and Conditions</u></p>
                <br />
            <!--Added a button for annonimity. Allowing the user to tick the box if they wish to post as annon.-->
                <p class="w3-left-align">Do you wish to be annonymous?</p>
                <p><input type="checkbox" name="anon" value="1"> Tick if you wish to be an annonymous poster.</p>
            </fieldset>
            <br />
            <!--Fieldset allowing the user to upload multiple files as well as Submit their idea; again if some required fields are empty, pop ups will show-->
            <fieldset>
                <p class="w3-left-align">Select files to upload and upload your idea:</p>
                <input type="file" name="fileToUpload" id="fileToUpload" multiple>
                <input type="submit" value="Submit Your Idea" name="submitidea">
            </fieldset>
            <br />

        </form>

        <br />
        <br />
        <br />
        <br />
        <br />

        <div class="footer w3-dark-gray">
            <p><span style='border-bottom:2px white solid;'>Other useful links!</span></p>
            <i class="fab fa-snapchat-ghost w3-margin-right"></i>
            <i class="fab fa-twitter w3-margin-right"></i>
            <i class="fab fa-facebook-f w3-margin-right"></i>
            <i class="fab fa-instagram w3-margin-right"></i>
        </div>
</body>
</html>
