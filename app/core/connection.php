<?php 

if($_SERVER['SERVER_NAME'] == "localhost")
{
    define('DBUSER', "root");
    define('DBPASS', ""); 
    define('DBNAME', "smverifier_db"); 
    define('DBHOST', "localhost"); 
}
else
{
    define('DBUSER', "root");
    define('DBPASS', ""); 
    define('DBNAME', "smverifier_db"); 
    define('DBHOST', "http://www..."); 
}