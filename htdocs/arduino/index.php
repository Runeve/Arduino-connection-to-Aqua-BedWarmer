<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Arduino Data</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
	<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
	<script>
	function downloadTXT(){
		document.location.href='/arduino/data.txt';
		return false;
		}
	</script>
	<style>
	.tbl_type,.tbl_type th,.tbl_type td{border:0}
	.tbl_type{width:100%;border-bottom:2px solid #dcdcdc;font-family:Tahoma;font-size:11px;text-align:center}
	.tbl_type caption{display:none}
	.tbl_type th{padding:7px 0 4px;border-top:2px solid #dcdcdc;background-color:#f5f7f9;color:#666;font-family:'돋움',dotum;font-size:12px;font-weight:bold}
	.tbl_type td{padding:6px 0 4px;border-top:1px solid #e5e5e5;color:#4c4c4c}
	</style>
		</head>
	<body>
				<form method=GET name=frm1 action='index.php'>
		<h1>Aruduino Data
		<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored" value = "save" onclick="return downloadTXT()">
		<i class="material-icons">save</i>
		</button>
		</h1>
		<div style="padding:10px;"> 

			센서 이름 : 
				<div class="mdl-textfield mdl-js-textfield">
				<input class="mdl-textfield__input" type="text" name="sensor_id" >
				</div>
			<hr>
			시간 : 
			<input type = "datetime-local" step = '1' name = "time_from" value = "time_from"> 부터
			<input type = "datetime-local" step = '1' name = "time_until" value = "time_until"> 까지
			<hr>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" type = "submit" onclick = "search()" >
			검색
			</button>
				<script>
				function search(){
					
					if(frm1.search.value){
						frm1.submit();
					}else{
						location.href="index.php";
					}
				}
				</script>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" value = "all_view">
			모두 보기
			</button>
			</form>
		</div>

		<hr><hr>
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

  $list = 100; // 한 페이지당 몇개의 글을 보져울 것인가
  $sql = "";
  
  if(empty($_GET['start'])){   
          $page_no= 0;
    }else{
    $page_no= $_GET['start']*$list;  } // limit의 시작위치를 알려주기 위해 


	if(isset($_GET['sensor_id']))
	{
		$sensor_id=$_GET['sensor_id'];
		$time_from = $_GET['time_from'];
		$time_until=$_GET['time_until'];
		$new_time_from = date("Y-m-d H:i:s",strtotime($time_from));
		$new_time_until = date("Y-m-d H:i:s",strtotime($time_until));
	}
	if(!empty($sensor_id) && empty($time_from))//이름만 입력되어있을때
	{
		echo('센서 이름이 [');
		echo($sensor_id); 
		echo('] 인 데이터를 출력합니다');

		$sql .= "SELECT * FROM `arduino_data` WHERE sensor_id = '$sensor_id' ORDER BY id DESC";
	}
	else if(empty($sensor_id) && !empty($time_from))//데이터만 입력되었을때
	{		
		echo('시간이 [');
		echo($new_time_from); 
		echo('] 와 ['); 
		echo($new_time_until); 
		echo('] 사이 인 데이터를 출력합니다');

		$sql .= "SELECT * FROM `arduino_data` WHERE time BETWEEN '$new_time_from' AND '$new_time_until' ORDER BY id DESC";
	}
	else if(!empty($sensor_id) && !empty($time_from))//둘다 입력되었을때
	{
		echo('센서 이름이 [');
		echo($sensor_id); 
		echo('] 이고 시간이 [');
		echo($new_time_from); 
		echo('] 와 ['); 
		echo($new_time_until); 
		echo('] 사이 인 데이터를 출력합니다');
	
		$sql .= "SELECT * FROM `arduino_data` WHERE sensor_id = '$sensor_id' AND (time BETWEEN '$new_time_from' AND '$new_time_until') ORDER BY id DESC";
	}
	else
	{
		$sql .= "SELECT * FROM `arduino_data` ORDER BY id DESC";
	}

		$result = mysql_query($sql);

		if ( !mysql_num_rows($result) ) exit('데이터가 없습니다'); 

		$myfile = fopen("data.txt", "w") or die("Unable to open file!");
		
		$txt = "";
		while($line = mysql_fetch_array($result))
		{
			$txt .= "{$line["id"]}" . " ";
			$txt .= "{$line["sensor_id"]}" . " ";
			$txt .= "{$line["time"]}" . " ";
			$txt .= "{$line["AcX"]}" . " ";
			$txt .= "{$line["AcY"]}" . " ";
			$txt .= "{$line["AcZ"]}" . " ";
			$txt .= "{$line["Tmp"]}" . " ";
			$txt .= "{$line["GyX"]}" . " ";
			$txt .= "{$line["GyY"]}" . " ";
			$txt .= "{$line["GyZ"]}" . "\n";
		}
		fwrite($myfile, $txt);
		fclose($myfile);

	$total = mysql_num_rows($result); //위에서 질의한 전체글의 갯수를 알아내고 
	$sql .=" limit $page_no, $list"; //sql문에 추가적으로 해야 할 것 위에서 ; 반드시 뺀다. 
				//그리고 첫 글자는 반드시 띄운다 위의 sql문과 결합하면 desclimit이 될 수 있기 때문이다. 
	$result = mysql_query($sql);//추가된 부분을 다시 서버에 요청한다
	
	$page_cnt = $total / $list; //총글수를 페이지당수로 나누면 페이지 수가 나온다
	$page_num = $page_no / 100;
	for($i=$page_num-5;$i<$page_num+5;$i++)
	{
		if($i < 0)
			continue;
		else if ($i > $page_cnt)
			continue;
		else
			echo " <a href=$_SERVER[PHP_SELF]?start=$i>[$i] </a>"; 
									//GET방식으로 php 자신에게 넘겨준다
	}  

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