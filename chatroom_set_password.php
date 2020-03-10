<?php
$db = pg_connect("host= dbname= user= password=");
if(strlen($_POST['password'])>=8 && strlen($_POST['password'])<=15){
	if($_POST['password'] == $_POST['confirm_password']){
		$salted_password = "ndfh$%^~k4354)(%".$_POST['password']."bndiepxm&@!_+=}{?";
		$hashed_password = hash('sha512', $salted_password);
		$salted_email = "ndfh$%^~k4354)(%".$_POST['email']."bndiepxm&@!_+=}{?";
		$hashed_email = hash('sha512', $salted_email);
		pg_query($db, "UPDATE chatroom_credentials SET password='$hashed_password' WHERE email='".$hashed_email."'");
		$ok = true;
		$message[] = 'Successfull!';
	}
	else{
		$ok = false;
		$message[] = 'Password does not match!';
	}
}
else{
	$ok = false;
	$message[] = 'Password Length should be between 8 and 15';
}
echo json_encode(
	array(
		'ok' => $ok,
		'message' => $message
	)
);
?>
