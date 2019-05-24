<?php
    require_once "config.inc.php";
    require_once "common.inc.php";
    require_once "check_login.php";

    $rentId = $_GET["rentId"];
    
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
    <link  type="text/css" rel="stylesheet" href="style.css">

    <title>Home Connect</title>
  </head>
  <body>
    <div>
        <img src='../media/HomeConnectLogo.png' alt='HomeConnectLogo' height=80>
    </div>

    <?php include_once "nav.php" ?>

    <div class="container">

        <h1>Welcome - <?=GetLoggedInUser()["FullName"] ?></h1>

        <form class="form" id="chat-form" method="POST">
            <div class="chat">
                <div id="chatOutput"></div>

                <div class="input-group input-group-lg mb-3">
                    <input id="chatInput" type="text" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-lg btn-outline-secondary" type="submit">Send</button>
                    </div>
                </div>
            </div>
        </form>

    </div>

    <?php include_once "footer.php" ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript">

        $("#chat-form").submit(function(e){
            e.preventDefault();

            $.post("send-message.php", {
                rentId : "<?=$rentId ?>",
                message : $("#chatInput").val()
            });

            $("#chatInput").val("");
        });

		$(document).ready(function() {
            var chatInterval = 2500; //refresh interval in ms
            var $chatOutput = $("#chatOutput");
            var $chatSend = $("#chatSend");
            
            function retrieveMessages() {
                $.get("chat-history.php?rentId=<?=$rentId ?>", function(data) {
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