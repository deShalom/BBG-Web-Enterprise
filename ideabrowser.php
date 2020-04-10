<?php
	session_start();
	include "config.php";

	if(!isset($_SESSION['login_user']))
	{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
		header("location: login.php?YouAreNotLoggedIn");
	}

    $level = intval($_SESSION['level_user']);
	if ($level < -4){
		header("location: banned.php");

	}

	if (isset($_GET['pageno']))
	{
		$pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	$offset = ($pageno-1) * 5;
	
	
	$date_now = date("Y-m-d");
	$datequery = ("SELECT EnteredDate, DisableOrClose FROM Dates WHERE DisableOrClose = '1'");
	$resultdate = mysqli_query($conn, $datequery);
	$rowsdate = mysqli_num_rows($resultdate);
    if ($rowsdate > 0) 
    {            
		while($rowsdate = mysqli_fetch_assoc($resultdate)) {
					
			$gotDate = $rowsdate['EnteredDate'];
		}
		
		if ($date_now > $gotDate){
				header("location: siteclosed.php");
		} else{
			
		}
	}
	else 
    {
	}

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
            grid-row-start: 2;
            grid-row-end: 3;
	}
		.bI {
			width: 100%;
		}
        p.solid {
            border-style: solid colour: ;
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
			<button class="w3-right w3-button w3-dark-gray w3-margin-top  w3-bar-item" name="logout" ><a href="logout.php">Logout</a></button>
		</div>
	</div>

	<!-- Page Content -->
	<div class="page w3-content" style="max-width:1500px">
		<div class="w3-white w3-border-bottom">
			<button onclick="w3_open()" class="w3-button w3-white w3-xlarge" name= "contentbar" >☰</button>
			<img src="Images/uog-logo.png" style="margin-bottom: 10px; margin-top: 10px;">
		</div>

		<!-- Sidebar -->
		<div class="w3-sidebar w3-bar-block w3-border-bottom" style="display:none" id="mySidebar">
			<button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
            <a href="ideaSubmission.php" class="w3-bar-item w3-button">Idea Sub</a>
            <a href="ideabrowser.php" class="w3-bar-item w3-button">Idea Browser</a>
            <a href="admin.php" class="w3-bar-item w3-button">Admin Page</a>
            <a href="qacoor.php" class="w3-bar-item w3-button">QA Manager Page</a>
		</div>

		<fieldset>
			<p class="w3-center">
				<label for="fname">Submitted Ideas</label><br />
			</p>
			<div class="w3-panel">
				<div class="w3-row-padding w3-padding-16">
					<div class="flex-container">
						<?php
							$total_pages_sql = "SELECT COUNT(*) AS numPages FROM Posts";
							$queryResult = mysqli_query($conn, $total_pages_sql);
							$total_rows = mysqli_fetch_array($queryResult);
							$total_pages = ceil($total_rows['numPages'] / 5);

							$sql = "SELECT * FROM Posts LIMIT 5 OFFSET $offset";
							$data = mysqli_query($conn,$sql);

							while ($row = mysqli_fetch_array($data))
							{
                                $userID = $row['UserID'];
                                $userData = mysqli_query($conn, "SELECT Username FROM Accounts WHERE UserID=$userID");
                                $user = mysqli_fetch_array($userData);

								if ($row["isUploadedDocuments"] === 0) {
									$row["isUploadedDocuments"] = "No";
								} else {
									$row["isUploadedDocuments"] = "Yes";
								}
							
							
						?>
								<table class="w3-table w3-striped w3-white" style="width:100%" onclick="window.location.replace('indiv.php?id=<?= $row['PostID']; ?>')">
                                    <tr>
                                        <th>Title</th>
                                        <th>UploadedDocuments</th>
                                        <th>Body</th>
                                        <th>IDs  </th>
                                        <th>IDs</th>
                                        <th>IDs </th>
                                        <th>Department</th>
                                        <th>Downvotes</th>
                                        <th>Upvotes </th>
                                        <th>Anonymous?</th>
                                    </tr>
                                    <tr>
                                        <td> <?=$row["Title"] ?></td>
                                        <td> <?=$row["isUploadedDocuments"] ?></td>
										<td> <?=$row["Body"] ?></td>
										<td>  <?=$row["Category1ID"]?></td>
										<td>   <?=$row["Category2ID"]?>  </td>
										<td> <?=$row["Category3ID"]?>  </td>
										<td>  <?=$row["Department"]?>  </td>
										<td> <?=$row["Downvotes"]?>  </td>
										<td> <?=$row["Upvotes"]?>  </td>
										<td> <?=$row["isAnonymous"] == 1 ? "Yes" : $user['Username'];?></td>										
                                    </tr>
                            </table>
								</div>
						<?php
							};
						?>
					</div>
                </fieldset>
                </div>
			</div>
    </div>
    
		<ul class="w3-center pagination">
			<a href="?pageno=1" class= "w3-button">First</a>
			<a href="?pageno=<?= $total_pages; ?>" class="w3-button">Last</a>
			<li class="w3-button w3-center <?php if($pageno <= 1){ echo 'disabled'; } ?>">
				<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Back</a>
			</li>

			<li class="w3-button w3-center <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
				<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
			</li>
		</ul>
			
			<script>
                function w3_open() {
                    document.getElementById("mySidebar").style.display = "block";
                }

                function w3_close() {
                    document.getElementById("mySidebar").style.display = "none";
                }
			</script>

            <div class="footer w3-dark-gray w3-center">
                <p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
                <a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"><i class="fab fa-snapchat-ghost w3-margin-right"></i></a>
                <a href="https://twitter.com/UniofGreenwich" target="_blank"><i class="fab fa-twitter w3-margin-right"></i></a>
                <a href="https://www.facebook.com/uniofgreenwich/" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
                <a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"><i class="fab fa-instagram w3-margin-right"></i></a>
            </div>
			
	</body>
</html>