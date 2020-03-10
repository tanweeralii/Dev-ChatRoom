<?php
require_once 'autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucketName = '';
$IAM_KEY = '';
$IAM_SECRET = '';
$type = "file";
$db = pg_connect("host= dbname= user= password=");
$timezone = date_default_timezone_set('Asia/Calcutta');
$date = date('Y-m-d', time());
$time = date('H:i:s', time());
try {
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => 'ap-south-1',
				'signature' => 'v4'
			)
		);
	} catch (Exception $e) {
		die("Error: " . $e->getMessage());
		echo "error";
}
$keyName = basename($_FILES['file']['name']);
$pathInS3 = 'https://s3.ap-south-1.amazonaws.com/' . $bucketName . '/' . $keyName;
if($_FILES['file']['name']!=''){
    try {
        $file = $_FILES['file']['tmp_name'];
	    $s3->putObject(
		    array(
			    'Bucket'=> $bucketName,
			    'Key' =>  $keyName,
			    'SourceFile' => $file,
			    'StorageClass' => 'REDUCED_REDUNDANCY'
		    )
    	);
    	$result = pg_query($db, "INSERT INTO conversation(sender, receiver, date1, os, time1, ip, type) VALUES('".$_POST['sender']."', '".$_POST['receiver']."', '$date', '".$_POST['os']."', '$time', '".$_POST['ip']."', '$type')");
    	$result1 = pg_query($db, "INSERT INTO reply(chat_id, message) VALUES((SELECT chat_id FROM conversation WHERE date1='$date' AND time1='$time'), '".$_FILES['file']['name']."')");
    	echo basename( $_FILES['file']['name']);
    } catch (S3Exception $e) {
	    die('Error:' . $e->getMessage());
    } catch (Exception $e) {
	    die('Error:' . $e->getMessage());
    }
}
else{
    echo "failure";
}

?>
