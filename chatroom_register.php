<?php
$db = pg_connect("host= dbname= user= password=");
$salted_email = "ndfh$%^~k4354)(%".$_POST['email']."bndiepxm&@!_+=}{?";
$hashed_email = hash('sha512', $salted_email);
$result1 = pg_query($db, "SELECT id1 FROM chatroom_credentials where email = '$hashed_email'");
$t1 = pg_fetch_assoc($result1);
$ok = true;
$message = array();
if(strlen($_POST['first_name']) >= 2 && strlen($email) >= 0){
	if($t1['id1']!=1){
		if(strlen($_POST['password'])>=8 && strlen($_POST['password'])<=15){
			if($_POST['password'] == $_POST['confirm_password']){
				$salted_password = "ndfh$%^~k4354)(%".$_POST['password']."bndiepxm&@!_+=}{?";
				$hashed_password = hash('sha512', $salted_password);
				$salted_first_name = "ndfh$%^~k4354)(%".$_POST['first_name']."bndiepxm&@!_+=}{?";
				$hashed_first_name = hash('sha512', $salted_first_name);
				$salted_last_name = "ndfh$%^~k4354)(%".$_POST['last_name']."bndiepxm&@!_+=}{?";
				$hashed_last_name = hash('sha512', $salted_last_name);
				$uname = explode("@",$_POST['email']);
				$uname1 = $uname[0];
				pg_query($conn, "INSERT INTO chatroom_credentials(id1,password,first_name,last_name,email,uname) VALUES(1,'$hashed_password','$hased_first_name','$hashed_last_name','$hashed_email','$uname1')");
				$ok = true;
				$message[] = 'Successfull login';
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
	}
	else{
		$ok = false;
		$message[] = 'This Email already exists!';
	}
}
else{
	$ok = false;
	$message[] = 'First name or email field should not be empty!';
}
echo json_encode(
	array(
		'ok' => $ok,
		'message' => $message
	)
);
?>
