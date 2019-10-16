<?

$tag=1;

//галерея или баннер
$url=$uri[2];
$tit_gallery=$kw[$url];
$a_gallery=array('slider'=>array(1,1), 'banner'=>array(2,1), 'fotoalbum'=>array(3,0), 'banner_r'=>array(4,1) );
$kod=$a_gallery[$url][0];
$view=$a_gallery[$url][1];
$parent_id=0;

//страница
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

$id_gallery=intval($_REQUEST["id_gallery"]);
//если выбран меню то меняем на tag=2 редактирование
if($id_gallery>0){ $tag=2;}

//запрос на добавление страницы
$do=$_REQUEST["do"];
if($do=="add"){$tag=2;}

$id_album=intval($_REQUEST['id_album']);
if($id_album>0){
	$parent_id=intval($id_album);
	$view=1;
	$data=getrec("gallery","gallery_name","where id=".$id_album);
	$parent_name=$data["gallery_name"];
}

// удалить страницу
$delete=$_REQUEST["delete"];
if($delete>0){
	$sql="delete from gallery where id=".intval($delete);
	$conn->query($sql);
	$tag=1;
}

// сохранить все это
$save_gallery=$_POST["save_gallery"];
if($save_gallery){
	$tag=1;
	$gallery_name=$_POST['gallery_name'];
	$name_1=$_POST['name_1'];
	$name_2=$_POST['name_2'];
	$name_3=$_POST['name_3'];
	$foto=$_POST['foto'];
	$public_date=save_date($_POST['public_date']);
	$visible=($_POST['visibled']) ? 1:0;
	//$url_1=$_POST['url_1'];
	$color_text=$_POST['color_text'];
	$parent_id=intval($_POST['parent_id']);
	$id_foto=intval($_POST['id_foto']);

    $files='';
    $uploadDirectory = "catalog/";
    $now=time();
    $afile=array(1);
    foreach ($afile as $key => $i) {
        $errors = '';
    	$myfile='file'.$i;
	    $fileName = $_FILES[$myfile]['name'];
	    $fileSize = $_FILES[$myfile]['size'];
	    $fileTmpName  = $_FILES[$myfile]['tmp_name'];
	    $fileType = $_FILES[$myfile]['type'];
	    $sss=pathinfo($fileName);
	    $ext=$sss["extension"];

        $fileName1=$now.'_'.$i.'.'.$ext; 
        $uploadPath = $uploadDirectory . $fileName1;
        
        if ($fileName) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            $files=$fileName1."@@".$fileName;
        }
	}

	$url_1=($files) ? ", url='".$files."' " : '';
	$set="set visibled=$visible, name_1='$name_1', name_2='$name_2', name_3='$name_3', public_date='$public_date',
	        gallery_name='$gallery_name', gallery_type=$kod, foto='$foto', parent_id=$parent_id, color_text='$color_text' ". $url_1;
	$sql=($id_gallery) ? "update gallery ".$set." where id=$id_gallery" : "insert into gallery ".$set;
	$conn->query($sql);
}

$s_url="/".$uri[1]."/".$uri[2]."/";
?>
<div style="padding:10px;">
<h3><i class="fas fa-bars"></i> <? echo $tit_gallery;?></h3>
<div class="row shadow" style="background-color:#fff;">

