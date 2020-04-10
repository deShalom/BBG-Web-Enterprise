<?php
include'config.php';

$pageName = basename($_SERVER['PHP_SELF']);
	$queryupdateViews = ("SELECT PageName, Views FROM Pages WHERE PageName = '$pageName'");
	$resultupdateViews = mysqli_query($conn, $queryupdateViews);
	$rowsupdateViews = mysqli_num_rows($resultupdateViews);
    
	if ($rowsupdateViews == 1)
	{
		while ($rowupdateViews = mysqli_fetch_array($resultupdateViews))
		{
			$addonreview = $rowupdateViews['Views'] + 1;
			$queryViewAdd = "UPDATE Pages SET Views = '$addonreview' WHERE PageName = '$pageName'";
			$resultToInsertView = mysqli_query($conn, $queryViewAdd);
			


		}
	}else{
		$queryEnterPage = ("Insert into Pages (PageName, Views) VALUES ('$pageName','1')");
		$resultEnterPage = mysqli_query($conn, $queryEnterPage);
	}
	
	$datequery = ("SELECT EnteredDate, DisableOrClose FROM Dates WHERE DisableOrClose = '1'");
	$resultdate = mysqli_query($conn, $datequery);
	$rowsdate = mysqli_num_rows($resultdate);
    if ($rowsdate > 0) 
    {            
		while($rowsdate = mysqli_fetch_assoc($resultdate)) {
					
			$gotDate = $rowsdate['EnteredDate'];
		}
	}
	
	
?>

<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> GRE: Closed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://daredicing.com/css.css%22%3E">
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
    .sB {
        margin-top: 50px;
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
            <img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
        </div>

        <!-- Banned user content -->
        <div class="w3-display-middle" style="background-color:#060360;">
            <p class="w3-margin-right w3-margin-left" style="color:#ffffff"><i class="far fa-window-close w3-margin-right" style="color:#ffffff"></i>Improvement idea submission is no longer open, the site is now closed.</p>
			<div class="flex-container">
			<div><p class="w3-center" style="color:#ffffff">As of:</p></div>
			 <!-- Echo date here please -->
			<div><p class="w3-center" style="color:#ffffff"><?php echo $gotDate; ?></p></div>
			</div>
        </div>

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