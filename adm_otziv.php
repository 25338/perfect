<?
$tag=1;
//номер страницы
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

//id номер обращений
$id_otziv=intval($_REQUEST['id_otziv']);
if($id_otziv>0){ $tag=2;}

$delete=intval($_REQUEST['delete']);
if($delete>0){
	$sql="delete from otziv where id=$delete";
	$conn->query($sql);
}
?>
<div style="padding:10px;">
<h3 ><i class="fas fa-bars"></i> <? echo $kw["feedback"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//показать список обращений
if($tag==1) { 
?>
<table class="table table-sm table-bordered table-striped ">
<thead class="thead-dark ">
<tr>
<th scope="col" class="text-center" style="width:80px;">ID</th>
<th scope="col"><? echo $kw["fio_otziv"];?></th>
<th scope="col"><? echo $kw["appeal_phone"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["date"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<?
$p=($page-1)*$max_view;
$sql="select id,fio,phone,date_create,visibled from otziv order by date_create desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	$fio=$row['fio'];
	$date1=$row['date_create'];$date1=load_datetime($date1);
	$phone=$row['phone'];
	$visibled=($row['visibled']) ? $kw["yes"] : '';
	echo '<tr>';
	echo '<td class="align-middle text-center">';
		echo $id;
	echo '</td>';
	echo '<td class="align-middle">';
		echo $fio;
	echo '</td>';
	echo '<td class="align-middle">';
		echo $phone;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $date1;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?page='.$page.'&id_otziv='.$id.'" >';
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
	$url1="/login/feedback/?";
	$tables="otziv";
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
	$data=getrec("otziv","fio,phone,email,date_create,txt","where id=$id_otziv");
	$fam=$data['fio'];
	$phone=$data['phone'];
	$email=$data['email'];
	$date1=load_datetime($data['date_create']);
	$txt=$data['txt'];$txt=str_replace("\n","<br>",$txt);
?>
<div class="container">
	<div class="row">
		<div class="col-2 text-right"><? echo $kw['fam'];?>:</div>
		<div class="col textdark"><? echo $fam;?></div>
	</div>
	<div class="row">
		<div class="col-2 text-right"><? echo $kw['youphone'];?>:</div>
		<div class="col textdark"><? echo $phone;?></div>
	</div>
	<div class="row">
		<div class="col-2 text-right"><? echo $kw['youemail'];?>:</div>
		<div class="col textdark"><? echo $email;?></div>
	</div>
	<div class="row">
		<div class="col-2 text-right"><? echo $kw['youtext'];?>:</div>
		<div class="col textdark"><? echo $txt;?></div>
	</div>
	<div class="row">
		<div class="col-2 text-right"><? echo $kw['date_create'];?>:</div>
		<div class="col textdark"><? echo $date1;?></div>
	</div>
	<div class="row noprint">
		<div class="col text-center">
			<div class="mypadding">
			<a class="btn btn-primary" href="/login/feedback/?page=<?=$page;?>"><i class="fas fa-ban"></i> <?=$kw['close'];?></a>
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">
			<i class="fas fa-trash-alt"></i> <? echo $kw["delete"];?>
			</button>
			</div>
		</div>
	</div>
</div>
<?
	//вызов окно подверждений
	echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/feedback/?delete='.$id_otziv,"delete");
}
//конец условий tag=2
?>
</div>
</div>