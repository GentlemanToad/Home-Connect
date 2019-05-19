<?php
	if(!isset($_SESSION)){session_start();}
	
	require 'eform.php';
	
	if (isset($_SESSION['id_loggedIn']))
	{
		$userloggedin = firstName($_SESSION['id_loggedIn']);
	}
	else
	{
		header("Location:  http://localhost:81/Team-A/Frontend/signin.php"); //go to home page
		exit;
	}
	
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['signin'])) && isset($_POST['message'])) //check to see if Login form submit button has been clicked
	{
		$in = writeChatSession($_POST['message']);
		header("Location:  http://localhost:81/Team-A/Frontend/chatsession.php");
		exit;
	}
?>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" type="text/css" media="screen"
    />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
</head>
<body>
	<div class="body_chat">
		<div class="container">
			<header class="header">
				<h1>Welcome - <?php echo $userloggedin ?></h1>
				<p class="logout"><a id="exit" href="index.php">Exit Chat</a></p>
			</header>
			<main>
			<form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  >>
				<div class="chat">
					<div id="chatOutput"></div>
					<input id="chatInput" type="text" name="message" class="form-control" placeholder="Enter message here" maxlength="128">
					<button class="chatSend" value="signin" name="signin" type="submit">Sign in</button>
				</div>
			</form>
			</main>
		</div>
	</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/rChat.js"></script>
	<script>
		$(document).ready(function() {
		var chatInterval = 250; //refresh interval in ms
		var $chatOutput = $("#chatOutput");
		var $chatSend = $("#chatSend");

		
		function retrieveMessages() {
			$.get("./read.php", function(data) {
				$chatOutput.html(data); //Paste content into chat output
			});
		}


		setInterval(function() {
			retrieveMessages();
		}, chatInterval);
	});
	</script>
</body>
</html>