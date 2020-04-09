<?php
session_start();

if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}
$checkbannedUser = $_SESSION['login_user'];
$checkbanned = ("SELECT UserID, Username, Password, Level FROM Accounts WHERE Username='$checkbannedUser'");
        $result = mysqli_query($conn, $authquery);
        $rows = mysqli_num_rows($result);

            if ($rows == 1) 
            {
				while($row = mysqli_fetch_assoc($result)) {
					
					$_SESSION['login_user'] = $username; // Initializing Session
					$_SESSION['userID'] = $row['UserID'];
					$_SESSION['level_user'] = $row['Level'];
				}
			}

$level = intval($_SESSION['level_user']);
if($level < 5 )
{           // dont allow if youre not the admin
	if ($level < -4){
		header("location: banned.php");
	}else{
		header("location: index.php?YouAreNotTheAdmin");
	}
    
}

// opens a connection to the DB via the config file
    include 'config.php';
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
			$addoneview = $rowBrowserInsert['Views'] + 1;
			$queryViewAdd = "UPDATE Pages SET NumberOfUses = '$addoneview' WHERE BrowserName = '$pageName'";
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
    <title> GRE: Admin</title>
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
  grid-row-start: 2;
  grid-row-end: 3;
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
          <h3><?php
    echo $accountRow;
?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Accounts</h4>
      </div>
    </div>
    
    <div class="w3-third">
      <div class="w3-container w3-greenwich w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
    echo $ideaRow;
?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Ideas</h4>
      </div>
    </div>
    
    <div class="w3-third">
      <div class="w3-container w3-greenwich w3-padding-16">
        <div class="w3-left"><i class="fa fa-comments w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
    echo $commentRow;
