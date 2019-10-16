<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;

$id_kw=intval($_REQUEST['id_kw']);

$save_kw=$_POST['save_kw'];
if($save_kw){
	$txt_1=($_POST['txt_1']);
	$txt_2=($_POST['txt_2']);
	$txt_3=($_POST['txt_3']);
	$id_kw=intval($_POST['id_kw']);

	$sql="update kw set txt_1='".$txt_1."', txt_2='".$txt_2."', txt_3='".$txt_3."' where id=$id_kw";
	$conn->query($sql);
	$id_kw=0;
}

if($id_kw>0){ $tag=2;}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["setting"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
if($tag==1){ ?>
 <div style="padding:10px;"> </div>
 
<table class="table table-bordered table-sm table-striped ">
<thead class="thead-dark">
<tr>
<th scope="col"><? echo $kw["field_name"];?></th>
<th scope="col"><? echo $kw["value"];?></th>
<th scope="col" style="width:160px;text-align:center;"><? echo $kw["actions"];?></th>
</tr>
</thead>

<tbody>
<?
$sql="select id,kod,txt,descript,txt_1 from kw where visibled=1";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	?>
	<tr>
	<td class="align-middle">
		<h6><?=$row['txt'];?></h6>
		<span style="font:12px Arial;color:#555;"><?=$row["descript"];?></span>
	</td>
	<td class="align-middle">
		<?=$row['txt_1'];?>
	</td>
	<td class="align-middle text-center " style"width:100px;">
		<a class="btn btn-success btn-sm" href="?id_kw=<?=$id;?>" >
		<i class="far fa-edit"></i> 
		<?=$kw["edit"];?></a>
	</td>
	</tr>
	<?
}
?>
</tbody>
</table>
<?
} 
//конец условий tag=1

//процедура редактирование меню
if($tag==2){
	$txt_1='';
	$txt_2='';
	$txt_3='';
	if($id_kw>0){
		$data=getrec('kw','kod,txt,txt_1,txt_2,txt_3',"where id=$id_kw");
		$kod=$data["kod"];
		$txt=$data['txt'];
		$txt_1=$data["txt_1"];
		$txt_2=$data["txt_2"];
		$txt_3=$data["txt_3"];
	}
	?>
	<div class="col" style="padding:10px;">
	<form method="POST" >
	<input type="hidden" name="id_kw" value="<? echo $id_kw;?>">

	<div class="form-group row" >
		<label for="txt_1" class="col-sm-2 col-form-label text_16 text-right"><? echo $kw["field_name"];?>:</label>
		<div class="col-sm alert alert-success" >
			<h5><? echo $txt;?></h5>
			<?='Kod: '.$kod;?>
		</div>
	</div>

	<div class="form-group row">
		<label for="txt_1" class="col-sm-2 col-form-label text_16 text-right"><? echo $kw["name_ru"];?>:</label>
		<div class="col-sm">
			<textarea id="txt_1" class="form-control form-control-sm" name="txt_1" rows="7" ><?=$txt_1;?></textarea>
		</div>
	</div>
<?
/*
	<div class="form-group row">
		<label for="txt_2" class="col-sm-2 col-form-label text_16 text-right"><?=$kw["name_kz"];?>:</label>
		<div class="col-sm">
			<textarea id="txt_2" class="form-control form-control-sm" name="txt_2" rows="7" ><?=$txt_2;?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<label for="txt_3" class="col-sm-2 col-form-label text_16 text-right"><?=$kw["name_en"];?>:</label>
		<div class="col-sm">
			<textarea id="txt_3" class="form-control form-control-sm" name="txt_3" rows="7" ><?=$txt_3;?></textarea>
		</div>
	</div>
*/
?>
	<br><div class="form-group row">
		<label for="txt_1" class="col-sm-2"></label>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-primary btn-sm" name="save_kw" value="<?=$kw["save"];?>"> 
			<i class="fas fa-save"></i> 
			<?=$kw["save"];?>
			</button> 
			<a href="/login/<?=$uri[2];?>/" class="btn btn-secondary  btn-sm" >
			<i class="fas fa-ban"></i> 
			<?=$kw["cancel"];?></a>
		</div>
	</div>
	</form>
	</div>
	<?
}
?>
</div>
</div>
