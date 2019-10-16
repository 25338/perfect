<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;
//номер страницы
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

//id номер обращений
$id_appeal=intval($_REQUEST['id_appeal']);
if($id_appeal>0){ $tag=2;}

?>
<div style="padding:10px;">
<h3 ><i class="fas fa-bars"></i> <? echo $kw["appeals"];?></h3>
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
<th scope="col"><? echo $kw["bank"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["date"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<?
$p=($page-1)*$max_view;
$sql="select id,fam,imy,otc,id_bank,date_create from appeals order by date_create desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	$fio=$row['fam'].' '.$row['imy'].' '.$row['otc'];
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
	echo '<td class="align-middle">';
		echo $bank;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $date1;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?page='.$page.'&id_appeal='.$id.'" >';
		echo '<i class="far fa-envelope-open"></i> ';
		echo $kw["open"].'</a>';
	echo '</td>';
	echo '</tr>';
}
?>
</tbody>
</table>
<?
	//нумерация страниц
	$url1="/login/appeals/?";
	$tables="appeals";
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
	$data=getrec("appeals","fam,imy,otc,phone,address,iin,id_bank,email,txt,date_create,file1,file2,file3,file4,file5,file6,file7,file8,file9","where id=$id_appeal");
	$fam=$data['fam'];
	$imy=$data['imy'];
	$otc=$data['otc'];
	$phone=$data['phone'];
	$email=$data['email'];
	$address=$data['address'];
	$iin=$data['iin'];
	$date1=load_datetime($data['date_create']);
	$txt=$data['txt'];$txt=str_replace("\n","<br>",$txt);
	$b=intval($data['id_bank']);$data1=getrec("bank",'txt','where id='.$b);$bank=$data1[0];
	for($i=1;$i<=9;$i++){
		$f=explode('@@',$data['file'.$i]);
		$file[$i]=$f[1];
		$file1[$i]=$f[0];
	}

?>
<div class="container">
	<div class="row bg-light">
		<div class="col text-right"><? echo $kw['date'];?>:</div>
		<div class="col textdark"><? echo $date1;?></div>
	</div>
	<div class="row">
		<div class="col text-right"><? echo $kw['fam'];?>:</div>
		<div class="col textdark"><? echo $fam;?></div>
	</div>
	<div class="row bg-light">
		<div class="col text-right"><? echo $kw['imy'];?>:</div>
		<div class="col textdark"><? echo $imy;?></div>
	</div>
	<div class="row">
		<div class="col text-right"><? echo $kw['otc'];?>:</div>
		<div class="col textdark"><? echo $otc;?></div>
	</div>
	<div class="row bg-light">
		<div class="col text-right"><? echo $kw['appeal_phone'];?>:</div>
		<div class="col textdark"><? echo $phone;?></div>
	</div>
	<div class="row">
		<div class="col text-right"><? echo $kw['appeal_email'];?>:</div>
		<div class="col textdark"><? echo $email;?></div>
	</div>
	<div class="row bg-light">
		<div class="col text-right"><? echo $kw['appeal_address'];?>:</div>
		<div class="col textdark"><? echo $address;?></div>
	</div>
	<div class="row bg-light">
		<div class="col text-right"><? echo $kw['appeal_iin'];?>:</div>
		<div class="col textdark"><? echo $iin;?></div>
	</div>
	<div class="row">
		<div class="col text-right "><? echo $kw['bank'];?>:</div>
		<div class="col textdark"><? echo $bank;?></div>
	</div>
	<div class="row bg-light">
		<div class="col text-right "><? echo $kw['sut-raznoglasiya'];?>:</div>
		<div class="col textdark"><? echo $txt;?></div>
	</div>
<?
$akw=array('appeal_udost','appeal_bank','pismo_v_bank','pismo_ot_banka','appeal_obrashenie','anketa_k_ombudsman','dogovor_bank','appeal_spravka','appeal_itd');
$afile=array(2,4,7,9);
//for($i=1;$i<=9;$i++){
foreach ($afile as $key => $i) {
?>
	<div class="row bg-dark">
		<div class="col text-right text-white"><? echo $kw[$akw[$i-1]];?>:</div>
		<div class="col bg-secondary file">
			<? if($file1[$i]) { ?>
			<i class="fas fa-download"></i> <a class="text-white" href="/appeals/<? echo $file1[$i];?>" download="<? echo $file[$i];?>"><? echo $file[$i];?></a>
		    <? } ?>
		</div>
	</div>
<? } ?>
	<div class="row noprint">
		<div class="col text-center">
			<div class="mypadding">
			<a class="btn btn-primary" href="/login/appeal/?page=<?=$page;?>"><i class="fas fa-ban"></i> <?=$kw['close'];?></a>
			</div>
		</div>
	</div>
</div>
<? }
//конец условий tag=2
?>
</div>
</div>
