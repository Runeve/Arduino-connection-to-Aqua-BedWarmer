<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Arduino Data</title>
	<style>
	.tbl_type,.tbl_type th,.tbl_type td{border:0}
	.tbl_type{width:100%;border-bottom:2px solid #dcdcdc;font-family:Tahoma;font-size:11px;text-align:center}
	.tbl_type caption{display:none}
	.tbl_type th{padding:7px 0 4px;border-top:2px solid #dcdcdc;background-color:#f5f7f9;color:#666;font-family:'돋움',dotum;font-size:12px;font-weight:bold}
	.tbl_type td{padding:6px 0 4px;border-top:1px solid #e5e5e5;color:#4c4c4c}
	</style>
		</head>
	<body>
		<h1>Aruduino Data</h1>
		<table cellspacing="0" border="1" class="tbl_type">
<colgroup>
<col width="3%"><col width="3%"><col width="5%" span="8">
</colgroup>
<thead>
<tr>
<th scope="col">ID</th>
<th scope="col">Sensor_ID</th>
<th scope="col">Time</th>
<th scope="col">AcX</th>
<th scope="col">AcY</th>
<th scope="col">AcZ</th>
<th scope="col">Tmp</th>
<th scope="col">GyX</th>
<th scope="col">GyY</th>
<th scope="col">GyZ</th>
</tr>
</thead>
<tbody>
<tr>
<?php
	include("connect.php");
	
	$result = mysql_query("SELECT * FROM `arduino_data` ORDER BY id DESC");

	while($line = mysql_fetch_array($result))
	{
		echo ' <tr>';
			echo '<td>'.$line["id"].'</td>';
			echo '<td>'.$line["sensor_id"].'</td>';
			echo '<td>'.$line["time"].'</td>';
			echo '<td>'.$line["AcX"].'</td>';
			echo '<td>'.$line["AcY"].'</td>';
			echo '<td>'.$line["AcZ"].'</td>';
			echo '<td>'.$line["Tmp"].'</td>';
			echo '<td>'.$line["GyX"].'</td>';
			echo '<td>'.$line["GyY"].'</td>';
			echo '<td>'.$line["GyZ"].'</td>';
		echo'</tr>';
	}
	?>
</tr>
</tbody>
</table>
	</body>
</html>