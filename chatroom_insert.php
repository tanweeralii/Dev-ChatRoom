<?php
$timezone = date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d', time());
$time = date('H:i:s', time());

$db = pg_connect("host= dbname= user= password=");

$result = pg_query($db, "INSERT INTO conversation(sender, receiver, date1, os, time1, ip, type) VALUES('".$_POST['sender']."', '".$_POST['receiver']."', '$date', '".$_POST['os']."', '$time', '".$_POST['ip']."', 'text')");

$result1 = pg_query($db, "INSERT INTO reply(chat_id, message) VALUES((SELECT chat_id FROM conversation WHERE date1='$date' AND time1='$time'), '".$_POST['text']."')");

?>
