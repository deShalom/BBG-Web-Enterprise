<?php
include_once 'config.php';

$sql = "SELECT * FROM accounts";
$result =  mysqli_query($conn, $sql);
$resultcheck = mysqli_num_rows($results);

if ($resultcheck > 0){

while ($row = mysqli_fetch_assoc($result)){
    echo $row['userID'];
}

}

?>