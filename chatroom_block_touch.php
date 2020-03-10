<?php
$db = pg_connect("host= dbname= user= password=");
$result = pg_query($db, "SELECT user1 FROM block WHERE user2='".$_POST['user2']."'");
$result1=pg_fetch_assoc($result);
if($result1['user1']==$_POST['user1']){
	echo "1";
}
$result2 = pg_query($db, "SELECT user1 FROM block WHERE user2='".$_POST['user1']."'");
$result3 = pg_fetch_assoc($result2);
if($result3['user1']==$_POST['user2']){
	echo "2";
}
?>
