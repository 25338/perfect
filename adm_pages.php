<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;

//страница
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

$id_page=intval($_REQUEST["id_page"]);
//если выбран меню то меняем на tag=2 редактирование
if($id_page>0){ $tag=2;}

//запрос на добавление страницы
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

//запрос на фильтрацию
$id_menu=intval($_REQUEST["id_menu"]);

// удалить страницу
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="update pages set deleted=1 where id=".intval($delete);
	$conn->query($sql);
	$tag=1;
}

// сохранить меню
$save_page=$_POST["save_page"];
if($save_page){
	$tag=1;
	$visible=($_POST["visibled"]) ? 1:0;
	$id_page=intval($_POST["id_page"]);
	$page_name=$_POST['page_name'];
	$title_1=strip_tags($_POST['title_1']);
	$title_2=strip_tags($_POST['title_2']);
	$title_3=strip_tags($_POST['title_3']);
	$txt_1=$_POST['txt_1'];
	$txt_2=$_POST['txt_2'];
	$txt_3=$_POST['txt_3'];
	$descript=strip_tags($_POST['descript']);
	$keyw=strip_tags($_POST['keyw']);
	$annotation=strip_tags($_POST['annotation']);
	
	$id_menu=intval($_POST['id_menu']);
	$public_date=save_date($_POST['public_date']);

	$set="set visibled=$visible, page_name='$page_name', title_1='$title_1', title_2='$title_2', title_3='$title_3',
          txt_1='$txt_1', txt_2='$txt_2', txt_3='$txt_3', id_menu=$id_menu, public_date='$public_date', 
          descript='$descript', keywords='$keyw', annotation='$annotation' ";
	$sql=($id_page) ? "update pages ".$set." where id=$id_page" : "insert into pages ".$set;
	$conn->query($sql);
	$page=1;
}

