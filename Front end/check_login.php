<?php 

    // This file must be included in every secure pages (the pages need login)
    // so that if the user is not logged in then the user will be automatically
    // redirected to the login page
    if (!isset($_SESSION[C_SESSION_USER_ID_KEY]))
    {
        $_SESSION["requested_url"] = GetRequestedUrl();

        Redirect("signin.php");
    }

    // Get the user's request URL
    function GetRequestedUrl()
    {
        if(isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"] != "")
        {
            return $_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"];
        }
        else
        {
            return $_SERVER["PHP_SELF"];
        }
    }
?>