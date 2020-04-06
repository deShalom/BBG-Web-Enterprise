﻿<?php
session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}
?>
<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> GRE: Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://daredicing.com/css.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<style>
		.page{
			align-content: center;
	}
		html{
		width:100%;
		height:100%;
	}
		body{
		width:100%;
		height:100%;
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
		.column {
	  float: left;
	  width: 33.33%;
	}

	/* Clear floats after the columns */
	.row:after {
	  content: "";
	  display: table;
	  clear: both;
	}
</style>

<body>



    <!-- Navigation Bar (Within Header) -->
    <div class="w3-padding-8">
        <div class="w3-bar w3-dark-gray">
            <div class="w3-right w3-bar-item w3-button">Logout</div>
			<button class="w3-button w3-dark-gray w3-margin-top" name="logout" ><a href="logout.php">LOGOUT HERE</a></button>
        </div>
    </div>

    <!-- Page Content -->
	<div class="page w3-content" style="max-width:1500px">
		<div class="w3-white w3-border-bottom">
			<button class="w3-button w3-white w3-xlarge" onclick="w3_open()">☰</button>
			<img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
		</div>

		<!-- Sidebar -->
		<div class="w3-sidebar w3-bar-block w3-border-bottom" style="display:none" id="mySidebar">
			<button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
			<a href="ideaSubmission.php" class="w3-bar-item w3-button">Idea Sub</a>
			<a href="#" class="w3-bar-item w3-button">Link 2</a>
			<a href="#" class="w3-bar-item w3-button">Link 3</a>
			<a href="registration.php" class="w3-bar-item w3-button">Link Reg</a>
		</div>

	<!-- Data Analysis -->
  <div class="w3-row-padding w3-margin-bottom w3-padding-16">
    <div class="w3-third">
      <div class="w3-container w3-greenwich w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>X</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Accounts</h4>
      </div>
    </div>
    
    <div class="w3-third">
      <div class="w3-container w3-greenwich w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>X</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Ideas</h4>
      </div>
    </div>
    
    <div class="w3-third">
      <div class="w3-container w3-greenwich w3-padding-16">
        <div class="w3-left"><i class="fa fa-comments w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>X</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Comments</h4>
      </div>
    </div>
    
  </div>


<!-- Search Analysis -->

	<div class="w3-panel">
    	<div class="w3-row-padding w3-padding-16">
    		<div class="topnav w3-col w3-center">
            <h2>User Lookup</h2>
    			<input type="text" placeholder="Search Username.." style="width:50%">
                <button class="w3-button w3-greenwich w3-hover-dark-gray"id="SearchUser"><i class="fa fa-search"></i></button>
  			</div>
            <div class="w3-quarter w3-padding-16 w3-center">
            <button class="w3-button w3-greenwich w3-hover-dark-gray"id="Ban"><i class="fa fa-user-lock"></i> Ban</button>
            </div>
            <div class="w3-quarter w3-padding-16 w3-center">
            <button class="w3-button w3-greenwich w3-hover-dark-gray"id="Block"><i class="fa fa-lock"></i> Block</button>
            </div>
            <div class="w3-quarter w3-padding-16 w3-center">
            <button class="w3-button w3-greenwich w3-hover-dark-gray"id="Unban"><i class="fa fa-lock-open"></i> Unban</button>
            </div>
            <div class="w3-quarter w3-padding-16 w3-center">
            <button class="w3-button w3-greenwich w3-hover-dark-gray"id="Unblock"><i class="fa fa-unlock"></i> Unblock</button>
            </div>
  		</div>
 	 </div>

	<!-- Department Analysis -->

  <div class="w3-panel">
    <div class="w3-row-padding-16 w3-padding">
      <div class="w3-third">
        <h2>Department</h2>
        <div class="search-box" style="width:100%" alt="Search Box">
        <select id="Department" style="width:100%" name="Departments" multiple="multiple">
        <option value="0" selected="selected">Select Department</option>
        </select> 
        
        <br></br>
        <button class="w3-button w3-greenwich w3-hover-dark-gray"id="FilterDepartment">Search</button>
        
        </div>
      </div>
      <div class="w3-twothird">
        <h2>Data</h2>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

<!-- Category Analysis -->

  <div class="w3-panel">
    <div class="w3-row-padding-16 w3-padding">
      <div class="w3-third">
        <h2>Category</h2>
        <div class="search-box" style="width:100%" alt="Search Box">
        <select id="Category" style="width:100%" name="Categories" multiple="multiple">
        <option value="0" selected="selected">Select Category</option>
        </select> 
        
        <br></br>
        <button class="w3-button w3-greenwich w3-hover-dark-gray"id="FilterCategory">Search</button>
        
        </div>
      </div>
      <div class="w3-twothird">
        <h2>Data</h2>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

     <br></br>
     <br></br>
     <br></br>



				<!--Fieldset for Terms and Conditions; made sure that it is a "required" attribute as said in CW spec-->
				<!-- Side bar header -->
				<!-- Button Scripts -->
				<script>
            function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            }

            function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            }
				</script>
			</div>

			<div class="footer w3-dark-gray">
				<p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
		   <a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"><i class="fab fa-snapchat-ghost w3-margin-right"></i></a>
           <a href="https://twitter.com/UniofGreenwich" target="_blank"><i class="fab fa-twitter w3-margin-right"></i></a>
           <a href="https://www.facebook.com/uniofgreenwich/" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
           <a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"><i class="fab fa-instagram w3-margin-right"></i></a>
			</div>
</body>
</html>