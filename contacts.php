<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//если ссылка page или другие
$kod=strip_tags($uri[2]);
$data=getrec("menu","id, name_1, name_2, name_3, module_name, parent_id","where module_name='$kod'");
$id_menu=intval($data['id']);
$id_parent=intval($data['parent_id']);

//создаем дерево меню
$menu=array();
$menu[]=$data[$lang];
$url_menu[]=$data['module_name'];
while($id_parent>0){
	$data=getrec('menu','parent_id, name_1, name_2, name_3, module_name','where id='.$id_parent);
	$id_parent=intval($data[0]);
	$menu[]=$data[$lang];
	$url_menu[]=$data['module_name'];
}
$data=getrec('menu','parent_id,name_1,name_2,name_3,module_name','where module_name="main_page"');
$menu[]=$data[$lang];
$url_menu[]=$data['module_name'];

$s_menu='';
foreach ($menu as $key => $value) {
	if($value){
		$s='<a href="/'.$uri[1].'/'.$url_menu[$key].'/" class="a_menu_page">';
		$s.=$value;
		$s.='</a>';
		$s_menu=$s.$s_menu;
	}
}

?>
<div class="container"><div class="row"><div class="col">
<div style="padding:5px 0;border-bottom:1px solid #ddd;">
<? echo $s_menu; ?>
</div>
</div></div></div>

<div class="container mypadding_top">
	<div class="row">
		<div class="col">
			<? 
			$content=getcontent('contacts'); 
			echo $content['txt'];
			?>
		</div>
	</div>
	<div class="row">
		<div class="col text-center">
			<? include "map.php"; ?>
		</div>
	</div>
</div>