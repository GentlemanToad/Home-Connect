<?php
	
	if(!isset($_SESSION)){session_start();}
	require_once('eform.php');
	
	
	$in=0;
	$errors = "";
	$message = "";
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['signin']))) //check to see if Login form submit button has been clicked
	{
	
		//include('eform.php'); //call the php validation form
		$in = loginMember($_POST['email'],$_POST['password']); //send user login details to validation form and return result
		
		if ($in=="Logged in already")
		{
			$error = "You are already logged in";
		}
		elseif ($in=="Not Exist")
		{
			$error = "User account does not exist, please try again";
		}
		elseif ($in=='3')
		{
			$error = "Incorrect username or password. User blocked, try again after 24 hours";
			
		}
		elseif ($in<3)
		{
			$error = "Incorrect username or password, you have ".$in." attempts left";
			
		}
		else
		{
			echo $in;
			exit;
			//header("Location: http://localhost:81/Team-A/Frontend/index.php");
		}
		
	}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Home Connect | Sign in</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/floating-labels/">

   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin-style.css" rel="stylesheet">
  </head>
	<body>
		<form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"  > <!--This assigns id to login form and provides the way system is to perform an action once submit button has been clicked by user-->
		  <div class="text-center mb-4">
			<img class="mb-4" src="../media/HC-TransparentLogo.png" alt="" width="120" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Home Connect</h1>
			<?php if (($_SERVER['REQUEST_METHOD'] == "POST") && (isset($error)))
				{?>
					<span class="errormsg"><?php echo $error ?></span>
				<?php } else{?>
				<p>To continue, please sign in with your email and password.</p>
				<?php }?>
		  </div>

		  <div class="form-label-group">
			<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
			<label for="inputEmail">Email address</label>
		  </div>

		  <div class="form-label-group">
			<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
			<label for="inputPassword">Password</label>
		  </div>

		  <div class="checkbox mb-3">
			<label>
			  <input type="checkbox" value="remember-me"> Remember me
			</label>
		  </div>
		  <button class="btn btn-lg btn-primary btn-block" value="signin" name="signin" type="submit">Sign in</button>
		  <p class="mt-5 mb-3 text-muted text-center"> &copy; Home Connect by Team A - Building IT Systems 2019</p>
		</form>
	</body>
</html>
