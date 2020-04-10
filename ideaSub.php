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
    
// Creating variables allowing us to use the functionality of our other php pages (in this case, minaly ideaSubmission.php)
    $category1 = $_POST['category1'];
    $category2 = $_POST['category2'];
    $category3 = $_POST['category3'];
    $problem = mysqli_real_escape_string($conn, $_POST['problem']);
    $idea = mysqli_real_escape_string($conn, $_POST['idea']);
// Creating a boolean variable to let us know if a post has documents attached. With FALSE as default.
    $docupload = '0';
    $posttitle = mysqli_real_escape_string($conn, $_POST['posttitle']);
    $ideadept = $_POST['department'];

    // if anon checkbox is ticked, it is set to 1; if not, set to 0.
if(isset($_POST['anon']))
{
    $anon = "1";
}
else
{
    $anon = "0";
}    

$userID = $_SESSION['userID']; // Grabs the userID from the sessions.

$file = $_FILES['fileToUpload']; // allows us to shortcut setting file variables.

if (isset($_POST['submitidea']))   // If submit button is pressed
{

} // if submit button is not pressed; nothing will happen. Don't even need the "else" but hey.
else
{
    
}
    
    
    
    
    if(isset($_FILES['fileToUpload'])){ // checks if filetoupload has been submitted
        $file_array = $_FILES['fileToUpload']; // create an array to hold the files 
        for ($i=0; $i < count($file_array); $i++) { // for loop, so we can go through the entire array 1 by 1

            $fileName = $file['name'];           // Using "$file" to save time.
            $fileTempName = $file['tmp_name'];  // Variables assigned to super globals allowing us to utilise the file details.
            $fileSize = $file['size'];         // $_Files helps us get all the information from the file that we want to upload. - I also use $file for each other variable to shorten the process
            $fileError = $file['error'];      // Same shit as above but instead of writing out $_FILES infront of each variable, I set it to $file for conveniences sake, as shown above.
            $fileType = $file['type'];       // this pops up in the file information when uploading it.
    
            $allowed = array('jpg','pdf','png','doc','gif','jpeg','tif'); // allowed extentions
            $fileExt = explode('.',$file_array[$i][$fileName]); // This seperates the file name and the file extention (its type)(whatever is before and after the ".")
            $fileActualExt = strtolower(end($fileExt)); // This takes the extention of the file, which could be in capital letters, such as JPEG or w/e and makes it all lower case
                                                        // by grabbing it from the last place in the created array above (via the use of explode) and setting it to lowercase.
            $target_dir = ('uploadedDocs/'); // target directory
    
            $docupload = "1"; // documents have been selected, docupload set to 1 so we can update our db accordingly.            
    
            if (in_array($fileActualExt, $allowed)) // if actual extention of file is found in the "allowed" array, proceed to upload.
            {                
                if($fileError === 0){ // checks if file error is 0; if so, moves on.

                    if ($fileSize < 1000000) // checks file size
                    {
                        $fileNameNew = uniqid('', true).$userID.".".$fileActualExt; // This creates a unique name for each file and adds the extention back (which is now in lower case).
                        $fileDestination = $target_dir.$fileNameNew;
                        move_uploaded_file($file_array[$i][$fileTempName], 'uploadedDocs/'.$file_array[$i][$fileDestination]); // Function which uploads the file using the temporary space and our final file destination.

                        $grablatestpostID = "SELECT TOP 1 PostID FROM Posts ORDER BY 'PostID' DESC"; // query to grab the latest postID
                        $resultlastpostID = mysqli_query($conn, $grablatestpostID);                 // running the query through the conn string
                        $latestpostID = $resultlastpostID + 1;                                     // adding +1 to latest postID so we can create a new one artifically for the postID column in Docs table
                                                                            // scuffed way of doing it; what if more than one person uploads at the same exact time? unlikely but new postIDs would be same

                        $updateDoctable = "INSERT INTO Documents (FileType, PostID, UserID, FileName) VALUES ('$fileActualExt', '$latestpostID', '$userID', '$fileNameNew')";
                        mysqli_query($conn, $updateDoctable); // updates Documents table in line with the updated post

                        header("Location: index.php?DocUploadSuccess"); // If all goes well, we are take to the Index page with "UploadSuccess" written in the address bar.
                    }
                    else
                    {
                        echo "The file you are trying to upload is too big!";
                    }

                }
                else // if there was a file error, it will spit out this message.
                {
                   echo "There was an error with the upload of your files. Please try again.";
                }              
            }
            else 
            {
                echo "You are trying to upload a file type we do not support!";                 
            } 
    
        }
            // once the loop is done, it will update the Posts table.
        $updatepostsquery = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, ProblemTxt, isUploadedDocuments, UserID, isAnonymous) VALUES ('$ideadept', '$posttitle', '$problem', '$category1', '$category2', '$category3', '$idea', '$docupload','$userID', '$anon')";
        // updates the Posts table to insert Post information
        mysqli_query($conn, $updatepostsquery); // executes the query to update Posts table with some Docs being uploaded
    
    }
    else // if button to submit documents has not been pressed
    {
        $updatepostsquery = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, ProblemTxt, isUploadedDocuments, UserID, isAnonymous) VALUES ('$ideadept', '$posttitle', '$problem', '$category1', '$category2', '$category3', '$idea', '$docupload','$userID', '$anon')";
                                // updates the Posts table to insert Post information
        mysqli_query($conn, $updatepostsquery); // executes the query to update Posts table with some Docs being uploaded

        // test to upload new category; tested and works
        // $updateCat = "INSERT INTO Categories (CategoryName) VALUES ('Moodle')";
        // mysqli_query($conn, $updateCat);

        header("Location: index.php?PostSubmittedWithNoDocs"); // takes us back to index if Post has been submitted with no docs uploaded.
    }




?>