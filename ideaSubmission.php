<?php
session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}

$level = intval($_SESSION['level_user']);
	if ($level < -4){
		header("location: banned.php");

	}

	if ($level == -3){
		header("location: index.php?YouAreBlockedFromPosting");

	}

	$date_now = date("Y-m-d");
	$datequery = ("SELECT EnteredDate, DisableOrClose FROM Dates WHERE DisableOrClose = '0'");
	$resultdate = mysqli_query($conn, $datequery);
	$rowsdate = mysqli_num_rows($resultdate);
    if ($rowsdate > 0) 
    {            
		while($rowsdate = mysqli_fetch_assoc($resultdate)) {
					
			$gotDate = $rowsdate['EnteredDate'];
		}
		
		if ($date_now > $gotDate){
				header("location: subclosed.php");
		} else{
			
		}
	}
	else 
    {
	}




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
  grid-row-start: 2;
  grid-row-end: 3;
    }

    .bI {
        width: 100%;
    }



    /* Style inputs, select elements and textareas */
    input[type=text], textarea{
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical;
        height: 100px;
    }  
    
    select{
        width: 50%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical;
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

		<div class="w3-white w3-border-bottom">
			<button class="w3-button w3-white w3-xlarge" onclick="w3_open()">☰</button>
			<img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
		</div>

		<!-- Sidebar -->
		<div class="w3-sidebar w3-bar-block w3-border-bottom" style="display:none" id="mySidebar">
			<button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
            <a href="index.php" class="w3-bar-item w3-button">Home</a>
            <a href="ideaSubmission.php" class="w3-bar-item w3-button">Idea Sub</a>
            <a href="ideabrowser.php" class="w3-bar-item w3-button">Idea Browser</a>
            <a href="admin.php" class="w3-bar-item w3-button">Admin Page</a>
            <a href="qacoor.php" class="w3-bar-item w3-button">QA Manager Page</a>
		</div>

        <!--Header of the page-->
        <h1 align="center">Your Idea Submission Form</h1>

        <!-- This is the form for the Ideas Submission area -->
        <form action="ideaSub.php" method="post" class="w3-container w3-margin-top w3-margin-right w3-margin-left w3-margin-bottom w3-card-4 w3-dark-grey" enctype="multipart/form-data">
            <!--I've seperated each main CW spec using a field set to ensure that we have everything we need-->
            <!--Inluced everything within a form for now for simplicity; straight up copied Elion's form style to make it all look the same smile xd finger my ass its 2am I should have stopped playing tarkov-->
            <!--The Header of the page-->
            <h3 class="w3-center">Enter and submit your idea on how we can improve our services!</h3>
            <br />
            <!--Fieldset including a dropdown menu to select a Category-->
            <fieldset>
                <p class="w3-center">                    
                    <label for="IdeaDept">Choose a Department:</label>
                    </br>
                    <select id="department" name="department" class="w3-dropdown-click">
                        <option value="Archaeology">Archaeology</option>
                        <option value="Computing">Computing</option>
                        <option value="Humanities">Humanities</option>
                        <option value="Languages">Languages</option>
                        <option value="Mathematics">Mathematics</option>
                        <option value="Science">Science</option>
                    </select>
                    </br>
                    <label for="IdeaCategory">Choose 3 Categories:</label>
                    <br>
                    <select id="category1" name="category1" class="w3-dropdown-click">                        
                        <option value="1">Funding</option>
                        <option value="2">Students</option>
                        <option value="3">Accessiblilty</option>
                        <option value="4">Complaint</option>
                        <option value="5">Staff</option>
                    </select>
                    </br>
                    <select id="category2" name="category2" class="w3-dropdown-click">
                        <option value="0">Not Applicable</option>
                        <option value="1">Funding</option>
                        <option value="2">Students</option>
                        <option value="3">Accessiblilty</option>
                        <option value="4">Complaint</option>
                        <option value="5">Staff</option>
                    </select>
                    </br>
                    <select id="category3" name="category3" class="w3-dropdown-click">
                        <option value="0">Not Applicable</option>
                        <option value="1">Funding</option>
                        <option value="2">Students</option>
                        <option value="3">Accessiblilty</option>
                        <option value="4">Complaint</option>
                        <option value="5">Staff</option>
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
                    <textarea class="w3-center" type="text" name="problem" placeholder="Type Here" id="inputbox" required></textarea>
                </p>

                <p class="w3-center">
                    <label for="fname">Describe Your Idea on how to fix the problem here:</label><br />
                    <textarea class="w3-center" type="text" name="idea" placeholder="Type Here" id="inputbox" required></textarea>
                </p>
            </fieldset>
            <br />
            <!--Fieldset for Terms and Conditions; made sure that it is a "required" attribute as said in CW spec-->
            <fieldset>
                <p class="w3-left-align">Please read and agree to the Terms and Conditions: (T&Cs apply)</p>
                <p><input type="checkbox" required name="terms"> I accept the <u>Terms and Conditions</u></p>
                <br />
            <!--Added a button for annonimity. Allowing the user to tick the box if they wish to post as annon.-->
                <p class="w3-left-align">Do you wish to be annonymous?</p>
                <p><input type="checkbox" id="anon" name="anon"> Tick if you wish to be an annonymous poster.</p>
            </fieldset>
            <br />
            <!--Fieldset allowing the user to upload multiple files as well as Submit their idea; again if some required fields are empty, pop ups will show-->
            <fieldset>
                <p class="w3-left-align">Only these file types will be uploaded: jpg, pdf, png, doc, gif, jpeg, tif.</p>
                <p class="w3-left-align">Select files to upload and upload your idea:</p>
                <input type="file" name="fileToUpload[]" id="fileToUpload[]" value="" multiple>
                <input type="submit" value="Submit Your Idea" name="submitidea">
            </fieldset>
            <br />

        </form>

        <br />
        <br />
        <br />
        <br />
        <br />

		<script>
            function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            }

            function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            }
				</script>

		</div>
			<div class="footer w3-dark-gray w3-center">
				<p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
				<i class="fab fa-snapchat-ghost w3-margin-right"><a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"></i></a>
				<i class="fab fa-twitter w3-margin-right"><a href="https://twitter.com/UniofGreenwich" target="_blank"></i></a>
				<i class="fab fa-facebook-f w3-margin-right"><a href="https://www.facebook.com/uniofgreenwich/" target="_blank"></i></a>
				<i class="fab fa-instagram w3-margin-right"><a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"></i></a>
			</div>
</body>
</html>
