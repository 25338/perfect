<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//функция построение деревом меню
function ShowTree($ParentID, $lvl) { 
global $conn;
global $lvl;
global $kw;
$lvl++; 

$sSQL="SELECT id,name_1,parent_id,visibled,position FROM menu WHERE parent_id=".$ParentID." ORDER BY position";
$result=$conn->query($sSQL);
if ($result) {
	while ( $row = $result->fetch_array() ) {
		$ID1 = $row["id"];
		$position=$row["position"];
		echo '<tr>';
		echo '<td width="20" class="align-middle text-center">';
			echo $ID1;
		echo '</td>';
		echo '<td class="align-middle">';
			echo str_repeat('&#183;&#183;&#183;&#183;',($lvl-1)).' ';
			echo $row["name_1"];
		echo '</td>';
		echo '<td  class="align-middle text-center">';
			echo ($row["parent_id"]) ? $row["parent_id"].'-': '';
			echo $position;
		echo '</td>';
		echo '<td class="align-middle text-center">';
			echo '<a href="?id_menu='.$ID1.'" class="btn btn-success btn-sm">';
			echo '<i class="far fa-edit"></i> ';
			echo $kw["edit"].'</a> ';
		echo '</td>';
		echo '<td class="align-middle text-center">';
			echo ($row["visibled"]) ? '<i class="fas fa-eye"></i>':'<i class="fas fa-eye-slash"></i>';
		echo '</td>';
		echo '</tr>';
		ShowTree($ID1, $lvl);
		$lvl--;
	}
  }
}

$tag=1;

$id_menu=intval($_REQUEST["id_menu"]);
//если выбран меню то меняем на tag=2 редактирование
if($id_menu>0){ $tag=2;}

//запрос на добавление меню
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

// удалить меню
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="delete from menu where id=$delete";
	$conn->query($sql);
	$tag=1;
	header("location: /login/".$uri[2].'/');
}

