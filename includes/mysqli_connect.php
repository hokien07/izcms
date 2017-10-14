<?php 
	//connect to databaase
	$host = "localhost";
	$username = "root";
	$pass = "";
	$dbname = "izcms";

	$dbc =  mysqli_connect($host, $username, $pass, $dbname);

	//check connect database.
	if(!$dbc) {
		trigger_error("Could not connect to database" . mysqli_connect_error());
	}else {
		//set charset utf8.
		mysqli_set_charset($dbc, 'utf-8');
	}

?>