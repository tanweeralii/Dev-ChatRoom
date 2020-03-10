<?php
$timezone = date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d', time());
$time = date('H:i:s', time());

$servername = "";
$username = "";
$password = "";
$dbname =  "";
$conn = pg_connect($servername, $username, $password, $dbname);

$result = pg_query($conn, "INSERT INTO conversation(sender, receiver, date1, os, time1, ip) VALUES('".$_POST['sender']."', '".$_POST['receiver']."', '$date', '".$_POST['os']."', '$time', '".$_POST['ip']."')");

$result1 = pg_query($conn, "INSERT INTO reply(chat_id, message) VALUES((SELECT chat_id FROM conversation WHERE date1='$date' AND time1='$time'), '".$_POST['text']."')");

?>