<?
if($tag==1){ ?>
   <div class="col" style="padding:10px;">
   <a href="?id_album=<? echo $parent_id;?>&do=add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <? echo ($parent_id) ? $kw["add_foto"] : $kw["add"];?></a>
   <? echo ($id_album) ? ' <a href="'.$s_url.'" style="padding-left:20px;"><i class="fas fa-arrow-left"></i> '.$parent_name.'</a>' : ''; ?>
   </div> 
 
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
//устанавлиаем страницу
$p=($page-1)*$max_view;
$sql="select id,gallery_name,public_date,visibled from gallery where parent_id=".$parent_id." and gallery_type=".$kod." order by public_date desc limit ".$p.",".$max_view;
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=$row["id"];
	$gallery_name=$row["gallery_name"];
	$date=$row["public_date"];$date=load_date($date,'-');
	$check_visible=($row["visibled"]) ? "checked" : "";
	echo '<tr>';
	echo '<td class="align-middle text-center">';
		echo $id;
	echo '</td>';
	echo '<td  class="align-middle">';
		$txt1=$gallery_name;
		$txt2='<a href="?id_album='.$id.'">'.$txt1.'</a>';
		echo ($view) ? $txt1 : $txt2;
	echo '</td>';
	echo '<td class="align-middle text-center">';
		echo $date;
	echo '</td>';
	echo '<td class="align-middle text-center" >';
		echo '<a class="btn btn-success btn-sm" href="?id_album='.$parent_id.'&id_gallery='.$id.'&page='.$page.'" >';
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
	$url1="/login/".$uri[2]."/?";
	$tables="gallery";
	$where="where parent_id=".$parent_id." and gallery_type=".$kod;
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
	$gallery_name='';
	$name_1='';
	$name_2='';
	$name_3='';
	$public_date=date("d-m-Y");
	$visibled='';
	$url_1='';
	$foto='';
	if($id_gallery>0){
		$data=getrec('gallery','gallery_name,name_1,name_2,name_3,public_date,visibled,foto,url,color_text',"where id=$id_gallery");
		$gallery_name=$data["gallery_name"];
		$name_1=$data["name_1"];
		$name_2=$data["name_2"];
		$name_3=$data["name_3"];
		$public_date=load_date($data["public_date"],'-');
		$visibled=( intval($data["visibled"]) ) ? 'checked' : '';
		$foto=$data["foto"];
		$url_1=$data["url"];
		$color_text=$data['color_text'];
	}
	echo '<div class="col" style="padding:10px;">';
	echo '<form method="POST" enctype="multipart/form-data">';
	echo '<input type="hidden" name="id_gallery" value="'.$id_gallery.'">';
	echo '<input type="hidden" name="parent_id" value="'.$parent_id.'">';
	
	echo '<div class="form-group row" >';
		echo '<label for="public_date" class="col-sm-2 col-form-label text_16 text-right">'.$kw["date"].':</label>';
		echo '<div class="col-sm-2">';
			echo '<input type="text" name="public_date" id="public_date" class="form-control" value="'.$public_date.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row" >';
		echo '<label for="gallery_name" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" name="gallery_name" id="gallery_name" class="form-control" value="'.$gallery_name.'" required>';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row ">';
		echo '<label for="gridCheck1" class="col-sm-2 col-form-label text_16 text-right">'.$kw['visible'].':</label>';
		echo '<div class="col-sm-1">';
			echo '<input class="form-control form-control-sm" type="checkbox" name="visibled" '.$visibled.' id="gridCheck1">';
		echo '</div>';
	echo '</div>';

	if($view){
	echo '<div class="form-group row ">';
		echo '<label for="image" class="col-sm-2 col-form-label text_16 text-right">'.$kw['foto'].':</label>';
		echo '<div class="col">';
			include "adm_foto.php";
		echo '</div>';
	echo '</div>';
	}

	echo '<div class="form-group row">';
		echo '<label for="name_1" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name_ru"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_1" class="form-control form-control-sm" name="name_1"  value="'.$name_1.'" >';
		echo '</div>';
	echo '</div>';
/*
	echo '<div class="form-group row">';
		echo '<label for="name_2" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name_kz"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_2" class="form-control form-control-sm" name="name_2"  value="'.$name_2.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="name_3" class="col-sm-2 col-form-label text_16 text-right">'.$kw["name_en"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="name_3" class="form-control form-control-sm" name="name_3"  value="'.$name_3.'" >';
		echo '</div>';
	echo '</div>';

	echo '<div class="form-group row">';
		echo '<label for="color_text" class="col-sm-2 col-form-label text_16 text-right">'.$kw["color_text"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="color" id="color_text" name="color_text"  value="'.$color_text.'" >';
		echo '</div>';
	echo '</div>';
*/
	if($view){
	echo '<div class="form-group row">';
		echo '<label for="file1" class="col-sm-2 col-form-label text_16 text-right">'.$kw["catalog"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="file" id="file1" class="form-control form-control-sm" name="file1"  value="'.$file1.'" >';
		echo '</div>';
	echo '</div>';
/*
	echo '<div class="form-group row">';
		echo '<label for="url_1" class="col-sm-2 col-form-label text_16 text-right">'.$kw["url"].':</label>';
		echo '<div class="col-sm-5">';
			echo '<input type="text" id="url_1" class="form-control form-control-sm" name="url_1"  value="'.$url_1.'" >';
		echo '</div>';
	echo '</div>';
*/
	}

	echo '<br><div class="form-group row">';
		echo '<div class="col-sm-10">';
			echo '<button type="submit" class="btn btn-primary btn-sm" name="save_gallery" value="'.$kw["save"].'"> ';
			echo '<i class="fas fa-save"></i> ';
			echo $kw["save"];
			echo '</button> ';
			echo '<a href="/login/'.$uri[2].'/?id_album='.$parent_id.'&page='.$page.'" class="btn btn-secondary  btn-sm" >';
			echo '<i class="fas fa-ban"></i> ';
			echo $kw["cancel"].'</a> ';
			if($id_gallery){
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
	if($id_gallery){
		echo ConfirmDialog($kw["attention"],$kw["confirm_delete"],'/login/'.$uri[2].'/?id_album='.$parent_id.'&delete='.$id_gallery,'delete');
	}
}

?>
</div>
</div>
