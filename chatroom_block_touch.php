<?php
$servername = "";
$username = "";
$password = "";
$dbname =  "";
$conn = pg_connect($servername, $username, $password, $dbname);
$sql = "SELECT user1 FROM block WHERE user2='".$_POST['user2']."'";
$result = pg_query($conn, $sql);
$result1=pg_fetch_assoc($result);
if($result1['user1']==$_POST['user1']){
	echo "1";
}
$sql2 = "SELECT user1 FROM block WHERE user2='".$_POST['user1']."'";
$result2 = pg_query($conn, $sql2);
$result3 = pg_fetch_assoc($result2);
if($result3['user1']==$_POST['user2']){
	echo "2";
}
?>
