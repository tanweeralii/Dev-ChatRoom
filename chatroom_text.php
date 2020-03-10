<?php
$uname = file_get_contents('php://input');
$data = json_decode($uname);
$uname1 = $data -> uname1;
$uname2 = $data -> uname2;
$db = pg_connect("host= dbname= user= password=");
$count1 = pg_query($db, "SELECT COUNT(*) FROM conversation WHERE sender='$uname1' AND receiver='$uname2'");
$count2 = pg_query($db, "SELECT COUNT(*) FROM conversation WHERE sender='$uname2' AND receiver='$uname1'");
$count1_result = pg_fetch_array($count1);
$count2_result = pg_fetch_array($count2);
$count = $count1_result[0] + $count2_result[0];
$chat_id = pg_query($db, "SELECT chat_id FROM conversation WHERE sender='$uname1' AND receiver='$uname2' UNION SELECT chat_id FROM conversation WHERE sender='$uname2' AND receiver='$uname1' ORDER BY chat_id");
$text_result2 = array();
$time_result2 = array();
$sender_result2 = array();
$date_result2 = array();
$type_result2 = array();
while($chat_id_result = pg_fetch_array($chat_id)){
	$text = pg_query($db, "SELECT message FROM reply WHERE chat_id='".$chat_id_result['chat_id']."' ORDER BY chat_id");
	$time = pg_query($db, "SELECT time1 FROM conversation WHERE chat_id='".$chat_id_result['chat_id']."' ORDER BY chat_id");
	$sender = pg_query($db, "SELECT sender FROM conversation WHERE chat_id = '".$chat_id_result['chat_id']."' ORDER BY chat_id");
	$date = pg_query($db, "SELECT date1 FROM conversation WHERE chat_id='".$chat_id_result['chat_id']."' ORDER BY chat_id");
	$type = pg_query($db, "SELECT type FROM conversation WHERE chat_id='".$chat_id_result['chat_id']."' ORDER BY chat_id");
	$time_result = pg_fetch_array($time);
	$date_result = pg_fetch_array($date);
	$sender_result = pg_fetch_array($sender);
	$text_result = pg_fetch_array($text);
	$type_result = pg_fetch_array($type);
	$text_result2[] = $text_result[0];
	$time_result2[] = $time_result[0];
	$sender_result2[] = $sender_result[0];
	$date_result2[] = $date_result[0];
	$type_result2[] = $type_result[0];
}
echo json_encode(
	array(
		'count'=> $count,
		'text' => $text_result2,
		'time' => $time_result2,
		'date' => $date_result2,
		'sender' => $sender_result2,
		'type' => $type_result2
	)
);
?>
