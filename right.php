<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

?>
<div class="text-center right_side">
	<? include "widget.php";?>
	<?
	$sql="select id,foto,url,name_1,name_2,name_3 from gallery where gallery_type=4 and visibled=1 order by public_date desc, id desc";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		$foto=$row['foto'];
		$txt=trim($row['name_'.$lang]);
		$url=trim($row['url']); $url=(!$url) ? '' : 'href="'.$url.'"';
		$txt=($txt) ? '<div class="right_txt">'.$txt.'</div>' : '';
	?>
		<div class="right_div_img">
			<? echo $txt;?>
			<a <? echo $url;?> target="_blank"><img src="<? echo $foto;?>" class="right_img"></a>
		</div>
	<? } ?>
</div>

