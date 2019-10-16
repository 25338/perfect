<?
//установка временной зоны
date_default_timezone_set("Asia/Almaty");

include "db.php";
include "ru.php";

$lang=1;
$sql="select kod,txt_1,txt_2,txt_3 from kw";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$kw[$row['kod']]=str_replace("\n",'<br>',$row[$lang]);
}

$msg=$kw['error_send'];

$fio=$_REQUEST['fio'];
$txt=$_REQUEST['txt'];
$phone=$_REQUEST['phone'];
$email=$_REQUEST['email'];

if($fio && $txt){
	$tag=2;
	$date_create=date("YmdHis");
	$fio=strip_tags($fio);
	$phone=strip_tags($phone);
	$email=strip_tags($email);
	$txt=strip_tags($txt);

	$set="set fio='$fio', phone='$phone', email='$email', txt='$txt', date_create='$date_create', visibled=0";
	$sql="insert into otziv ".$set;
	$conn->query($sql);
	$msg=$kw['youfeedbacksend'];

	//отправка уведомлений в почту
	$mess =$kw['feed_text']."<br><br>";
	$mess.=$kw['client_name'].': '.$fio."<br>";
	$mess.=$kw['client_phone'].': '.$phone."<br>";
	$mess.=$kw['client_email'].': '.$email."<br>";
	$mess.=$kw['youtext'].':<br>'.$txt;

	$subj=$kw['subject_testimonial'];

	include "mail2.php";

	//smtpmail($fio, $email, $kw['title_site'], $kw['testimonial_send']);

}

echo $msg;

?>
