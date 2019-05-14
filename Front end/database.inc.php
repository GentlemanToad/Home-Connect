<?php

/*
* Creating database as a singleton that can be shared in
* every database calls of the request
*/
class Database 
{
    private static $instatnce; 

    // the constructor and clone are private because -
    // the database instance can only be created usng the getInstance staic method
    private function __construct() {}
    private function __clone() {}

    /*
    * Get database instance (singleton)
    */
    public static function getInstance() 
    {
        // static $instatnce will ensure there's always one instance of 
        // database connection, create if that's null
        if(!self::$instatnce)
        {
            $dsn = "mysql:host=".C_MYSQL_HOST.";dbname=".C_MYSQL_DB;

            self::$instatnce = new PDO($dsn, C_MYSQL_USER, C_MYSQL_PWD);
            self::$instatnce->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }

        return self::$instatnce;    
    }
}