?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $kw["pages"];?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
if($tag==1){ ?>
  <form>
   <div class="col" style="padding:10px;">
   <a href="?id_menu=<? echo $id_menu;?>&do=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <? echo $kw["add"];?></a>
   <span style="padding-left:20px;"></span>
   <? 
	//фильтрация страниц по модулю
    echo '<label for="menu_filter">';
	echo $kw["filter"].': ';
	echo '<select name="id_menu" id="menu_filter" class="form-control-sm" onchange="this.form.submit();" style="width:600px;">';
	echo '<option value="0"></option>';
	$pos_select=$id_menu;
	ShowTreeOption(0,0);
   ?>
   </select>
	</label>
   </div> 
   </form>
 
<table class="table table-bordered table-sm table-striped ">
<thead class="thead-dark">
<tr>
<th scope="col" style="width:80px;text-align:center;">ID</th>
<th scope="col"><? echo $kw["name"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["date"];?></th>
<th scope="col" style="width:160px;text-align:center;"><? echo $kw["actions"];?></th>
<th scope="col" style="width:100px;text-align:center;"><? echo $kw["visible"];?></th>
</tr>
</thead>
<tbody>
<?
//создаем фильтрацию
$where=($id_menu) ? ' and id_menu='.$id_menu : '';

//устанавлиаем страницу
$p=($page-1)*$max_view;
$sql="select id,page_name,public_date,visibled,id_menu from pages where deleted=0 $where order by public_date desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row["id"];
	$id_menu1=$row['id_menu'];
	$page_name=$row["page_name"];
	$date=$row["public_date"];$date=load_date($date,'-');
	$check_visible=($row["visibled"]) ? "checked" : "";
	echo '<tr>';
	echo '<td class="align-middle text-center">';
		echo $id;
	echo '</td>';
	echo '<td  class="align-middle">';
		echo $page_name;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $date;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?id_menu='.$id_menu1.'&page='.$page.'&id_page='.$id.'" >';
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
	$url1="/login/pages/?id_menu=".$id_menu.'&';
	$tables="pages";
	$where="where deleted=0 ".$where;
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
	$page_name='';
	$title_1='';
	$title_2='';
	$title_3='';
	$txt_1='';
	$txt_2='';
	$txt_3='';
	$public_date=date("d-m-Y");
	$visibled='';
	if($id_page>0){
		$data=getrec('pages','page_name,id_menu,title_1,title_2,title_3,txt_1,txt_2,txt_3,public_date,visibled,descript,keywords, annotation',"where id=$id_page");
		$page_name=$data["page_name"];
		$id_menu=intval($data["id_menu"]);
		$title_1=$data["title_1"];
		$title_2=$data["title_2"];
		$title_3=$data["title_3"];
		$txt_1=$data["txt_1"];
		$txt_2=$data["txt_2"];
		$txt_3=$data["txt_3"];
		$public_date=load_date($data["public_date"],'-');
		$visibled=( intval($data["visibled"]) ) ? 'checked' : '';
		$descript=$data['descript'];
		$keyw=$data['keywords'];
		$annotation=$data['annotation'];
	}
	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST">';
	echo '<input type="hidden" name="id_page" value="'.$id_page.'">';
	
	echo '<div class="form-group row" >';
		echo '<label for="public_date" class="col-sm-2 col-form-label text_16 text-right">'.$kw["date"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="text" name="public_date" id="public_date" class="form-control" value="'.$public_date.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row" >';
		echo '<label for="page_name" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name_page"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="page_name" id="page_name" class="form-control" value="'.$page_name.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row" >';
		echo '<label for="id_menu" class="col-sm-2 col-form-label text_16 text-right">'.$kw["menu_sites"].':</label>';
		echo '<div class="col">';
			echo '<select name="id_menu" id="id_menu" class="form-control form-control">';
			echo '<option value="0"></option>';
			$pos_select=intval($id_menu);
			ShowTreeOption(0,0);
			echo '</select>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row ">';
		echo '<label for="gridCheck1" class="col-sm-2 col-form-label text_16 text-right">'.$kw['visible'].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="visibled" '.$visibled.' id="gridCheck1">';
		echo '</div>';
	echo '</div>';

echo '
<script src="/ckeditor/ckeditor.js"></script>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">'.$kw['ru'].'</a></li>
    ';
/* 
echo '
    <li><a href="#tabs-2">'.$kw['kz'].'</a></li>
    <li><a href="#tabs-3">'.$kw['en'].'</a></li>
    ';
*/
echo '
    <li><a href="#tabs-4">'.$kw['seo'].'</a></li>
  </ul>
  <div id="tabs-1">
    <b>'.$kw['title'].':</b><input type="text" name="title_1" value="'.$title_1.'" class="form-control">
	<br>
	<b>'.$kw['annotation'].':</b>
	<textarea class="form-control" name="annotation" rows="5">'.$annotation.'</textarea>
	<br>
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_1" name="txt_1" rows="20">'.$txt_1.'</textarea>
	<script>CKEDITOR.replace( "editor_1" );</script>
  </div>';
  /*
  echo '
  <div id="tabs-2">
    <b>'.$kw['title'].':</b><input type="text" name="title_2" value="'.$title_2.'" class="form-control">
	<br>
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_2" name="txt_2" rows="20">'.$txt_2.'</textarea>
	<script>CKEDITOR.replace( "editor_2" );</script>
  </div>
  <div id="tabs-3">
	<b>'.$kw['title'].':</b><input type="text" name="title_3" value="'.$title_3.'" class="form-control">
	<br>
	<b>'.$kw['content'].':</b>
	<textarea class="form-control" id="editor_3" name="txt_3" rows="20">'.$txt_3.'</textarea>
	<script>CKEDITOR.replace( "editor_3" );</script>
  </div>
  ';
  */
  echo '
  <div id="tabs-4">
	<b>'.$kw['descript'].':</b>
	<textarea class="form-control" name="descript" rows="3">'.$descript.'</textarea>
	<br>
	<b>'.$kw['keyw'].':</b>
	<textarea class="form-control" name="keyw" rows="3">'.$keyw.'</textarea>
  </div>
</div>
';

	echo '<br><div class="form-group row">';
		echo '<div class="col-sm-10">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_page" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/login/pages/?id_menu='.$id_menu.'&page='.$page.'" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			if($id_page){
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
	if($id_page){
		echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/pages/?id_menu='.$id_menu.'&delete='.$id_page,'delete');
	}
}
?>
</div>
</div>
