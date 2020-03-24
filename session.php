<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['loggedin_user'];
   
   $ses_sql = mysqli_query($db,"SELECT Username FROM Accounts where username ?");

   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $login_session = $row['username'];

   if(!isset($_SESSION['loggedin_user'])){
      header("location:login.php");
      die();
   }
?>
