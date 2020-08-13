<?php
$db_hostname = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "timeschedule";

$dbh = mysql_connect ($db_hostname, $db_username, $db_pass) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($db_name);


?>