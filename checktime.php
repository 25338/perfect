<?
date_default_timezone_set("Asia/Almaty");


//подключаем конфигирационный файл где указаны логин и пароль базы данных
include_once "dbconfig.php";

//соединяем базы данных
$conn=new mysqli("$dbhost", "$dbuser", "$dbpass","$dbname");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//переключаем кодировку на UTF8
$conn->set_charset("utf8");

$date1=$_REQUEST["date1"];
$atime=array('09:30','10:00','10:30','11:00','11:30','14:30','15:00','15:30','16:00','16:30','17:00','17:30');

//массив фиксированной времени
$timefix=array();

//текущее время
$timer=date("H:i");$dater=date("d.m.Y");
foreach ($atime as $key => $value) {
	if($value<$timer && $dater==$date1){
		$timefix[]=$value;
	}
}

$sql="select time1 from zapriem where date1='".$date1."'";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$timefix[]=$row['time1'];
}

echo '<option ></option>';
foreach ($atime as $key => $value) {
//	$disabled=(in_array($value,$timefix, true)) ? 'disabled' : '';
//	$class=(in_array($value,$timefix, true)) ? ' class="dis" ' : '';
	if(in_array($value,$timefix, true)!=true  && $date1){
		echo '<option value="'.$value.'" '.$disabled.' '.$class.'>'.$value.'</option>';
	}
}
?>
