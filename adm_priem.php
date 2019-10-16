<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;
//номер страницы
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

//id номер обращений
$id_priem=intval($_REQUEST['id_priem']);
if($id_priem>0){ $tag=2;}

$save=$_POST['save'];
if($save){
	$id_priem=$_POST['id_priem'];
	$date2=$_POST['date1'];
	$time2=$_POST['time1'];
	$set="set date1='$date2', time1='$time2'";
	$sql="update zapriem ".$set." where id=$id_priem";
	$conn->query($sql);
}

$delete=intval($_REQUEST['delete']);
if($delete>0){
	$sql="delete from zapriem where id=$delete";
	$conn->query($sql);
}

//отправление подверждений
$confirm=intval($_REQUEST['confirm']);
if($confirm>0){
	$sql="update zapriem set confirmed=1 where id=$confirm";
	$conn->query($sql);

	$data=getrec("zapriem","date1, time1, fio, email, phone","where id=$confirm");
	$date=$data['date1'];
	$time=$data['time1'];
	$email=$data['email'];
	$fio=$data['fio'];
	$phone=$data['phone'];

	//отправка почты
	$mess =$kw['calendar_text_confirm']."<br>";
	$mess.=$kw['service'].': '.$kw['almaty']."<br>";
	$mess.=$kw['date'].': '.$date."<br>";
	$mess.=$kw['time'].': '.$time."<br>";
	$mess.=$kw['client_name'].': '.$fio."<br>";
	$mess.=$kw['client_phone'].': '.$phone."<br>";
	$mess.=$kw['client_email'].': '.$email."<br>";
	$subj=$kw['subject_calendar_confirm'];
	include "mail2.php";

	$messages=$kw['text_priem_confirm'];
	$messages=str_replace('[[APPOINTMENT_DATE]]',$date,$messages);
	$messages=str_replace('[[APPOINTMENT_TIME]]',$time,$messages);
	$messages=str_replace('[[CLIENT_NAME]]',$fio,$messages);
	$messages=str_replace('[[COMPANY_ADDRESS]]',$kw['address'],$messages);

	smtpmail($fio, $email, $kw['title_site'], $messages);
}

