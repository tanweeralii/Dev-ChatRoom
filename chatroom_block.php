<?php
$db = pg_connect("host= dbname= user= password=");
$result = pg_query($db, "INSERT INTO block VALUES('".$_POST['user1']."','".$_POST['user2']."')");
echo "1";
?>
