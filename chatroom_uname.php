<?php
$db = pg_connect("host= dbname= user= password=");
$result1 = pg_query($db, "SELECT uname FROM chatroom_credentials");
$result2 = pg_query($db, "SELECT COUNT(*) FROM chatroom_credentials");
$count3 = pg_fetch_array($result2);
$rows = array();
while($row = pg_fetch_array($result1)){
	$rows[] = $row;
}
echo json_encode(
	array(
		'count' => $count3[0],
		'users' => $rows
	)
);
?>
