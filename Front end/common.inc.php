<?php

    include_once "database.inc.php";

    function GetUser($userId)
    {
        $conn = Database::getInstance();
        $query = "SELECT * FROM Users WHERE User_ID = :UserId";
        $stmt = $conn->prepare($query);
        $stmt->bindPARAM(":UserId", $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        return array(
            "FirstName" => $row->FirstName,
            "LastName" => $row->LastName,
            "FullName" => $row->FirstName . " " . $row->LastName,
            "Email" => $row->Email
        );
    }

    function GetLoggedInUserId()
    {
        return $_SESSION[C_SESSION_USER_ID_KEY];
    }

    // redirect browser to a page/location
    function Redirect($location)
    {
        header("location: " . $location);
        exit;
    }

    function Logout()
    {
        foreach ($_SESSION as $key => $value) 
        {
            unset($_SESSION[$key]);
        }

    	Redirect("index.php");
    }

    // closing tag purposefully ommitted, just to aviod accidental outputs
    // that may fail the redirects (i.e. header : location)
    // this file will contain just functions