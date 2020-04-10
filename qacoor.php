<?php
session_start();

include'config.php';

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}

	$level = intval($_SESSION['level_user']);

	if ($level < 2){
		
			if ($level < -4){
				header("location: banned.php");
			}
		header ("location: index.php?YouAreNotAQACoordinator");
	}
	

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
	
// opens a connection to the DB via the config file
	$loadAccounts = "SELECT Username FROM Accounts";
	$accountResults = mysqli_query($conn, $loadAccounts);
	
	if ($accountResults){
		$accountRow = mysqli_num_rows($accountResults);
		mysqli_free_result($accountResults);
	}
	
	$loadIdeas = "SELECT PostID FROM Posts";
	$ideaResults = mysqli_query($conn, $loadIdeas);
	
	if ($ideaResults){
		$ideaRow = mysqli_num_rows($ideaResults);
		mysqli_free_result($ideaResults);
	}
	
	$loadComments = "SELECT CommentID FROM Comments";
	$commentResults = mysqli_query($conn, $loadComments);
	
	if ($commentResults){
		$commentRow = mysqli_num_rows($commentResults);
		mysqli_free_result($commentResults);
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
	
	mysqli_close($conn);
	
?>

<!DOCTYPE html>


<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <title> GRE: QA Coordinator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--This is the link to our CSS!-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
            <a href="index.php" class="w3-bar-item w3-button">Home</a>
            <a href="ideaSubmission.php" class="w3-bar-item w3-button">Idea Sub</a>
            <a href="ideabrowser.php" class="w3-bar-item w3-button">Idea Browser</a>
            <a href="admin.php" class="w3-bar-item w3-button">Admin Page</a>
            <a href="qacoor.php" class="w3-bar-item w3-button">QA Manager Page</a>
        </div>

        <!-- Top statistics page -->
        <div class="w3-row-padding w3-margin-bottom w3-padding-16">
            <div class="w3-third">
                <div class="w3-container w3-greenwich w3-padding-16">
                    <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php
                            echo $accountRow;
                            ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Accounts</h4>
                </div>
            </div>

            <div class="w3-third">
                <div class="w3-container w3-greenwich w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php
                            echo $ideaRow;
                            ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Ideas</h4>
                </div>
            </div>

            <div class="w3-third">
                <div class="w3-container w3-greenwich w3-padding-16">
                    <div class="w3-left"><i class="fa fa-comments w3-xxxlarge"></i></div>
                    <div class="w3-right">
                        <h3>
                            <?php
                            echo $commentRow;
                            ?>
                        </h3>
                    </div>
                    <div class="w3-clear"></div>
                    <h4>Total Comments</h4>
                </div>
            </div>
        </div>
        
<!-- Categories Analysis -->

  <div class="w3-panel">
    <div class="w3-row-padding-16 w3-padding">
      <div class="w3-third">
        <h2><center>Categories</center></h2>
        <div class="search-box" style="width:100%" alt="Search Box">
		<form method="POST">
        <select id="Categories" style="width:100%" name="Categories">
		<?php
			session_start();
			include 'config.php';
			$departmentQuery = "SELECT CategoryName, COUNT(*) FROM Categories GROUP BY CategoryName HAVING COUNT(*) > 0 ORDER BY CategoryName ASC";
			$resultDepartment = mysqli_query($conn, $departmentQuery);
			while($rowDepartment=mysqli_fetch_array($resultDepartment)){
				echo '<option>' . $rowDepartment['CategoryName'] . '</option>';
			}
		?>
        </select> 
        
        <br></br>
		<button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="FilterDepartment">Search</button>
        </form>
		
        </div>
      </div>
      <div class="w3-twothird">
        <h2><center>Category Data</center></h2>
        
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['Categories']))
			{			
				$selectedCategory = $_POST['Categories'];
				
				$queryCategoriesID = ("SELECT CategoryID FROM Categories WHERE CategoryName='$selectedCategory'");
				$resultCategoriesID = mysqli_query($conn, $queryCategoriesID);
				$rowCategoriesID = mysqli_fetch_assoc($resultCategoriesID);
				$totalCategoriesID = $rowCategoriesID['CategoryID'];
				
				$queryCategories = ("SELECT DISTINCT COUNT(*) AS total FROM Posts WHERE Category1ID IN (SELECT Category1ID FROM Posts WHERE Category1ID ='$totalCategoriesID' OR Category2ID ='$totalCategoriesID' OR Category3ID ='$totalCategoriesID')");
				$resultCategories = mysqli_query($conn, $queryCategories);
				$rowCategories = mysqli_fetch_assoc($resultCategories);
				$totalCategories = $rowCategories['total'];

				
				
				
				echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
				<tr>
					<th>Category</th>
					<th>Times Used</th>
				</tr>';
				echo '<td>' . $selectedCategory . '</td>';
				echo '<td>' . $totalCategories . '</td>';
				echo '</tr>
				</table>';
			}
			
		?>
      </div>
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

        <div class="footer w3-dark-gray">
            <p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
            <i class="fab fa-snapchat-ghost w3-margin-right"></i>
            <i class="fab fa-twitter w3-margin-right"></i>
            <i class="fab fa-facebook-f w3-margin-right"></i>
            <i class="fab fa-instagram w3-margin-right"></i>
        </div>
</body>
</html>