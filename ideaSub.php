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
}

if(isset($_FILES['fileToUpload'])) // if document upload is submitted
{
    
    $file_array = reArrayFiles($_FILES['fileToUpload']); // rearranged the array for file information
    for ($i=0; $i < count($file_array); $i++) {  // for loop for each uploaded file
        if($file_array[$i]['error']){ // if an error occurs handler
            if($file_array[$i]['error'] = '4'){ // this is a unique handler as if a doc hasnt been select, it will run this                 
                echo "No docs have been uploaded!";
                $docupload = "0";
                goto insertNoDoc;                    
            }                
            else{ // if any other error occurs, it will be displayed.
                echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
            }
        }
        else{ // if no errors, proceed with this block.
            $allowed = array('jpg','pdf','png','doc','gif','jpeg','tif'); // allowed extensions.
            $file_ext = explode('.',$file_array[$i]['name']); // exploding file names to obtain actual extension
            $file_ext = end($file_ext); // grabbing the last(end) bit of the exploded file name
            $fileNameNew = uniqid('', true).".".$file_ext; // creating a unique name for each file
                                    
            if(!in_array($file_ext, $allowed)){ // if extension is invalid error handler
                echo $userID.".".$fileNameNew."- Invalid File Extension."; // echos out msg if extension isn't allowed
            }
            else{ // if extension is allowed, proceed with this block.
                $docupload = "1";
                move_uploaded_file($file_array[$i]['tmp_name'], "uploadedDocs/".$fileNameNew); // moves files to upload directory WORKS
                echo $fileNameNew.' - '.$phpFileUploadErrors[$file_array[$i]['error']]; // echo out the new file name as well as any additional errors.
                $selectPostID = "SELECT PostID FROM Posts ORDER BY PostID DESC LIMIT 1;"; // sql query to grab latest PostID
                $resultPostID = mysqli_query($conn, $selectPostID); // runs the query                
                $row = mysqli_fetch_assoc($resultPostID); // fetches the data and assigns it to $row as an array
                $newPostID = $row['PostID'] + 1; // adds 1 to latest PostID so I can update Document table
                $updateDocTable = "INSERT INTO Documents (FileType, PostID, UserID, FileName) VALUES ('$file_ext', '$newPostID', '$userID','$fileNameNew');";
                // sql statement to insert data into Documents table
                mysqli_query($conn, $updateDocTable);
                //if(){ // if statement runs fine, run this block.
                    //echo "New Document record created!";
                    //header("Location: index.php?WithDocsUploadedPostUpdated"); // takes us back to Index with a success msg for this specific event
                //}
                //else{ // if statement did not run, run this block.
                    //echo "error of somekind";
                //}                               
            }
        }
                
    }
}
$user_level = $_SESSION['level_user']; // session variable for user level
$username = $_SESSION['username'];
insertNoDoc:  // when no docs are selected, code will jump to this.                 
            $updatePost = "INSERT INTO Posts (Department, Title, Body, Category1ID, Category2ID, Category3ID, isUploadedDocuments, Views, UserID, isAnonymous, ProblemTxt) 
                            VALUES ('$ideadept', '$posttitle', '$problem', '$category1', '$category2', '$category3', '$docupload', '0','$userID', '$anon', '$idea');";
            mysqli_query($conn, $updatePost); // runs the query and checks if it runs fine
            //header("Location: index.php?PostSubmitted"); // takes us back to Index with a success msg for this specific event

                $retrieveQACoord = "SELECT Username FROM Accounts WHERE LEVEL = 3 AND Department = '$ideadept'"; // SQL to find username of QA Coord
                $retrieveQACoordResult = mysqli_query($conn, $retrieveQACoord); // exec query
                $rowQACoord = mysqli_fetch_assoc($retrieveQACoordResult); // fetching results
                $QAusername = $rowQACoord['Username'];              // works

                $doesQAexist = "SELECT 1 FROM Accounts WHERE Level = 3 AND Department = '$ideadept';"; // SQL to see if a QA exists for that department
                $doesQAexistResult = mysqli_query($conn, $doesQAexist); // exec query
                $rowQAExist = mysqli_fetch_assoc($doesQAexistResult); // fetch results                          // Works
            
                $retrieveEmail = "SELECT Email FROM Accounts WHERE Level = 3 AND Department = '$ideadept';"; // query to grab email from appropriate account
                $retrieveEmailResult = mysqli_query($conn, $retrieveEmail); // exec the query
                $foundQAEmail = mysqli_fetch_assoc($retrieveEmailResult); // fetch the results                             // Works   
                
                if($rowQAExist['1']){ // checks if QA Coor exists 
                    ini_set("SMTP", 'n3plcpnl0054.prod.ams3.secureserver.net');
                    ini_set("sendmail_from", "noreply@daredicing.com");

                      $to = $foundQAEmail['Email'];     // variable setting the Email address this email will be sent to
                      $subject = "New Idea Submission for your Department!"; // subject of the email.
                      $message = "Hello, $QAusername. As the QA Coordinator for your department, $ideadept, I would like to notify you of a new Idea Submission titled $posttitle for your department!
                                   Check it out by logging into the portal here: <a href=\"http://daredicing.com/login.php\">Click Here</a><p> Best of luck from BigBoiGames Ltd</p>";
                                    // Body text of the email; including variables for the QACoordinator username, the idea department and the title of post.                   
                      $header = "From: noreply@daredicing.com";
                      $headers .= "MIME-Version: 1.0" . "\r\n";
                      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                      mail($to, $subject, $message, $headers);
                      header("Location: index.php?PostSubmittedEmailSentToQACoord"); // success message; if email is found and everything goes well; update Post and send email. Works fine.
                }else{
                    header("Location: index.php?PostSubmittedEmailNotSent"); // if there is no QACoord for that department, email will not be sent but Post will be submitted.
                }

?>