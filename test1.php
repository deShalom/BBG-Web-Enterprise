<?php
include_once 'config.php';

$sql = "SELECT * FROM accounts;";
$result =  mysqli_query($conn, $sql);
$resultcheck = mysqli_num_rows($result);

if ($resultcheck > 0){
    while ($row = mysqli_fetch_assoc($result)){ // data imported from db is saved as array called $row
        echo $row['Username'].'<br>'.$row['pass']; // displays everything under "Username" and "pass"

    }

}

?>

// works
