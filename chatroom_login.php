<?php
$db = pg_connect("host= dbname= user= password=");
$email = $_POST['email'];
$password = $_POST['password'];
$ok = true;
$message = array();
if(strlen($email)!=0 && strlen($password)!=0){
	$salted_email = "ndfh$%^~k4354)(%".$_POST['email']."bndiepxm&@!_+=}{?";
	$hashed_email = hash('sha512', $salted_email);
	$salted_password = "ndfh$%^~k4354)(%".$_POST['password']."bndiepxm&@!_+=}{?";
	$hashed_password = hash('sha512', $salted_password);
	$result1 = pg_query($db, "SELECT id1 FROM chatroom_credentials WHERE email = '$hashed_email'");
	$id1 = pg_fetch_assoc($result1);
	if($id1['id1']==1){
		$result2 = pg_query($conn, "SELECT password FROM chatroom_credentials WHERE email = '$hashed_email'");
		$password1 = pg_fetch_assoc($result2);
		if($password1['password'] == $hashed_password){
			$message[] = 'Successfull login';
			$ok = true;
		}
		else{
			$message[] = 'Incorrect Password!';
			$ok = false;
		}
	}
	else{
		$ok = false;
		$message[] = 'Email does not exists!';
	}
}
else{
	$ok = false;
	$message[] = 'Field should not be empty!';
}
echo json_encode(
	array(
		'ok' => $ok,
		'message' => $message
	)
);
?>
