<?
$tag=1;

$kod="gallery";
$data=getrec("menu","id,name_1,name_2,name_3","where module_name='".$kod."'");
$id_menu=intval($data[0]);$tit=$data[$lang];

//если выбрано альбом
$id_album=intval($uri[3]);
if($id_album>0){
	$tag=2;
}

$sql="select id,name_1,name_2,name_3 from gallery where parent_id=0 and gallery_type=3 order by public_date ";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$id=intval($row['id']);
	$txt=$row[$lang];
	$data=getrec('gallery','id,foto','where parent_id='.$id.' and visibled=1');
	if(intval($data['id'])>0){
		$foto=$data['foto'];
		$album[]=array($id,$txt,$foto);
	}
}

?>
<div class="container">
	<div class="row">
		<div class="col news_tit">
			<? echo $tit;?>
		</div>
	</div>
<?
if($tag==1){ ?>
<div class="row" >
  <div class="col" >
	 <div style="color:#555; padding: 15px;">
		<div class="row text-center">
		   <? 
		   foreach($album as $key=>$value){
			   $url='/'.$uri[1].'/gallery/'.$value[0].'/';
			   echo '<div class="col">';
			   echo '<a href="'.$url.'">';
			   echo '<div style="height:200px;overflow:hidden;">';
			   echo '<img src="'.$value[2].'" width="250" border="0" >';
			   echo '</div>';
			   echo $value[1];
			   echo '</a>';
			   echo '</div>';
		   }
		   ?>
		</div>
	 </div>
  </div> 
</div>
<?
}


if($tag==2){
	?>
<style>
.library .item_image {
	display: inline-block;
}
.library a {
	display: inline-block;
	width: 250px;
	overflow: hidden;
	height: 150px;
}
.image {
	max-width: 100%;
}
.library {
	text-align: center;
	padding: 20px;
}

</style>
<div class="library">
<?
	$sql="select id,name_1,name_2,name_3,foto from gallery where visibled=1 and parent_id=".$id_album." order by public_date desc";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		$id=$row['id'];
		$foto=$row['foto'];
		$txt=$row[$lang];
?>
        <a class="item_image" href="<? echo $foto;?>">
            <img src="<? echo $foto;?>" class="image" width="250" border="0" >
        </a>
<?  } ?>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".item_image").magnificPopup({
			type: 'image',
			gallery : {
				enabled: true,
			},
            zoom: {
                enabled: true,
                duration: 300
            }
		})
	})
</script>
<? } ?>
</div>
