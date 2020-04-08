 <?php
session_start();
include "config.php";


if(!isset($_SESSION['login_user']))
{           // if used attempts to access this site without being logged in, verified by session, they will be taken back to login.php with a error msgs!
    header("location: login.php?YouAreNotLoggedIn");
}

   if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 5;
        $offset = ($pageno-1) * $no_of_records_per_page;




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
            <button class="w3-right w3-button w3-dark-gray w3-margin-top  w3-bar-item" name="logout" ><a href="logout.php">Logout</a></button>
        </div>
    </div>

    <!-- Page Content -->
	<div class="page w3-content" style="max-width:1500px">

		<div class="w3-white w3-border-bottom">
			<button class="w3-button w3-white w3-xlarge" name= "contentbar" onclick="w3_open()">☰</button>
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

		<fieldset>
			<p class="w3-center">
				<label for="fname">Submitted Ideas</label><br />

			</p>
            <div class="w3-panel">
                    <div class="w3-row-padding w3-padding-16">
					<div class="flex-container">


             <?php
                $total_pages_sql = "SELECT COUNT(*) FROM Posts";
                $sql = mysqli_query($conn, $total_pages_sql);
                $total_rows = mysqli_fetch_array($result)[0];
                $total_pages = ceil($total_rows / $no_of_records_per_page);
                $total_pages = ceil($total_rows / $no_of_records_per_page);

                $sql = "SELECT * FROM Posts LIMIT $no_of_records_per_page OFFSET $offset";
                $data = mysqli_query($conn,$sql);



                while ($row = mysqli_fetch_array($data))
                {

                if($row["isAnonymous"] === 0)
                {
                    $row["isAnonymous"] = "No";
                } else
                {
                    $row["isAnonymous"] = "Yes";
                }

                  if($row["isUploadedDocuments"] === 0)
                {
                    $row["isUploadedDocuments"] = "No";
                } else
                {
                    $row["isUploadedDocuments"] = "Yes";
                }

                echo '<table class="w3-table w3-striped w3-white style=\"width:100%\" ">
            <tr>
                <th>Post ID</th>
                <th>Department</th>
                <th>Idea Title</th>
                <th>Views</th>
                <th>ID Funding</th>
                <th>ID Students</th>
                <th>ID Accessibility</th>
                <th>ID Complaint</th>
                <th>Anonymous</th>
                <th>Downvotes</th>
                <th>Upvotes</th>
            </tr>';

                foreach($sql as $total_pages_sql) {
                  ?>
                <tr>
                 <td><?php echo $row['PostID']; ?> </td>
                 <td><?php echo $row['Title']; ?> </td>
                 <td><?php echo $row['Department']; ?> </td>
                 <td><?php echo $row['Category1ID']; ?> </td>
                 <td><?php echo $row['Category2ID']; ?> </td>
                 <td><?php echo $row['Category3ID']; ?> </td>
                 <td><?php echo $row['isAnonymous']; ?> </td>
                 <td><?php echo $row['Downvotes']; ?> </td>
                 <td><?php echo $row['Upvotes']; ?> </td>


                </tr>
                <?php
                    }
                };
             ?>

             </table>
            </div>
        </div>
    </div>


			<ul class="w3-center pagination">
			    <li><a href="?pageno=1" class= "w3-button">First</a></li>
                <li><a href="?pageno=<?php echo $total_pages; ?>" class="w3-button">Last</a></li>
                <li class="w3-button w3-center <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Back</a>
            </li>

            <li class="w3-button w3-center <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
            </li>

            <br></br>
            <br></br>
            <br></br>


			<div class="footer w3-dark-gray">
				<p><span style='border-bottom:1px white solid;'>Other useful links!</p></span>
				<i class="fab fa-snapchat-ghost w3-margin-right"></i>
				<i class="fab fa-twitter w3-margin-right"></i>
				<i class="fab fa-facebook-f w3-margin-right"></i>
				<i class="fab fa-instagram w3-margin-right"></i>
			</div>
</body>
</html>