?>
<div style="padding:10px;">
<h3 ><i class="fas fa-bars"></i> <? echo $kw["calendar"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//показать список обращений
if($tag==1) { 
?>
<table class="table table-sm table-bordered table-striped ">
<thead class="thead-dark ">
<tr>
<th scope="col" class="text-center" style="width:80px;">ID</th>
<th scope="col"><? echo $kw["fio_appeal"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["zapis_date"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["date_create"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["confirmed"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<?
$p=($page-1)*$max_view;
$sql="select id,fio,date1,time1,id_bank,date_create,confirmed from zapriem order by UNIX_TIMESTAMP(STR_TO_DATE(date1, '%d.%m.%Y')) desc, time1 desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	$fio=$row['fio'];
	$date0=$row['date1'];//$date0=load_datetime($date1);
	$time0=$row['time1'];
	$confirmed=$row['confirmed'];$confirmed=($confirmed) ? $kw['yes'] : '';

	$date1=$row['date_create'];$date1=load_datetime($date1);
	$b=intval($row['id_bank']);
	$data=getrec("bank",'txt','where id='.$b);$bank=$data[0];
	echo '<tr>';
	echo '<td class="align-middle text-center">';
		echo $id;
	echo '</td>';
	echo '<td class="align-middle">';
		echo $fio;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		//echo $bank;
		echo $time0.' - '.$date0;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $date1;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?page='.$page.'&id_priem='.$id.'" >';
		echo '<i class="far fa-envelope-open"></i> ';
		echo $kw["open"].'</a>';
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $confirmed;
	echo '</td>';
	echo '</tr>';
}
?>
</tbody>
</table>
<?
	//нумерация страниц
	$url1="/login/priem/?";
	$tables="zapriem";
	$where="";
	$data=getrec($tables,"count(*)",$where);
	$maxrec=intval($data[0]);
	echo ' <div style="padding:7px 20px;">'.$kw["all_rec"].': <b>'.$maxrec.'</b></div>';
	$max_page=$maxrec/$max_view+1;
	if($max_page>2){ 
		echo navLinks($maxrec,$page,$url1);
	}
}
//тут конец if tag=1


//тут будет отображаться детали заявки
if($tag==2){ 
	$data=getrec("zapriem","date1,time1,fio,phone,id_bank,email,date_create,zalog,zalog2","where id=$id_priem");
	$date=$data['date1'];
	$time=$data['time1'];
	$fam=$data['fio'];
	$phone=$data['phone'];
	$email=$data['email'];
	$date1=load_datetime($data['date_create']);
	$txt=$data['txt'];$txt=str_replace("\n","<br>",$txt);
	$b=intval($data['id_bank']);$data1=getrec("bank",'txt','where id='.$b);$bank=$data1[0];
	$zalog=($data['zalog']) ? $kw['yes'] : '';
	$zalog2=($data['zalog2']) ? $kw['yes'] : '';
?>
<link rel="stylesheet" href="/js/datepicker.min.css">
<script src="/js/datepicker.min.js"></script>

<form method="POST" style="width: 100%;"><br>
	<input type="hidden" name="id_priem" value="<?=$id_priem;?>">

<div class="container">
	<div class="row ">
		<div class="col-3 text-right"><? echo $kw['date'];?>:</div>
		<div class="col-2 textdark">
			<? echo $date;?>
		</div>
		<div class="col textdark">
			<input type="text" name="date1" id="date2" readonly="readonly" class="date2">
			<label for="date2"><?=$kw["new_date"];?></label>
		</div>
	</div>
	<div class="row ">
		<div class="col-3 text-right"><? echo $kw['time'];?>:</div>
		<div class="col-2 textdark"><?=$time;?></div>
		<div class="col textdark align-middle" >
			<select name="time1" required id="time_free">
			</select>
			<label for="time_free"><?=$kw["new_time"];?></label>
		</div>
	</div>
	<div class="row">
		<div class="col-3 text-right"><? echo $kw['fio'];?>:</div>
		<div class="col textdark"><? echo $fam;?></div>
	</div>
	<div class="row ">
		<div class="col-3 text-right"><? echo $kw['appeal_phone'];?>:</div>
		<div class="col textdark"><? echo $phone;?></div>
	</div>
	<div class="row">
		<div class="col-3 text-right"><? echo $kw['appeal_email'];?>:</div>
		<div class="col textdark"><? echo $email;?></div>
	</div>
	<div class="row">
		<div class="col-3 text-right "><? echo $kw['bank'];?>:</div>
		<div class="col textdark"><? echo $bank;?></div>
	</div>
	<div class="row">
		<div class="col-3 text-right "><? echo $kw['zalog'];?>:</div>
		<div class="col textdark"><? echo $zalog;?></div>
	</div>
	<div class="row">
		<div class="col-3 text-right "><? echo $kw['zalog2'];?>:</div>
		<div class="col textdark"><? echo $zalog2;?></div>
	</div>
	<div class="row">
		<div class="col-3 text-right "><? echo $kw['date_create'];?>:</div>
		<div class="col textdark"><? echo $date1;?></div>
	</div>
	<div class="row noprint">
		<div class="col text-center">
			<div class="mypadding">
			<button type="submit" class="btn btn-primary" name="save" value="<? echo $kw["save"];?>" >
			<i class="fas fa-save"></i>
			<? echo $kw["save"];?>
			</button>

			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#confirm" >
			<i class="fas fa-thumbs-up"></i>
			<? echo $kw["confirm"];?>
			</button>

			<a class="btn btn-secondary" href="/login/priem/?page=<?=$page;?>"><i class="fas fa-ban"></i> <?=$kw['close'];?></a>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
			<i class="fas fa-trash-alt"></i> <? echo $kw["delete"];?>
			</button>
			</div>
		</div>
	</div>

</div>
</form>
<script>
var disabledDays = [0, 6];
$('#date2').datepicker({
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
$('#date2').datepicker({
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
<? 
	//вызов окно подверждений
	$mess ='<br><br>'.$kw['date'].': '.$date;
	$mess.='<br>'.$kw['time'].': '.$time;
	echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/priem/?delete='.$id_priem, "exampleModal");
	echo ConfirmDialog($kw["attention"],$kw["confirm_calendar"].$mess,'/login/priem/?confirm='.$id_priem, "confirm");
}
//конец условий tag=2
?>
</div>
</div>