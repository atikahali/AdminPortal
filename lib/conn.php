<?php
    // Database connection params
    define('HOST', 'localhost');
    define('USERNAME', 'adminportal');
    define('PASSWORD', 'admin123');
    define('DATABASE', 'adminportal');

	include 'class.php';
	
	$timezone = "Asia/Kuala_Lumpur";
    if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
?>