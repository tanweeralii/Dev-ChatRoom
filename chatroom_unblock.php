<?php
$db = pg_connect("host= dbname= user= password=");
$result = pg_query($db, "DELETE FROM block WHERE user2='".$_POST['user2']."' AND user1='".$_POST['user1']."'");
if($result){
	echo "1";
}
?>
