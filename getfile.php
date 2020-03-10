<?php
require_once '/path_to_autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
$bucketName = '';
$IAM_KEY = '';
$IAM_SECRET = '';

$keyPath = $_GET['u'];
$keyPath = trim($keyPath);
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
     $result = $s3->getObject(array(
      'Bucket' => $bucketName,
      'Key'    => $keyPath
    ));
    
    header("Content-Type: {$result['ContentType']}");
    header('Content-Disposition: filename= $keyPath');
    echo $result['Body'];
}
catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

?>
