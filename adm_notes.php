<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;

//страница
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

$id_note=intval($_REQUEST["id_note"]);
//если выбран меню то меняем на tag=2 редактирование
if($id_note>0){ $tag=2;}

//запрос на добавление страницы
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

//запрос на фильтрацию
$id_menu=intval($_REQUEST["id_menu"]);

// удалить страницу
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="update notes set deleted=1 where id=".intval($delete);
	$conn->query($sql);
	$tag=1;
}

// сохранить меню
$save_page=$_POST["save_page"];
if($save_page){
	$tag=1;
	$visible=($_POST["visibled"]) ? 1:0;
	$id_note=intval($_POST["id_note"]);
	$notes_name=$_POST['notes_name'];
	$txt_1=$_POST['txt_1'];
	$txt_2=$_POST['txt_2'];
	$txt_3=$_POST['txt_3'];
	$begin_date=save_date($_POST['begin_date']);
	$end_date=save_date($_POST['end_date']);
	$color=$_POST['color'];

	$set="set visibled=$visible, notes_name='$notes_name', 
          txt_1='$txt_1', txt_2='$txt_2', txt_3='$txt_3', begin_date='$begin_date', end_date='$end_date', color_text='$color'";
	$sql=($id_note) ? "update notes ".$set." where id=$id_note" : "insert into notes ".$set;
	$conn->query($sql);
	$page=1;
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["notes"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
if($tag==1){ ?>
   <div class="col" style="padding:10px;">
   <a href="?id_menu=<? echo $id_menu;?>&do=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
   </div> 
 
<table class="table table-bordered table-sm table-striped ">
<thead class="thead-dark">
<tr>
<th scope="col" style="width:80px;text-align:center;">ID</th>
<th scope="col"><? echo $kw["name"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["begin_date"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["end_date"];?></th>
<th scope="col" style="width:160px;text-align:center;"><? echo $kw["actions"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["visible"];?></th>
</tr>
</thead>
<tbody>
<?

//устанавлиаем страницу
$p=($page-1)*$max_view;
$sql="select id,notes_name,begin_date,visibled,end_date from notes where deleted=0 order by begin_date desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row["id"];
	$notes_name=$row["notes_name"];
	$bdate=$row["begin_date"];$bdate=load_date($bdate,'-');
	$edate=$row["end_date"];$edate=load_date($edate,'-');
	$check_visible=($row["visibled"]) ? "checked" : "";
	echo '<tr>';
	echo '<td class="align-middle text-center">';
		echo $id;
	echo '</td>';
	echo '<td  class="align-middle">';
		echo $notes_name;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $bdate;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $edate;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?page='.$page.'&id_note='.$id.'" >';
		echo '<i class="far fa-edit"></i> ';
		echo $kw["edit"].'</a>';
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo ($row["visibled"]) ? '<i class="fas fa-eye"></i>':'<i class="fas fa-eye-slash"></i>';
	echo '</td>';
	echo '</tr>';
}
?>
</tbody>
</table>
<?
	//нумерация страниц
	$url1="/login/notes/?";
	$tables="notes";
	$where="where deleted=0 ";
	$data=getrec($tables,"count(*)",$where);
	$maxrec=intval($data[0]);
	echo ' <div style="padding:7px 20px;">'.$kw["all_rec"].': <b>'.$maxrec.'</b></div>';
	$max_page=$maxrec/$max_view+1;
	if($max_page>2){ 
		echo navLinks($maxrec,$page,$url1);
	}
} 
//конец условий tag=1

//процедура редактирование меню
if($tag==2){
	$notes_name='';
	$txt_1='';
	$txt_2='';
	$txt_3='';
	$begin_date=date("d-m-Y");
	$end_date=date("d-m-Y");
	$visibled='';
	if($id_note>0){
		$data=getrec('notes','notes_name,txt_1,txt_2,txt_3,begin_date,visibled,end_date,color_text,font_size',"where id=$id_note");
		$notes_name=$data["notes_name"];
		$txt_1=$data["txt_1"];
		$txt_2=$data["txt_2"];
		$txt_3=$data["txt_3"];
		$begin_date=load_date($data["begin_date"],'-');
		$end_date=load_date($data["end_date"],'-');
		$visibled=( intval($data["visibled"]) ) ? 'checked' : '';
		$color=$data['color_text'];
		$font_size=$data['font_size'];
	}
	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_note" value="'.$id_note.'">';
	
	echo '<div class="form-group row" >';
		echo '<label for="begin_date" class="col-sm-2 col-form-label text_16 text-right">'.$kw["begin_date"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="text" name="begin_date" id="begin_date" class="form-control" value="'.$begin_date.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row" >';
		echo '<label for="end_date" class="col-sm-2 col-form-label text_16 text-right">'.$kw["end_date"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="text" name="end_date" id="end_date" class="form-control" value="'.$end_date.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row" >';
		echo '<label for="notes_name" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name_page"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="notes_name" id="notes_name" class="form-control" value="'.$notes_name.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row ">';
		echo '<label for="gridCheck1" class="col-sm-2 col-form-label text_16 text-right">'.$kw['visible'].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="visibled" '.$visibled.' id="gridCheck1">';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row ">';
		echo '<label for="gridCheck1" class="col-sm-2 col-form-label text_16 text-right">'.$kw['color_text'].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input type="color" value="'.$color.'" name="color">';
		echo '</div>';
	echo '</div>';


echo '
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">'.$kw['ru'].'</a></li>
    <li><a href="#tabs-2">'.$kw['kz'].'</a></li>
    <li><a href="#tabs-3">'.$kw['en'].'</a></li>
  </ul>
  <div id="tabs-1">
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_1" name="txt_1" rows="5">'.$txt_1.'</textarea>
  </div>
  <div id="tabs-2">
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_2" name="txt_2" rows="5">'.$txt_2.'</textarea>
  </div>
  <div id="tabs-3">
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_3" name="txt_3" rows="5">'.$txt_3.'</textarea>
  </div>
</div>
';

	echo '<br><div class="form-group row">';
		echo '<div class="col-sm-10">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_page" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/login/notes/?id_menu='.$id_menu.'&page='.$page.'" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			if($id_note){
				echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">';
				echo '<i class="fas fa-trash-alt"></i> ';
				echo $kw["delete"];
				echo '</button>';
			}
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
	//вызов окно подверждений
	if($id_note){
		echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/notes/?delete='.$id_note);
	}
}
?>
</div>
</div>
