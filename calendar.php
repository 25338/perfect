<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
$tag=1;

$send_calendar=$_POST['send_calendar'];
if($send_calendar){
	$tag=2;
	$date_create=date("YmdHis");
	$date1=$_POST['date1'];
	$time1=$_POST['time1'];
	$fio=strip_tags($_POST['fio']);
	$phone=strip_tags($_POST['phone']);
	$email=strip_tags($_POST['email']);
	$bank=intval($_POST['bank']);
	$zalog=$_POST['zalog'];$zalog=($zalog) ? 1 : 0;
	$zalog2=$_POST['zalog2'];$zalog2=($zalog2) ? 1 : 0;

	$set="set date1='$date1', time1='$time1', fio='$fio', phone='$phone', email='$email', id_bank=$bank, zalog=$zalog, zalog2=$zalog2, date_create='$date_create'";
	$sql="insert into zapriem ".$set;
	$conn->query($sql);
}
?>
<? if($tag==1) { ?>
<style>
.dis {
    color: #f00;
    text-decoration: line-through;
}
</style>

<form method="POST" class="form2" >
	<div class="container">
	  	<div class="row">
			<div class="col">
				<span class="news_tit"><? echo $kw["calendar"].' '.$s;?></span>
				<div class="mycol">
					<? echo $kw['date'];?>:<br>
					<input type="text" name="date1" id="date1" readonly="readonly" required class="form-control date1">
				</div>
				<div class="mycol">
					<? echo $kw['time'];?>:<br>
					<select name="time1" class="form-control" id="time_free" required>
					</select>
				</div>
	   		</div>
	   	</div>
	   	<div class="row">
	   	   	<div class="col">
			<? echo $kw["fio_appeal"].' ('.$kw['required'].')';?>:<br>
			<input type="text" name="fio" class="form-control" required>
			<? echo $kw["appeal_phone"].' ('.$kw['required'].')';?>:<br>
			<input type="tel" name="phone" class="form-control" required pattern="[0-9]{11}" maxlength="11" placeholder="8xxxxxxxxxx" size="11">
			<? echo $kw["appeal_email"];?>:<br>
			<input type="email" name="email" class="form-control" required>
			<? echo $kw["bank"].' ('.$kw['required'].')';?>:<br>
			<select name="bank" class="form-control" required>
				<option></option>
				<? echo getoption('bank','id,txt','','');?>
			</select>
			<br>
			<div class="custom-control custom-checkbox mb-3">
      			<input type="checkbox" class="custom-control-input" id="customCheck" name="zalog">
      			<label class="custom-control-label" for="customCheck"><? echo $kw["zalog"];?></label>
    		</div>
			<div class="custom-control custom-checkbox mb-3">
      			<input type="checkbox" class="custom-control-input" id="customCheck2" name="zalog2">
      			<label class="custom-control-label" for="customCheck2"><? echo $kw["zalog2"];?></label>
    		</div>
			<input type="submit" name="send_calendar" class="btn btn-primary" value="<?=$kw['send2'];?>">
			</div>
		</div>
	</div>
</form>

<script>
var disabledDays = [0, 6];
$('#date1').datepicker({
	 onSelect: function(date) {
            $.ajax({
				url: "/checktime.php", // Куда отправляем данные (обработчик)
				type: "post",
				data: {
					"date1": date,
				},
				success: function(data) {		
					$("#time_free").html(data); // Выводим результат
				}			
			});
        },
    // Можно выбрать тольо даты, идущие за сегодняшним днем, включая сегодня
    minDate: new Date(),
    autoClose: true,
});
$('#date1').datepicker({
    onRenderCell: function (date, cellType) {
        if (cellType == 'day') {
            var day = date.getDay(),
                isDisabled = disabledDays.indexOf(day) != -1;

            return {
                disabled: isDisabled
            }
        }
    }
});
</script>
<? } ?>

<?
//диалог подверждений заявки
if($tag==2) { 
//подключаем модуль отправки почты через smtp
	$mess =$kw['calendar_text']."<br>";
	$mess.=$kw['service'].': '.$kw['almaty']."<br>";
	$mess.=$kw['date'].': '.$date1."<br>";
	$mess.=$kw['time'].': '.$time1."<br>";
	$mess.=$kw['client_name'].': '.$fio."<br>";
	$mess.=$kw['client_phone'].': '.$phone."<br>";
	$mess.=$kw['client_email'].': '.$email."<br>";
	$subj=$kw['subject_calendar'];

include "mail2.php";

?>
<div class="container">
	<div class="row mypadding">
		<div class="alert alert-primary alert-link">
        	<?=$kw['text_priem'];?>
        	<? smtpmail($fio, $email, $kw['title_site'], $kw['text_priem']); ?>
    	</div>
    </div>
</div>
<? } ?>