// сохранить меню
$save_menu=$_POST["save_menu"];
if($save_menu){
	$tag=1;
	$name_1=strip_tags($_POST["name_1"]);
	$name_2=strip_tags($_POST["name_2"]);
	$name_3=strip_tags($_POST["name_3"]);
	$parent_id=intval($_POST["parent_id"]);
	$url=$_POST['url'];
	$module_name=$_POST["module_name"];
	$visible=($_POST["visibled"]) ? 1:0;
	$target=($_POST["target"]) ? 1:0;
	$id_menu=intval($_POST["id_menu"]);
	$position=intval($_POST["position"]);
	//если не указан позиция то получаем последнюю 
	if(!$position){
		$data=getrec("menu","max(position)","where parent_id=$parent_id");
		$position=intval($data[0])+1;
	}
	//если не указан модуль
	$module_name=(!$module_name) ? substr(strtolower(translit($name_1)),0,50) : $module_name;

	$set="set module_name='$module_name', name_1='$name_1',name_2='$name_2',name_3='$name_3',parent_id=$parent_id,visibled=$visible, position=$position, url='$url', target=$target ";
	$sql=($id_menu) ? "update menu ".$set." where id=$id_menu" : "insert into menu ".$set;
	$res=$conn->query($sql);
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["menu_sites"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
//список меню
if($tag==1){ ?>
 <div class="col" style="padding:10px;">
   <a href="?do=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
 </div>
 
<table class="table table-sm table-bordered table-striped ">
<thead class="thead-dark ">
<tr>
<th scope="col" class="text-center" style="width:80px;">ID</th>
<th scope="col"><? echo $kw["name"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo "ID-".$kw["pos"];?></th>
<th scope="col" class="text-center" style="width:160px;"><? echo $kw["actions"];?></th>
<th scope="col" class="text-center" style="width:100px;"><? echo $kw["visible"];?></th>
</tr>
</thead>
<tbody class="table-striped">
<? ShowTree(0,0,0); ?>
</tbody>
</table>
<?
} 
//конец условий tag=1

//процедура редактирование меню
if($tag==2){
	$position=0;
	$module_name='';
	$parent_id=0;
	$visibled='';
	$target='';
	$name_1='';$name_2='';$name_3='';
	if($id_menu>0){
		$data=getrec("menu","name_1,name_2,name_3,parent_id,module_name,visibled,position,url,target","where id=$id_menu");
		$name_1=$data["name_1"];
		$name_2=$data["name_2"];
		$name_3=$data["name_3"];
		$parent_id=intval($data["parent_id"]);
		$position=intval($data["position"]);
		$module_name=$data["module_name"];
		$visibled=( intval($data["visibled"]) ) ? 'checked' : '';
		$target=( intval($data["target"]) ) ? 'checked' : '';
		$url=$data['url'];
	}
	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_menu" value="'.$id_menu.'">';

/*	
	echo '<div class="form-group row" >';
		echo '<label for="parent_id" class="col-sm-3 col-form-label text_16 text-right">'.$kw["parent_menu"].':</label>';
		echo '<div class="col">';
			echo '<select name="parent_id" id="parent_id" class="form-control form-control-sm">';
			echo '<option value="0"></option>';
			$pos_select=$parent_id; $id_menu2=$id_menu;
			ShowTreeOption(0,0);
			echo '</select>';
		echo '</div>';
	echo '</div>';
*/

	echo '<div class="form-group row">';
		echo '<label for="kod" class="col-sm-3 col-form-label text_16 text-right">'.$kw["symbol_kod"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="kod" disabled class="form-control form-control-sm"  value="'.$module_name.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="name_1" class="col-sm-3 col-form-label text_16 text-right">'.$kw["name_ru"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_1" class="form-control form-control-sm" name="name_1"  value="'.$name_1.'" required>';
		echo '</div>';
	echo '</div>';
/*
	echo '<div class="form-group row">';
		echo '<label for="name_2" class="col-sm-3 col-form-label text_16 text-right">'.$kw["name_kz"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_2" class="form-control form-control-sm" name="name_2"  value="'.$name_2.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="name_3" class="col-sm-3 col-form-label text_16 text-right">'.$kw["name_en"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_3" class="form-control form-control-sm" name="name_3"  value="'.$name_3.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="url" class="col-sm-3 col-form-label text_16 text-right">'.$kw["url"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="url" class="form-control form-control-sm" name="url"  value="'.$url.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="gridCheck2" class="col-sm-3 col-form-label text_16 text-right">'.$kw["target"].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="target" '.$target.' id="gridCheck2">';
		echo '</div>';
	echo '</div>';
*/
	echo '<div class="form-group row">';
		echo '<label for="module_name" class="col-sm-3 col-form-label text_16 text-right">'.$kw["module"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<select name="module_name" id="module_name" class="form-control form-control-sm">';
			echo '<option value="0"></option>';
			$sel=$module_name;
			ModuleMenu($sel);
			echo '</select>';
		echo '</div>';
	echo '</div>';

	if($id_menu){
	  echo '<div class="form-group row">';
		echo '<label for="position" class="col-sm-3 col-form-label text_16 text-right">'.$kw["position"].':</label>';
		echo '<div class="col-sm-1">';
			echo '<select name="position" id="position" class="form-control form-control-sm">';
			echo '<option value="0"></option>';
			//создаем массив позиции 
			$data=getrec("menu","count(*)","where parent_id=$parent_id");
			$max_pos=intval($data[0]);
			for($i=1;$i<=$max_pos;$i++){
				$sel=($i==$position) ? "selected" : "";
				echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
			}
			echo '</select>';
		echo '</div>';
	  echo '</div>';
	}

	echo '<div class="form-group row">';
		echo '<label for="gridCheck1" class="col-sm-3 col-form-label text_16 text-right">'.$kw["visible"].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="visibled" '.$visibled.' id="gridCheck1">';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label class="col-sm-3"></label>';
		echo '<div class="col">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_menu" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/login/menu/" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			// есть ли у меню дочерные элементы, если нет то показываем кнопку удалить
			$data=getrec("menu","count(*)","where parent_id=$id_menu");
			if(intval($data[0])==0){
				echo '<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete">';
				echo '<i class="fas fa-trash-alt"></i> ';
				echo $kw["delete"];
				echo '</button>';
			}
		echo '</div>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
	//вызов окно подверждений
	if(intval($data[0])==0){
		echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/menu/?delete='.$id_menu,"delete");

	}
}
?>
</div>
</div>