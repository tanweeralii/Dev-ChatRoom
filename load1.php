<?php
	$name = $_GET['chat_with_user'];
?>
<html lang="en">
	<head>
		<style type="text/css">
			body{
				background-image:url("images/background3.jpg");
				background-margin:100%;
				height:600px;
				width:900px;
			}
		</style>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="bootstrap.css">
	    <link rel="stylesheet" type="text/javascript" href="js_files/__load1.js">
	    <link href="https://fonts.googleapis.com/css?family=Mansalva&display=swap" rel="stylesheet">
	    <link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar-expand-md bg-dark navbarleft">
            <p class="text-centered pt-3 text-white font-weight-bold pl-2" id="demo"><?php echo $name; ?></p>
            <ul class="navbar-nav ml-auto">
            	<div class="dropdown1">
				  <button class="button6 bg-transparent ml-1 dropbtn" onclick="dropdown()"><img class="image6" src="images/threedots.png" style="width:25px;height:25px;"></button>
				  <div id="myDropdown" class="dropdown1-content">
				    <button  title="Block User" id="block_" onclick="block()">Block</button>
				  </div>
				</div>   
            </ul>
         </nav>
		<div class="chatarea1" id="chatarea1">
			
		</div>
		<div class="footer1">
			<div class="attach1">
				<input type="file" id="file" hidden="hidden" multiple="multiple" name="file"><button class="button6 bg-transparent" id="notrealfile"><image class="image5" src="images/attachicon.png" style="width:35px;height:35px;"></button>
            </div>
            <div class="attach1 message1 form-group">
              	<textarea id="msg" class=" form-control textarea" rows="1" type="text" placeholder="Type a message" aria-label="Search"></textarea>
            </div>
            <div class="attach1 mic1">
            	<image class="image5" id="mic3" src="images/micicon.png" style="width:25px;height:25px;">
           	</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	    <script src="https://kit.fontawesome.com/d82a99eeb8.js" crossorigin="anonymous"></script>
	    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</body>
</html>
