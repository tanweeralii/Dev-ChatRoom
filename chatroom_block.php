<?php
$servername = "";
$username = "";
$password = "";
$dbname =  "";
$conn = pg_connect($servername, $username, $password, $dbname);
$sql = "INSERT INTO block VALUES('".$_POST['user1']."','".$_POST['user2']."')";
$result = pg_query($conn, $sql);
echo "1";
?>
