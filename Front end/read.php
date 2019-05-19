<?php
	if(!isset($_SESSION)){session_start();}
	require ("eform.php");
	require("connect.php");

	$username = null;
	$stuserid = $_SESSION['id_loggedIn'];
	$stquery = $conn->prepare("SELECT Chat_ID, UserOne_ID, UserTwo_ID, Messages, MessageTime FROM Chatsession WHERE UserOne_ID=:stuserid OR UserTwo_ID=:stuserid"); //sql query to return memberid based on email address
	$stquery->bindParam(':stuserid',$stuserid,PDO::PARAM_STR);
	$stquery->execute(); //run the sql query
	//$rcount = $stquery->rowCount(); //store number of rows returned based on query run above
	//$result = $stquery->fetchAll(PDO::FETCH_ASSOC);
	
	if($stquery->rowCount()) //checks to see if an entry has been returned
	{
		
		while($result = $stquery->fetch(PDO::FETCH_ASSOC))
		{
			
			if($result['UserOne_ID']==$stuserid)
			{
				$username = firstName($stuserid);
			}
			else
			{
				$username = firstName($result['UserOne_ID']);
			}
			$text=$result["Messages"];
			$time=date('G:i', strtotime($result["MessageTime"])); //outputs date as # #Hour#:#Minute#

			echo "<p>$time  $username: $text</p>\n<p>";
			
		}

	//If the query was NOT successful
	/*echo "An error occured";
	echo $conn->errno;*/
	}
?>