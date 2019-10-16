<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;

$do=$_REQUEST['do'];
$id_bank=intval($_REQUEST['id_bank']);

if($id_bank>0 || $do=='add'){ $tag=2;}

$save_bank=$_POST['save_bank'];
if($save_bank){
	$bank=htmlspecialchars($_POST['bank'],ENT_QUOTES);
	$id_bank=intval($_POST['id_bank']);
	$visibled=($_POST['visibled']) ? 1 : 0;

	$set=" set txt='".$bank."', visibled=".$visibled;
	$sql=($id_bank) ? "update bank ".$set." where id=$id_bank" : "insert into bank ".$set;
	$conn->query($sql);
	$id_bank=0;
	$tag=1;
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["bank"];?></h3>
<div class="row shadow" style="background-color:#fff;">
<?
if($tag==1){ ?>
	<div class="col" style="padding:10px;">
		<a href="?do=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
	</div>
 
<table class="table table-bordered table-sm table-striped ">
<thead class="thead-dark">
<tr>
<th scope="col" class="text-center" style="width:80px;">ID</th>
<th scope="col"><? echo $kw["bank"];?></th>
<th scope="col" style="width:160px;text-align:center;"><? echo $kw["actions"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["visible"];?></th>
</tr>
</thead>

<tbody>
<?
$sql="select id,txt,visibled from bank ";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row['id'];
	?>
	<tr>
		<td class="text-center"><?=$row['id'];?></td>
	<td class="align-middle">
		<?=$row['txt'];?>
	</td>
	<td class="align-middle text-center " style"width:100px;">
		<a class="btn btn-success btn-sm" href="?id_bank=<?=$id;?>" >
		<i class="far fa-edit"></i> 
		<?=$kw["edit"];?></a>
	</td>
	<td class="align-middle text-center" >
		<? echo ($row["visibled"]) ? '<i class="fas fa-eye"></i>':'<i class="fas fa-eye-slash"></i>';?>
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
	if($id_bank>0){
		$data=getrec('bank','txt,visibled',"where id=$id_bank");
		$bank=$data['txt'];
		$visibled=( intval($data['visibled']) ) ? "checked" : "";
	}
	?>
	<div class="col" style="padding:10px;">
	<form method="POST" >
	<input type="hidden" name="id_bank" value="<? echo $id_bank;?>">

	<div class="form-group row" >
		<label for="bank" class="col-sm-2 col-form-label text_16 text-right"><?=$kw["bank"];?>:</label>
		<div class="col-sm-5">
			<input type="text" name="bank" id="bank" class="form-control" value="<?=$bank;?>" required>
		</div>
	</div>

	<div class="form-group row ">
		<label for="gridCheck1" class="col-sm-2 col-form-label text_16 text-right"><?=$kw['visible'];?>:</label>
		<div class="col-sm-1">
			<input class="form-control form-control-sm" type="checkbox" name="visibled" <?=$visibled;?> id="gridCheck1">';
		</div>
	</div>

	<br><div class="form-group row">
		<label for="txt_1" class="col-sm-2"></label>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-primary btn-sm" name="save_bank" value="<?=$kw["save"];?>"> 
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
