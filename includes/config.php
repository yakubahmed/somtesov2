<?php 


	define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'somteso');
	
//Check connection
	$con = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if(!$con) {
		die('Failed to connect to server: ' . @mysqli_error($link));
	}
	
	
	




?>