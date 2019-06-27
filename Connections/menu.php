<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_menu = "localhost";
$database_menu = "menu";
$username_menu = "root";
$password_menu = "";
$menu = mysql_pconnect($hostname_menu, $username_menu, $password_menu) or trigger_error(mysql_error(),E_USER_ERROR); 
?>