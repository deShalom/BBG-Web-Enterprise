﻿<!DOCTYPE html>

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
                    <select id="IdeaCategory" class="w3-dropdown-click">
                        <option value="cat1">category1</option>
                        <option value="cat2">cat2</option>
                        <option value="cat3">cat3</option>
                        <option value="cat4">cat4</option>
                    </select>
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