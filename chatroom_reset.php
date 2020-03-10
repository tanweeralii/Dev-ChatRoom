<?php
$db = pg_connect("host=localhost dbname=chatroom user=postgres password=89r1hfhm");
$email = $_POST['email'];
$ok = true;
$message = array();
$mail_to_send_to = $_POST['email'];
$from_email = "noreply@thenewbieprojects.com";
$email = $_POST['email'] ;
$headers = "From: $from_email" . "\r\n" . "Reply-To: $email" . "\r\n" ;
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$rand = rand(655545,99999999999);
$variables = array();
$variables['email'] = $email;
$variables['Verification'] = $rand;
$template = file_get_contents("template.html");
foreach($variables as $key => $value)
{
    $template = str_replace('{{ '.$key.' }}', $value, $template);
}
$message1 = $template;
$subject = "Chatroom | Email Confirmation";
if(strlen($email)!=0){
	$salted_email = "ndfh$%^~k4354)(%".$_POST['email']."bndiepxm&@!_+=}{?";
	$hashed_email = hash('sha512', $salted_email);
	$result1 = pg_query($db, "SELECT id1 FROM chatroom_credentials WHERE email = '$hashed_email'"); 
	$id1 = pg_fetch_assoc($result1);
	if($id1['id1']==1){
		$a = mail( $mail_to_send_to,$subject , $message1, $headers );
        if ($a)
        {
            $ok = true;
		    $message[] = 'Successfull!';
		    $abc = $rand;;
		    $encode = base64_encode($abc);
        } else {
            $ok =false;
            $message[] = 'Sorry! Email cannot be sent now, try again later';
        }
	}
	else{
		$ok = false;
		$message[] = 'Email does not exists!';
		$encode = base64_encode("nothing");
	}
}
else{
	$ok = false;
	$message[] = 'Field should not be empty!';
	$encode = base64_encode("nothing");
}
echo json_encode(
	array(
		'ok' => $ok,
		'message' => $message,
		'abc' => $encode
	)
);
?>
