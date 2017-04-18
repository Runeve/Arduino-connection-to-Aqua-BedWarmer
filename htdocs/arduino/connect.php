<?php
	$usename = "root";
	$password = "";
	$host = "localhost";
	
	$connect = mysql_connect($host,$usename,$password);
	$select = mysql_select_db('arduino_test', $connect);
	
	if($connect)
	{
	}
	else
	{
		echo "Connect error...";
	}
?>