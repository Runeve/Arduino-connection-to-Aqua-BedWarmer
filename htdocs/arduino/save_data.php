<?php
	
	include("connect.php");

	$sensor_id = $_GET['sensor_id'];
	$AcX = $_GET['AcX'];
	$AcY = $_GET['AcY'];
	$AcZ = $_GET['AcZ'];
	$Tmp = $_GET['Tmp'];
	$GyX = $_GET['GyX'];
	$GyY = $_GET['GyY'];
	$GyZ = $_GET['GyZ'];

	$sql_insert = "insert into arduino_data(sensor_id,Acx,AcY,AcZ,Tmp,GyX,GyY,GyZ) value('$sensor_id','$AcX', '$AcY', ' $AcZ', '$Tmp', '$GyX' , '$GyY' ,'$GyZ')";
	
	mysql_query($sql_insert);
	
	if($sql_insert)
	{
		echo "insert successfully!";
	}
	else
	{
		echo "error nononono!";
	}
?>