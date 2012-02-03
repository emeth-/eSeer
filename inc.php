<?
session_start();
$mysqlConfig = array(
"mysql_user" => "root", 
"mysql_password" => "root", 
"mysql_db" => "eseer", 
"mysql_server" => "localhost"
);
$con = mysql_connect($mysqlConfig['mysql_server'],$mysqlConfig['mysql_user'],$mysqlConfig['mysql_password']);
if (!$con)
{
    //die('Could not connect: ' . mysql_error());
   die('Error connecting to DB');
}
mysql_select_db($mysqlConfig['mysql_db'], $con);
?>
