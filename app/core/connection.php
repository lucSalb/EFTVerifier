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
    define('DBUSER', "maillt_smverifieraccount");
    define('DBPASS', "readwxzz7eEY4wKf"); 
    define('DBNAME', "maillt_smverifier"); 
    define('DBHOST', "mamutas.serveriai.lt"); 
}