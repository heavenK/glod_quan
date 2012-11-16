<?php
 define('HOST', '.we54.com');
ini_set("session.cookie_domain", HOST);
session_start();//add
print_r($_SESSION);
print_r($_COOKIE);
?>