?></h3>
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
			<form action="" method="post">
    			<input type="text" placeholder="Search Username.." style="width:50%" name="enteredUsername"/>
                <button class="w3-button w3-greenwich w3-hover-dark-gray"id="SearchUser"><i class="fa fa-search"></i></button>
			</form>
			<?php
			session_start();
			include "config.php";
			$conn;
			if (!empty($_REQUEST['enteredUsername'])) {
				$searchedUser = mysqli_real_escape_string($conn, $_POST['enteredUsername']);
				//$searchedUser = $_REQUEST['enteredUsername']; 
				$authquery = ("SELECT UserID, Username, Email, Department, Level FROM Accounts WHERE Username='$searchedUser'");
				$resultSearch = mysqli_query($conn, $authquery);
				$rows = mysqli_num_rows($resultSearch);
				

            if ($rows == 1) 
            {
				while($row = mysqli_fetch_assoc($resultSearch)) {
					$_SESSION['searchedUsername'] = $row['Username'];
					$_SESSION['searchedLevel'] = $row['Level'];
					echo "<table style='width:100%'>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th>Department</th>
						<th>Level</th>
					</tr>";
					echo "<tr>";
						echo "<td>" . $row['Username'] . "</td>";
						echo "<td>" . $row['Email'] . "</td>";
						echo "<td>" . $row['Department'] . "</td>";
					switch ($row['Level']) {
						case '-5':
							echo"<td>Banned</td>";
							break;
						case '-1':
							echo "<td>Blocked</td>";
							break;
						case '0':
							echo "<td>Staff</td>";
							break;
						case '1':
							echo "<td>QA Coordinator</td>";
							break;
						case '5':
							echo "<td>QA Manger</td>";
							break;
					}
					echo "</table>";
				}
			}
			else 
            {
                $error = "Username does not exist";
                echo $error;
            }
            mysqli_close($conn); // Closing Connection
			}
			?>
  			</div>
            <div class="w3-quarter w3-padding-16 w3-center">
			<form method="POST" action="">		
            <button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="buttonBan"><i class="fa fa-user-lock"></i> Ban</button>
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['buttonBan']))
			{
				$searchedUser = $_SESSION['searchedUsername'];
				$searchedLevel = $_SESSION['searchedLevel'];
				if (isset($_SESSION['searchedUsername']))
				{
					
					
					switch ($searchedLevel) {
						case '-5':
							$message = $searchedUser . " is already Banned";
							break;
						case '5':
							$message = $searchedUser . " is an Administrator and cannot be banned";
							break;
						Default :
							$banquery = ("UPDATE Accounts SET Level = '-5' WHERE Username = '$searchedUser'");
							if(mysqli_query($conn, $banquery)){
								$message = "You have successfully banned " . $searchedUser;
								
							}
							else{
								$message = "SQL failed to ban " . $searchedUser;
							}
							break;
					}
					
					unset($_SESSION['searchedUsername']);
					
				}
				else{
					$message = "You have not searched a Username";
				}
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			?>
			</form>
			
            </div>

			
            <div class="w3-quarter w3-padding-16 w3-center">
			<form method="POST" action="">		
            <button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="buttonBlock"><i class="fa fa-lock"></i> Block</button>
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['buttonBlock']))
			{
				$searchedUser = $_SESSION['searchedUsername'];
				$searchedLevel = $_SESSION['searchedLevel'];
				if (isset($_SESSION['searchedUsername']))
				{
					
					
					switch ($searchedLevel) {
						case '-5':
							$message = $searchedUser . " is already Banned and cannot be Blocked";
							break;
						case '5':
							$message = $searchedUser . " is an Administrator and cannot be Banned";
							break;
						case '-1':
							$message = $searchedUser . " is already Blocked";
							break;
						Default :
							$banquery = ("UPDATE Accounts SET Level = '-1' WHERE Username = '$searchedUser'");
							if(mysqli_query($conn, $banquery)){
								$message = "You have successfully Blocked " . $searchedUser;
								
							}
							else{
								$message = "SQL failed to Block " . $searchedUser;
							}
							break;
					}
					
					unset($_SESSION['searchedUsername']);
					
				}
				else{
					$message = "You have not searched a Username";
				}
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			?>
			</form>
            </div>
			
            <div class="w3-quarter w3-padding-16 w3-center">
			
			<form method="POST" action="">		
            <button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="buttonUnban"><i class="fa fa-lock-open"></i> Unban</button>
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['buttonUnban']))
			{
				$searchedUser = $_SESSION['searchedUsername'];
				$searchedLevel = $_SESSION['searchedLevel'];
				if (isset($_SESSION['searchedUsername']))
				{
					
					
					switch ($searchedLevel) {
						case '-5':
							$banquery = ("UPDATE Accounts SET Level = '0' WHERE Username = '$searchedUser'");
							if(mysqli_query($conn, $banquery)){
								$message = "You have successfully Unbanned " . $searchedUser;
								
							}
							else{
								$message = "SQL failed to Unban " . $searchedUser;
							}
							break;
						Default :
							$message = $searchedUser . " is not Banned, therefore cannot be Unbanned";
							break;
					}
					
					unset($_SESSION['searchedUsername']);
					
				}
				else{
					$message = "You have not searched a Username";
				}
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			?>
			</form>
			
            </div>
            <div class="w3-quarter w3-padding-16 w3-center">
			
			<form method="POST" action="">		
            <button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="buttonUnblock"><i class="fa fa-unlock"></i> Unblock</button>
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['buttonUnblock']))
			{
				$searchedUser = $_SESSION['searchedUsername'];
				$searchedLevel = $_SESSION['searchedLevel'];
				if (isset($_SESSION['searchedUsername']))
				{
					
					
					switch ($searchedLevel) {
						case '-1':
							$banquery = ("UPDATE Accounts SET Level = '0' WHERE Username = '$searchedUser'");
							if(mysqli_query($conn, $banquery)){
								$message = "You have successfully Unblocked " . $searchedUser;
								
							}
							else{
								$message = "SQL failed to Unblocked " . $searchedUser;
							}
							break;
						Default :
							$message = $searchedUser . " is not Blocked, therefore cannot be Unblocked";
							break;
					}
					
					unset($_SESSION['searchedUsername']);
					
				}
				else{
					$message = "You have not searched a Username";
				}
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
			?>
			</form>
		
			
            </div>
  		</div>
 	 </div>

	<!-- Department Analysis -->

  <div class="w3-panel">
    <div class="w3-row-padding-16 w3-padding">
      <div class="w3-third">
        <h2><center>Department</center></h2>
        <div class="search-box" style="width:100%" alt="Search Box">
		<form method="POST">
        <select id="Department" style="width:100%" name="Department">
		<?php
			session_start();
			include 'config.php';
			$departmentQuery = "SELECT Department, COUNT(*) FROM Posts GROUP BY Department HAVING COUNT(*) > 0 ORDER BY Department ASC";
			$resultDepartment = mysqli_query($conn, $departmentQuery);
			while($rowDepartment=mysqli_fetch_array($resultDepartment)){
				echo '<option>' . $rowDepartment['Department'] . '</option>';
			}
		?>
        </select> 
        
        <br></br>
		<button type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" name="FilterDepartment">Search</button>
        </form>
		
        </div>
      </div>
      <div class="w3-twothird">
        <h2><center>Idea Data</center></h2>
        
			<?php
			session_start();
			include 'config.php';
			if (isset($_POST['Department']))
			{			
				$selectedDepartment = $_POST['Department'];
				$querydep = ("SELECT COUNT(*) as total FROM Posts WHERE Department='$selectedDepartment'");
				$resultdep = mysqli_query($conn, $querydep);
				$rowdep = mysqli_fetch_assoc($resultdep);
				$totalDepPosts = $rowdep['total'];
				
				$querytotal = ("SELECT COUNT(*) as totals FROM Posts");
				$resulttotal = mysqli_query($conn, $querytotal);
				$rowtotal = mysqli_fetch_assoc($resulttotal);
				$totalPosts = $rowtotal['totals'];
				
				$totalpercent = ($totalDepPosts / $totalPosts) * 100;
				
				$queryContributors = ("SELECT COUNT(DISTINCT UserID) AS totaled FROM Posts WHERE Department ='$selectedDepartment'");
				$resultContributors = mysqli_query($conn, $queryContributors);
				$rowContributors = mysqli_fetch_assoc($resultContributors);
				$totalContributors = $rowContributors['totaled'];
				
				echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
				<tr>
					<th>Department</th>
					<th>Ideas</th>
					<th>Percentage of Total</th>
					<th>Total Contributors</th>
				</tr>';
				echo '<td>' . $selectedDepartment . '</td>';
				echo '<td>' . $totalDepPosts . '</td>';
				echo '<td>' . $totalpercent . '%</td>';
				echo '<td>' . $totalContributors . '</td>';
				echo '</tr>
				</table>';
			}
			
		?>
      </div>
    </div>
  </div>

<!-- Exception Report Analysis -->

<div class="w3-panel">
    <div class="w3-row-padding w3-padding-16">
    	<div class="w3-col w3-center">
		    <h2>Exception Reports</h2>
			<br>
			<h3>Ideas Without Comments</h3>
<?php
			session_start();
			include 'config.php';		
			$queryComment = ("SELECT DISTINCT Posts.PostID, Posts.Title, Posts.Department, Accounts.Username FROM Posts INNER JOIN Accounts ON Posts.UserID = Accounts.UserID WHERE Posts.PostID NOT IN (SELECT Comments.PostID FROM Comments)");
			$resultComment = mysqli_query($conn, $queryComment);
			$rowComment = mysqli_fetch_assoc($resultComment);
			
			echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
			<tr>
				<th>IdeaID</th>
				<th>Idea Title</th>
				<th>Department</th>
				<th>Idea Contributor</th>
			</tr>';
			foreach($resultComment as $rowComment){
				?>
				<tr>
					<td><?php echo $rowComment['PostID']; ?> </td>
					<td><?php echo $rowComment['Title']; ?> </td>
					<td><?php echo $rowComment['Department']; ?> </td>
					<td><?php echo $rowComment['Username']; ?> </td>
				</tr>
				<?php
			};
			?>
			</table>
			
			<p>&zwnj;</p>
			<h3>Anonymous Ideas</h3>
<?php
			session_start();
			include 'config.php';		
			$queryAnonymous = ("SELECT Posts.PostID, Posts.Title, Posts.Department, Accounts.Username FROM Posts INNER JOIN Accounts ON Posts.UserID = Accounts.UserID WHERE Posts.isAnonymous = '1'");
			$resultAnonymous = mysqli_query($conn, $queryAnonymous);
			$rowAnonymous = mysqli_fetch_assoc($resultAnonymous);
			
			echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
			<tr>
				<th>IdeaID</th>
				<th>Idea Title</th>
				<th>Department</th>
				<th>Idea Contributor</th>
				<th>Anonymous Post</th>
			</tr>';
			foreach($resultAnonymous as $rowAnonymous){
				?>
				<tr>
					<td><?php echo $rowAnonymous['PostID']; ?> </td>
					<td><?php echo $rowAnonymous['Title']; ?> </td>
					<td><?php echo $rowAnonymous['Department']; ?> </td>
					<td><?php echo $rowAnonymous['Username']; ?> </td>
					<td>Yes</td>
				</tr>
				<?php
			};
			?>
			</table>
			
			
			<p>&zwnj;</p>
			<h3>Anonymous Comments</h3>
<?php
			session_start();
			include 'config.php';		
			$queryAnonComments = ("SELECT Comments.CommentID, Comments.Body, Comments.PostID, Posts.Title, Accounts.Username FROM Comments INNER JOIN Accounts ON Comments.UserID = Accounts.UserID INNER JOIN Posts ON Comments.PostID = Posts.PostID WHERE Comments.isAnonymous = '1'");
			$resultAnonComments = mysqli_query($conn, $queryAnonComments);
			$rowAnonComments = mysqli_fetch_assoc($resultAnonComments);
			
			echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
			<tr>
				<th>CommentID</th>
				<th>Comment</th>
				<th>PostID</th>
				<th>Post Title</th>
				<th>Username</th>
				<th>Anonymous Comment</th>
			</tr>';
			foreach($resultAnonComments as $rowAnonComments){
				?>
				<tr>
					<td><?php echo $rowAnonComments['CommentID']; ?> </td>
					<td><?php echo $rowAnonComments['Body']; ?> </td>
					<td><?php echo $rowAnonComments['PostID']; ?> </td>
					<td><?php echo $rowAnonComments['Title']; ?> </td>
					<td><?php echo $rowAnonComments['Username']; ?> </td>
					<td>Yes</td>
				</tr>
				<?php
			};
			?>
			</table>
			
      </div>
    </div>
  </div>
  
  <!-- Date close -->

	<div class="w3-panel">
    	<div class="w3-row-padding-16 w3-padding-16">
    		<div class="topnav w3-col w3-center">
            <h2>Date Disable/Closure</h2>
			<form action="" method="post">
					
						<center><input type="Date" style="width:50%" name="DateBar"/></center>
						<br>
						<button class="w3-button w3-greenwich w3-hover-dark-gray"name="DisableIdeas"><i class="fa fa-calendar-day"></i> Disable Ideas From Date</button>
						<button class="w3-button w3-greenwich w3-hover-dark-gray"name="CloseDate"><i class="fa fa-calendar-times"></i> Close Website From Date</button>
						<br></br>
						<button class="w3-button w3-greenwich w3-hover-dark-gray"name="RemoveDateIdeas"><i class="fa fa-calendar-minus"></i> Remove Current Idea Date</button>
						<button class="w3-button w3-greenwich w3-hover-dark-gray"name="RemoveDateClose"><i class="fa fa-calendar-alt"></i> Remove Current Close Date</button>
<?php
			session_start();
			include "config.php";
			$conn;
			
			if (isset($_POST['DisableIdeas'])) {
				
				if (!empty($_REQUEST['DateBar'])){
					
					$queryCheck = ("SELECT EnteredDate FROM Dates WHERE DisableOrClose = 0");
					$resultCheck = mysqli_query($conn, $queryCheck);
					$rowsCheck = mysqli_num_rows($resultCheck);
					if ($rowsCheck == 0){
						$dateEntered = strtotime($_REQUEST['DateBar']);
						$dateEntered = date('Y-m-d H:i:s', $dateEntered); //now you can save in DB
						$enteredDate = mysqli_real_escape_string($conn, $dateEntered);
						$queryDate = ("INSERT INTO Dates (EnteredDate, DisableOrClose) VALUES ('$dateEntered','0')");
						$resultDate = mysqli_query($conn, $queryDate);
						$message = "Your date has been added";
						echo "<script type='text/javascript'>alert('$message');</script>";
					}
					else{
						$error = "<br>There is already a Disable Date";
						echo $error;
					}
		
				}
				else{
					$error = "<br>You did not enter a Date";
                echo $error;
				}
				
				
			}
			
			if (isset($_POST['RemoveDateIdeas'])){
				
				$queryCheck = ("SELECT EnteredDate FROM Dates WHERE DisableOrClose = 0");
				$resultCheck = mysqli_query($conn, $queryCheck);
				$rowsCheck = mysqli_num_rows($resultCheck);
				if ($rowsCheck == 1){
					$queryRemove = ("Delete FROM Dates WHERE DisableOrClose=0");
					$resultRemove = mysqli_query($conn, $queryRemove);
					$message = "Previous Date has been removed";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}else{
					$error = "<br>There is no Disable Date to remove";
					echo $error;
				}
			}
			
			
			if (isset($_POST['CloseDate'])) {
				
					if (!empty($_REQUEST['DateBar'])){
						
						$queryCheck = ("SELECT EnteredDate FROM Dates WHERE DisableOrClose = 1");
						$resultCheck = mysqli_query($conn, $queryCheck);
						$rowsCheck = mysqli_num_rows($resultCheck);
						if ($rowsCheck == 0){
							$dateEntered = strtotime($_REQUEST['DateBar']);
							$dateEntered = date('Y-m-d H:i:s', $dateEntered); //now you can save in DB
							$enteredDate = mysqli_real_escape_string($conn, $dateEntered);
							$queryDate = ("INSERT INTO Dates (EnteredDate, DisableOrClose) VALUES ('$dateEntered','1')");
							$resultDate = mysqli_query($conn, $queryDate);
							$message = "Your date has been added";
							echo "<script type='text/javascript'>alert('$message');</script>";
						}
						else{
						$error = "<br>There is already a Close Date";
						echo $error;
						
					}
					
					}
					else{
						$error = "<br>You did not enter a Date";
						echo $error;
			}
			
			}
			
			if (isset($_POST['RemoveDateClose'])){
				
				$queryCheck = ("SELECT EnteredDate FROM Dates WHERE DisableOrClose = 1");
				$resultCheck = mysqli_query($conn, $queryCheck);
				$rowsCheck = mysqli_num_rows($resultCheck);
				if ($rowsCheck == 1){
					$queryRemove = ("Delete FROM Dates WHERE DisableOrClose=1");
					$resultRemove = mysqli_query($conn, $queryRemove);
					$message = "Previous Date has been removed";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}else{
					$error = "<br>There is no Remove Date to remove";
					echo $error;
				}
			}			





			
            mysqli_close($conn); // Closing Connection
			
			?>
			
			</form>

			</div>
    </div>
  </div>
  
  
	<!-- Download CSV -->

  <div class="w3-panel">
    <div class="w3-row-padding-16 w3-padding">
      <div class="w3-col w3-center">
        <h2><center>Download Tables</center></h2>
		<form method="POST" action="export.php">
        <select id="TABLE_NAME" style="width:50%" name="TABLE_NAME">
		<?php
			session_start();
			include 'config.php';
			$getTablesQuery = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
			$resultgetTables = mysqli_query($conn, $getTablesQuery);
			while($rowgetTables=mysqli_fetch_array($resultgetTables)){
				echo '<option>' . $rowgetTables['TABLE_NAME'] . '</option>';
			}
		?>
        </select> 
        <br></br>
		<input type="submit" class="w3-button w3-greenwich w3-hover-dark-gray" value="Download" name="Download"></button>
        </form>
		
        </div>
      </div>
      </div>
    </div>
  
  <!-- "Most" Analytics -->
  <div class="w3-row-padding w3-margin-bottom w3-padding-16">

	  <!-- "Most" Viewed pages -->
	  	    <div class="w3-third">
	<div class="w3-col w3-center" style="width:100%">
	<h2><center>Most viewed pages</center></h2>
		  <!--Table-->
	<table class="w3-table w3-striped w3-white" style="width:100%">
	<tr>
	  <th>Page</th>
	  <th>Views</th>
	  </tr>
	  		<?php
			session_start();
			include 'config.php';
			$getPageQuery = "SELECT * FROM Pages ORDER BY Views DESC";
			$resultgetPageQuery = mysqli_query($conn, $getPageQuery);
			while($rowgetPageQuery=mysqli_fetch_array($resultgetPageQuery)){
				echo '<tr><td>' . $rowgetPageQuery['PageName'] . '</td><td>' . $rowgetPageQuery['Views'] . '</td></tr>';
			}
			echo '</table>';
					
			
		?>
	</table>
	</div>
	</div>

	  <!-- "Most" Active users -->
	  	    <div class="w3-third">
	<div class="w3-col w3-center" style="width:100%">
	<h2><center>Most active users</center></h2>
			  <!--Table-->
<table class="w3-table w3-striped w3-white" style="width:100%">
	<tr>
		<th>User Name</th>
		<th>Posts</th>
	</tr>
		<?php
			session_start();
			include 'config.php';
			$getMostPostsQuery = "SELECT DISTINCT Accounts.Username, COUNT(Posts.UserID) AS NUM FROM Posts LEFT JOIN Accounts ON Posts.UserID = Accounts.UserID GROUP BY Posts.UserID ORDER BY NUM DESC";
			$resultgetMostPostsQuery = mysqli_query($conn, $getMostPostsQuery);
			while($rowgetMostPostsQuery=mysqli_fetch_array($resultgetMostPostsQuery)){
				echo '<tr><td>' . $rowgetMostPostsQuery['Username'] . '</td><td>' . $rowgetMostPostsQuery['NUM'] . '</td></tr>';
			}
			echo '</table>';
			
			
			
			
			
			
			
		?>
	</table>
	</div>
	</div>

		  <!-- "Most" Used browsers -->
		  	    <div class="w3-third">
	<div class="w3-col w3-center" style="width:100%">
	<h2><center>Most used browsers</center></h2>
			  <!--Table-->
	<table class="w3-table w3-striped w3-white" style="width:100%">
	<tr>
		<th>Browser Name</th>
		<th>Uses</th>
	</tr>
		<?php
			session_start();
			include 'config.php';
			$getBrowserQuery = "SELECT * FROM Browser ORDER BY NumberOfUses DESC";
			$resultgetBrowserQuery = mysqli_query($conn, $getBrowserQuery);
			while($rowgetBrowserQuery=mysqli_fetch_array($resultgetBrowserQuery)){
				echo '<tr><td>' . $rowgetBrowserQuery['BrowserName'] . '</td><td>' . $rowgetBrowserQuery['NumberOfUses'] . '</td></tr>';
			}
			echo '</table>';
			
			
			
			
			
			
			
		?>
	</table>
	</div>
	</div>

	</div>


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

			<div class="footer w3-dark-gray w3-center">
				<p><span style='border-bottom:2px white solid;'>Other useful links!</p></span>
		   <a href="https://www.snapchat.com/add/uniofgreenwich" target="_blank"><i class="fab fa-snapchat-ghost w3-margin-right"></i></a>
           <a href="https://twitter.com/UniofGreenwich" target="_blank"><i class="fab fa-twitter w3-margin-right"></i></a>
           <a href="https://www.facebook.com/uniofgreenwich/" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
           <a href="https://www.instagram.com/uniofgreenwich/?hl=en" target="_blank"><i class="fab fa-instagram w3-margin-right w3-margin-bottom"></i></a>
			</div>
</body>
</html>
