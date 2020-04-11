﻿<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title>GRE: Password Reset</title>
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
        height: 200px;
        width: 800px;
        font-size: 12pt;
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
        <h1 align="center">Reset Password</h1>

        <!-- This is the form for the forgotten password page -->
        <form action="ResetPassword.php" method="post" class=" w3-container w3-display-middle w3-card-4 w3-dark-grey" enctype="multipart/form-data" style="width: 500px;">
            <br />
            <br />
            <!--Fieldset to whack in email address innit-->
            <!-- I fucking hate HTML why is it so cancer-->
            <fieldset>
                <p class="w3-center">
                    <label for="fname">Enter your email address to reset your password:</label><br />
                    <input class="w3-input w3-border w3-center" type="password" name="emailentry" placeholder="email" id="emailbox" required>
                    <button class="w3-button w3-margin-top">Reset Password</button>
                </p>

            </fieldset>
            <br />
            <br />
            <br />

        </form>

        <br />
        <br />
        <br />
        <br />
        <br />

        <div class="footer w3-dark-gray">
            <p><span style='border-bottom:2px white solid;'>Other useful links!</span></p>           <a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"><i class="fab fa-snapchat-ghost w3-margin-right"></i></a>
           <a href="https://twitter.com/UniofGreenwich" target="_blank"><i class="fab fa-twitter w3-margin-right"></i></a>
           <a href="https://www.facebook.com/uniofgreenwich/" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
           <a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"><i class="fab fa-instagram w3-margin-right"></i></a>
        </div>
</body>
</html> 