<?

$tit=array();
$txt=array();
$annotation=array();
$i=0;
$data=getrec("menu","id","where module_name='video'");
$id_menu=intval($data['id']);

$sql="select title_1,txt_1,annotation from pages where deleted=0 and visibled=1 and id_menu=".$id_menu." order by public_date desc";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$i++;
	$tit[$i]=$row['title_1'];
	$txt[$i]=$row['txt_1'];
	$annotation[$i]=$row['annotation'];
}
?>
<div style="height: 40px;"></div>
<div class="container">
	<div class="row">
		<div class="col">
			<span class="div-title"><? echo $kw['video'];?></span>
		</div>
	</div>
</div>
<div class="container">
	<? 
	foreach ($tit as $key => $value) {
		preg_match('/(<iframe[^>]+>)/i', $txt[$key], $matches);
		preg_match_all( '@src="([^"]+)"@' , $matches[0], $img1 ); 
		$url = array_pop($img1);
	?>
	<div class="row">
		<div class="col-auto">
			<div class="slaid_video">
				<iframe frameborder="0" src="<? echo $url[0]; ?>" width="560" height="315" class="video"></iframe>
			</div>
		</div>
		<div class="col">
			<div class="slaid_text">
				<? echo $annotation[$key];?>
			</div>
		</div>
	</div>
	<div class="row"><div style="height:30px;"></div></div>
<? } ?>
</div>

