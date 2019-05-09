<?php
	// A simple PHP script used to connect to MySQL using PDO.
	// setup variables for webhost environment
	$servername = "localhost";
	$database = "id20190501_homeconnect";
	$uname = "id20190501_multipass";
	$pword = "2019Home@Connect";
	// Attempt to create connection using PDO
	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$database", $uname, $pword);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	//Connection failed, find out why
	catch(PDOException $e)
	{
		//Display error message
		echo "Connection failed: " . $e->getMessage();
	}
?>