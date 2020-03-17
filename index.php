<?php 
session_start;
?>
<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> GRE: Home page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <div class="w3-right w3-bar-item w3-button ">Logout</div>
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
			<a href="#" class="w3-bar-item w3-button">Link 1</a>
			<a href="#" class="w3-bar-item w3-button">Link 2</a>
			<a href="#" class="w3-bar-item w3-button">Link 3</a>
		</div>

		<fieldset>
			<p class="w3-center">
				<label for="fname">Popular Ideas:</label><br />
				
			</p>
			<div class="w3-panel">

				<div class="w3-panel w3-border-bottom">
					<div class="flex-container">
						<div class="w3-panel">
							
						</div>
						<div class="w3-panel">
							<div class="row">
								<div class="column">
									<p> poo</p>
								</div>
								<div class="column">
									<p> poo</p>
								</div>
								<div class="column">
									<p> poo</p>
								</div>
							</div>
							

							
						</div>
					</div>
				</div>
				<p class="w3-center">

				</p>

				<fieldset></fieldset><fieldset></fieldset><fieldset></fieldset>
				<br />
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
				<i class="fab fa-snapchat-ghost w3-margin-right"></i>
				<i class="fab fa-twitter w3-margin-right"></i>
				<i class="fab fa-facebook-f w3-margin-right"></i>
				<i class="fab fa-instagram w3-margin-right"></i>
			</div>
</body>
</html>