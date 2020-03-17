<?php
// opens a connection to the DB via the config file
    include_once 'config.php';

// Creating a super global variable allowing us to use the data from the html file.
// Creating a boolean variable to let us know if a post has documents attached. With FALSE as default.
    $category = $_POST['category'];
    $problem = $_POST['problem'];
    $idea = $_POST['idea'];
    $docupload = FALSE;
// Checks if user wants to be anon; if checked return 1, if not return 0.
    $anon = $_POST['anon'] ? 1 : 0;


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
        $allowed = array('jpg','pdf');
        
    // Checking if uploaded file is allowed by us, file size (10000kbs) check, and unique name changing
    // and error checking with a nested IF and error msgs.
        if (in_array($fileActualExt, $allowed)){
            if ($fileError === 0){
                if ($fileSize < 10000){
                    $fileNameNew = uniqid('', true).".".$fileActualExt; // This creates a unique name for each file and adds the extention back (which is now in lower case).
                    $fileDestination = $target_dir.$fileNameNew;
                    move_uploaded_file($fileTempName, $fileDestination); // Function which uploads the file using the temporary space and our final file destination.
                    header("Location: ../index.html?UploadSuccess") // If all goes well, we are take to the Index page with "UploadSuccess" written in the address bar.
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

    // If statement to update the column in Posts table to True if the post has documents attached to it.

    if ($docupload = TRUE){
        $sqldoctrue = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('True')";
        mysqli_query($mysqli, $sqldoctrue);
    }else{
        $sqldoctfalse = "INSERT INTO Posts ('isUploadedDocuments') VALUES ('False')";
        mysqli_query($mysqli, $sqldocfalse);
    }



// SQL statement to insert Post data from the website to the Post db.
    $sqlpost = "INSERT INTO Posts (needdbfieldnamesplease) VALUES ('$category','$problem','$idea','$anon')";

// SQL statement to update the Documents table.
    $sqldocs = "INSERT INTO Documents () VALUES ()";

// This runs the mysqli DB connection string found in config.php and my $sql statement above.
    mysqli_query($mysqli, $sqlpost, $sqldocs);


// once code is ran, takes us back to index.html and a message "IdeaSubmittedGratz" is displayed.
    header("Location: ../index.html?IdeaIsSubmitted!");






    // my own notes:
    // does the table "Categories" really need to exist? There's no other information on Categories except
    // the name, wouldn't it be easier to just have it as a unique column in table "Posts"?


?>

