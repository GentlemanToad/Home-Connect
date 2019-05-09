<?php
	// Function returns logged in members first name from database using userID
	function firstName($userID)
	{
		include 'connect.php'; //connect to database
		$stmt=$conn->prepare("SELECT FirstName FROM Users WHERE User_ID=:userid");
		$stmt->bindPARAM(":userid",$userID, PDO::PARAM_INT);
		$stmt->execute();
		$rcount=$stmt->rowCount();
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		if($rcount>0)
		{
			$firstname=$row->FirstName;
			$conn=null; //disconnect database
			return $firstname;
		}
		$conn=null; //disconnect database
		return null;
	}
	
	// Function to check members username and password against database and set login session if correct otherwise return error
	function loginMember($email,$password)
	{
		$pass = sha1(trim($password)); //remove white space and predefined characters from entered password
		include 'connect.php';  //connect to database
		$stcount=$conn->prepare("SELECT User_ID FROM Users WHERE email=:email"); //sql query to return memberid based on email address
		$stcount->bindPARAM(":email",$email,PDO::PARAM_STR); //binding email to php variable
		$stcount->execute(); //run the sql query
		$rcount=$stcount->rowCount(); //store number of rows returned based on query run above
		$row = $stcount->fetch(PDO::FETCH_OBJ); //next row is returned and stored here
		
		if($rcount>0) //checks to see if an entry has been returned
		{
			
			$userID = $row->User_ID; //assign userid returned to this variable
			//check if session userid is set and contains the user_ID value
			if(isset($_SESSION["id_loggedIn"]) && $_SESSION["id_loggedIn"]==$userID)
			{
				$conn = null; //disconnect database
				return "Logged in already"; //return message member already logged in
			}
			
			//Check for password
			$stpass=$conn->prepare("SELECT Password, FailedAttempts FROM Users WHERE User_ID=:userid"); //sql query to return password based on userid
			$stpass->bindPARAM(":userid",$userID,PDO::PARAM_INT); //binding userid to php variable
			$stpass->execute(); //run the sql query
			$stmembercount=$stpass->rowCount(); //store number of rows returned based on query run above
			
			$strow = $stpass->fetch(PDO::FETCH_ASSOC); //next row is returned and stored here
			$attemptnum= $strow["FailedAttempts"];
			
			if(($stmembercount>0) AND ($attemptnum<3)) //checks to see if an entry has been returned
			{
				
				if($pass==$strow['Password']) //verifies stored hashed password and entered password are the same
				{
					
					$stattempt=$conn->prepare("UPDATE Users SET FailedAttempts = 0 WHERE User_ID=:userid");
					$stattempt->bindPARAM(":userid",$userID,PDO::PARAM_INT);
					$stattempt->execute(); //run the sql query
					$_SESSION['id_loggedIn']="$userID"; //id_loggedIn session is assigned memberid as user details entered are a match
					//session_write_close();
					$conn = null; //database is disconnected
					return 10;
				}
				else
				{
					$stattempt=$conn->prepare("UPDATE Users SET FailedAttempts = FailedAttempts + 1 WHERE User_ID=:userid");
					$stattempt->bindPARAM(":userid",$userID,PDO::PARAM_INT);
					$stattempt->execute(); //run the sql query
					if($attemptnum<2)
					{
						$dbcount = 2 - $attemptnum;
						unset($_SESSION["id_loggedIn"]); //id_loggedIn session is assigned a null as user's password entered did not match
						$_SESSION["numberattempt"]=$dbcount;
						$conn = null;
						return $dbcount;
					}
					else
					{
						unset($_SESSION["id_loggedIn"]); //id_loggedIn session is assigned a null as user's password entered did not match
						$_SESSION['attempttomany']=1; //set session to show member exceeded number of login attempts
						$conn = null;
						return 3;
					}
				}
			}
			else
			{
				
				unset($_SESSION["id_loggedIn"]); //id_loggedIn session is assigned a null as user's password entered did not match
				$_SESSION['attempttomany']=1; //set session to show member exceeded number of login attempts
				return 3;
			}
		}
		
		$conn=null; //disconnect database
		return "Not Exist";
	}
	
	// Function to log member out
	function logoutMember()
	{
		unset($_SESSION["id_loggedIn"]);
		$_SESSION['test']="Log out";
		header("Location:  http://localhost:81/Team-A/Frontend/index.php"); //go to home page
		exit;
	}
	

?>
