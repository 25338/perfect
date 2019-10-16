<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//подключаем язык интерфейса
include_once "ru.php";
//подключаем функции 
include_once "function.php";


//строку URL закидываем в массив
$uri=explode('/',$_SERVER["REQUEST_URI"]);

//провераем язык, если не указан, то будет русский
if(!$uri[1]){ header("location: /ru/"); }

//язык системы
$alang=array(1=>'ru',2=>'kz',3=>'en');
$i=intval(array_search($uri[1], $alang));
$lang=($i>0) ? $i : 1;

//
$sql="select kod,txt_1,txt_2,txt_3 from kw";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$kw[$row['kod']]=str_replace("\n",'<br>',$row[$lang]);
}

$title_site=$kw['title_site'];
$keywords=$kw['keywords'];
$descriptions=$kw['descriptions'];

//проверка логин и пароль для админ панель
$enter=$_POST["enter"];
if($enter){
	$_username=trim(strip_tags($_POST["_username"]));
	$_password=$_POST["_password"];
	//вызов функции getrec из файла function.php
	//принимаемын значение функции getrec: 1 - имя таблицы, 2 - поля в таблица, 3 - условия в таблице
	$data=getrec("u","id,pass","where user='$_username'");
	$id=intval($data["id"]);$pas=$data['pass'];
	if( password_verify($_password,$pas) ) {
		$_SESSION["admin_id"]=$id;
	}else{
		$id=0;
	}
	$err=($id) ? '' : $kw['error_login_pass'];
}
//admin_id Сессия админ панеля
$admin_id=intval($_SESSION["admin_id"]);

?>
