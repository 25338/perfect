<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;
$show=false;

//сохранить запись
$save_profile=$_POST['save_profile'];
if($save_profile){
	$user=$_POST['_login'];
	$pass=password_hash($_POST['_passw'],PASSWORD_DEFAULT);
	$fio=$_POST['fio'];
	$set=' fio="'.$fio.'", user="'.$user.'", pass="'.$pass.'"';
	$sql='update u set '.$set.' where id='.$admin_id;
	$conn->query($sql);
	echo "<script>$ ( function () { $('#myModal').modal('show'); } );</script>";
}

echo Dialog($kw['success'],$kw['saved'],'/login/','myModal'); 

if($tag==1){
	// данные авторизованного пользователя
	$data=getrec("u","fio,user,pass","where id=".$admin_id);
	$fio=$data['fio'];
	$login=$data['user'];
	$passw=$data['pass'];
?>

<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw['profile'];?></h3>
<div class="row shadow" style="background-color:#fff;">
	<div class="col" style="padding:10px;"><form method="POST" >

	<div class="form-group row" >
		<label for="fio" class="col-sm-2 col-form-label text_16 text-right"><? echo $kw['fio'];?>:</label>
		<div class="col-sm-5">
			<input type="text" name="fio" id="fio" maxlength="30" class="form-control" value="<? echo $fio;?>" required>
		</div>
	</div>

	<div class="form-group row" >
		<label for="login" class="col-sm-2 col-form-label text_16 text-right"><? echo $kw['login'];?>:</label>
		<div class="col-sm-4">
			<input type="text" name="_login" id="login" maxlength="20" class="form-control" value="<? echo $login;?>" required>
		</div>
	</div>

	<div class="form-group row" >
		<label for="password" class="col-sm-2 col-form-label text_16 text-right"><? echo $kw['password'];?>:</label>
		<div class="col-sm-4">
			<input type="text" name="_passw" id="password" maxlength="20" class="form-control" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2"></label>
		<div class="col-sm">
			<button type="submit" class="btn btn-primary btn-sm" name="save_profile" value="<? echo $kw["save"];?>"> 
			<i class="fas fa-save"></i> <? echo $kw["save"];?>
			</button> 
			<a href="/login/" class="btn btn-dark  btn-sm" >
			<i class="fas fa-times"></i> <? echo $kw["close"];?>
			</a> 
		</div>
	</div>
	
	</form></div>
</div>
</div>
<?
}
?>