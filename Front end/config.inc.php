<?php
    
    session_start();

    define("C_MYSQL_HOST", "localhost");
    define("C_MYSQL_USER", "id20190501_multipass");
    define("C_MYSQL_PWD", "2019Home@Connect");
    define("C_MYSQL_DB", "id20190501_homeconnect");

    define("C_SESSION_USER_ID_KEY", "id_loggedIn");

    // purposefully didn't close the tag, just to aviod accidental outputs
    // that may fail the redirects (i.e. header : location)
    // this file will contain just configuraton