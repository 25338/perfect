<?
$tag=1;

$send_otziv=$_POST['send_otziv'];
if($send_otziv){
	$tag=2;
	$date_create=date("YmdHis");
	$fio=strip_tags($_POST['fio']);
	$phone=strip_tags($_POST['phone']);
	$email=strip_tags($_POST['email']);
	$txt=strip_tags($_POST['txt']);

	$set="set fio='$fio', phone='$phone', email='$email', txt='$txt', date_create='$date_create', visibled=0";
	$sql="insert into otziv ".$set;
	$conn->query($sql);

	//отправка уведомлений в почту
	$mess =$kw['testimonial_text']."<br><br>";
	$mess.=$kw['client_name'].': '.$fio."<br>";
	$mess.=$kw['client_phone'].': '.$phone."<br>";
	$mess.=$kw['client_email'].': '.$email."<br>";
	$mess.=$kw['otziv_text'].':<br>'.$txt;

	$subj=$kw['subject_testimonial'];

	include "mail2.php";

	smtpmail($fio, $email, $kw['title_site'], $kw['testimonial_send']);

}
?>
<a id="feedback"></a>
<div class="bg-color">
	<div class="container form3">
   		<div class="div-title"><? echo $kw["feedback"];?></div>
   		<div class="top-padding"></div>
		<div class="row">
	   	   	<div class="col-sm">
				<div><? echo $kw["fam"].' '.$kw['imy'].' '.$kw['otc'].' ('.$kw['required'].')';?>:</div>
				<input type="text" name="fio" class="form-control" required id="fio">
				<? echo $kw["youphone"];?>:
				<input type="tel" name="phone" id="phone" class="form-control" pattern="[0-9]{11}" maxlength="11" placeholder="8xxxxxxxxxx" size="11">
				<? echo $kw["youemail"];?>:
				<input type="email" name="email" id="email" class="form-control" >
			</div>
			<div class="col-sm">
				<div><? echo $kw["youtext"].' ('.$kw['required'].')';?>:</div>
				<textarea class="form-control" name="txt" rows=10 required id="txt"></textarea>
				<br>
				<button name="send" class="btn btn-light" id="send"><? echo $kw['send'];?></button>
				<span id="msg"></span>
			</div>
		</div>
	</div>
	<br>
</div>
<?
echo dialog($kw['feedback'],'<div class="data"></div>','','data');
?>
<script type="text/javascript">
	$("#send").click(function(){
		var fio=$('#fio').val();
		var txt=$('#txt').val();
		var phone=$('#phone').val();
		var email=$('#email').val();

		if(fio===""){
			$("#msg").html("<? echo $kw['require_field'];?>");
			return false;
		}
		if(txt===""){
			$("#msg").html("<? echo $kw['require_field'];?>");
			return false;
		}
		//отправляем
	    $.ajax({
			url: "/feedback_input.php", // Куда отправляем данные (обработчик)
			type: "post",
			data: {
				"fio": fio,
				"txt": txt,
				"phone": phone,
				"email": email,
			},
			success: function(data) {		
				$(".data").html(data); // Выводим результат
			}			
		});
		$('#data').modal('show');
		$('#fio').val('');
		$('#txt').val('');
		$('#phone').val('');
		$('#email').val('');
	});
	$("#fio").focus(function(){
		$("#msg").html('');
	});
	$("#txt").focus(function(){
		$("#msg").html('');
	});
</script>
