<?php

    include_once "database.inc.php";

    /**
     * Get user by user ID
     */
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

    /**
     * Get address from the database row
     */
    function GetAddress($row)
    {
        $address = $row->AddressLine1;
        if($row->AddressLine2)
        {
        $addess .= ", " . $row->AddressLine2;
        }

        return $address . ", " . $row->Suburb . ", " . $row->P_State . " " . $row->PostCode;
    }

    /**
     * Converting an array to list of options of a select element
     * optionally match the selected value for updates
     */
    function ToSelectOptions($arr, $selectedValue = '')
    {
        $options = '';
        foreach ($arr as $value)
        {
            if($value == $selectedValue)
            {
                $options .= '<option value="' . $value . '" selected>' . $value . '</option>';
            }
            else
            {
                $options .= '<option value="' . $value . '">' . $value . '</option>';
            }
        }

        return $options;
    }

    function GetLoggedInUserId()
    {
        return $_SESSION[C_SESSION_USER_ID_KEY];
    }

    /**
     * Redirect browser to a page/location
     */
    function Redirect($location)
    {
        header("location: " . $location);
        exit;
    }

    /**
     * Logout user by clearing the session
     */
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