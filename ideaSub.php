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
    

$userID = $_SESSION['userID']; // Grabs the userID from the sessions.

$phpFileUploadErrors = array(     // creating array to store the different error messages
0 => 'There is no error, file uploaded with success!',
1 => 'Upload exceededs max filesize.',
2 => 'Exceeds Max_File_Size that was specified in HTML form.',
3 => 'Upload was only partially completed.',
4 => 'No File uploaded.',
5 => 'Missing Temporary folder.',
6 => 'Failed to write to disk.',
7 => 'PHP extension stopped the file upload.',
);

function reArrayFiles($file_post){ // function to help with rearranging the file details into a neat order

    $file_ary = array(); // creates an array
    $file_count = count($file_post['name']); // counts the number of "name"  rows in arrays
    $file_keys = array_keys($file_post); // set and sorts by keys

    for ($i=0; $i < $file_count; $i++) { //nearly sets up array with all file info
        foreach ($file_keys as $key){
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}

$target_dir = ('uploadedDocs/'); // target directory

// Creating variables allowing us to use the functionality of our other php pages (in this case, minaly ideaSubmission.php)
$ideadept = $_POST['department'];
$category1 = $_POST['category1'];
$category2 = $_POST['category2'];
$category3 = $_POST['category3'];
$posttitle = mysqli_real_escape_string($conn, $_POST['posttitle']);
$problem = mysqli_real_escape_string($conn, $_POST['problem']);
$idea = mysqli_real_escape_string($conn, $_POST['idea']);
$docupload = '0'; // changes to "1" if files are ready to be uploaded.

if (isset($_POST['submitidea'])){ // if submit button is pressed       

    // if anon checkbox is ticked, it is set to 1; if not, set to 0.
    if(isset($_POST['anon'])){
        $anon = "1"; // if set, then "1"
    }
    else{
        $anon = "0"; // if not set, then "0"
    }    
    // This was a test to see if i could get it to run off of (isset($_POST['submitidea'])
    // $updatePost = "INSERT INTO Categories (CategoryName) VALUES ('inserttest');"; THIS WORKS FINE, updates the Categories table
    //$updatePost = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, isUploadedDocuments, UserID, isAnonymous, ProblemTxt) VALUES ('$ideadept', '$posttitle', '$problem', '$category1', '$category2', '$category3', '$docupload', '$userID', '$anon', '$idea');";
        // query above takes variables as input to db; does NOT work.
    //$updatePost = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, isUploadedDocuments, UserID, isAnonymous, ProblemTxt) VALUES ('Computing', 'Test Title', 'This is a problem', '3', '2', '0', '1', '$userID', '0', 'This is how I fix problem');";
        // query above takes my own inputs to db; does NOT work.
    //if(mysqli_query($conn, $updatePost)){ // runs the query and checks if it runs fine
        //header("Location: index.php?NoDocsUploadedPostUpdated"); // takes us back to Index with a success msg for this specific event     
    //}
    //else{
        //echo "faked it";
    //}
}

if(isset($_FILES['fileToUpload'])) // if document upload is submitted
{
    $docupload = "1";
    $file_array = reArrayFiles($_FILES['fileToUpload']); // rearranged the array for file information
    for ($i=0; $i < count($file_array); $i++) {  // for loop for each uploaded file
        if($file_array[$i]['error']){ // if an error occurs handler
            if($file_array[$i]['error'] = '4'){ // this is a unique handler as if a doc hasnt been select, it will run this
                echo "No docs have been uploaded!";
                // The Query below doesn't wanna work and throws me into the "else"; help.
                // Tested with updating Categories table; works fine.
                $updatePost = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, isUploadedDocuments, UserID, isAnonymous, ProblemTxt) 
                                VALUES ('$ideadept', '$posttitle', '$problem', '$category1', '$category2', '$category3', '$docupload', '$userID', '$anon', '$idea');";
                    if(mysqli_query($conn, $updatePost)){ // runs the query and checks if it runs fine
                        //header("Location: index.php?NoDocsUploadedPostUpdated"); // takes us back to Index with a success msg for this specific event     
                    }
                    else{
                        //echo "query doesn't go through"; // if query doesnt go through
                    }
            }
            else{ // if any other error occurs, it will be displayed.
                echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
            }
        }
        else{ // if no errors, proceed with this block.
            $allowed = array('png','pdf'); // allowed extensions.
            $file_ext = explode('.',$file_array[$i]['name']); // exploding file names to obtain actual extension
            $file_ext = end($file_ext); // grabbing the last(end) bit of the exploded file name
            $fileNameNew = uniqid('', true).".".$file_ext; // creating a unique name for each file
                                    
            if(!in_array($file_ext, $allowed)){ // if extension is invalid error handler
                echo $userID.".".$fileNameNew."- Invalid File Extension."; // echos out msg if extension isn't allowed
            }
            else{ // if extension is allowed, proceed with this block.
                move_uploaded_file($file_array[$i]['tmp_name'], "uploadedDocs/".$fileNameNew); // moves files to upload directory WORKS
                echo $fileNameNew.' - '.$phpFileUploadErrors[$file_array[$i]['error']]; // echo out the new file name as well as any additional errors.
                $selectPostID = "SELECT PostID FROM Posts ORDER BY PostID DESC LIMIT 1;"; // sql query to grab latest PostID
                $resultPostID = mysqli_query($conn, $selectPostID); // runs the query                
                $row = mysqli_fetch_assoc($resultPostID); // fetches the data and assigns it to $row as an array
                $newPostID = $row['PostID'] + 1; // adds 1 to latest PostID so I can update Document table
                $updateDocTable = "INSERT INTO Documents (FileType, PostID, UserID, FileName) VALUES ('$file_ext', '$newPostID', '$userID','$fileNameNew');";
                // sql statement to insert data into Documents table
                if(mysqli_query($conn, $updateDocTable)){ // if statement runs fine, run this block.
                    echo "New Document record created!";
                }
                else{ // if statement did not run, run this block.
                    echo "error of somekind";
                }
            }
        }
    }
}
  
// Line 71; query doesn't run, spits me into the "else" block.


?>
