<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

?>

<!-- слайдер -->
<div class="owl-carousel owl-theme one" style="height: 500px;">
<?
$sql="select id,name_1,name_2,name_3,foto,url,color_text from gallery where gallery_type=1 and visibled=1 order by public_date desc, id desc";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$txt=trim($row[$lang]);$txt=str_replace("\n","<br>",$txt);
	$foto=trim($row['foto']);
	$color_text=$row['color_text'];
	
	$url=$row['url']; $file1=explode("@@", $url);
	$price=($url) ? 'href="/catalog/'.$file1[0].'" download="'.$file1[1].'"' : '';

	$txt0=explode('.',$txt);
	$txt1='';
	foreach($txt0 as $k=>$val){
		$txt1.=($k) ? $val.'. ' : '';
	}
?>
	<div style="height:500px;">
        <div class="img_response" style="background-image: url('<? echo $foto;?>')" >
        	<? if($txt) { ?>
        		<div class="text_slaider">
        			<? echo $txt;?>
        			<div>
        				<? 
        				if($price) {
        				?>
        					<a <? echo $price;?> class="btn btn-primary btn-lg price"><? echo $kw['price'];?></a>
        				<?
        				}
        				?>
        			</div>
        		</div>
			<? } ?>
        </div>
	</div>
<?
}
?>
</div>


<script>
$(document).ready(function(){
	var owl = $('.one');
	owl.owlCarousel({
		items:1,
		loop:true,
		dots: false,
		nav: false,
		autoplay:true,
		autoplaySpeed:2000,
		autoplayTimeout:10000,
		autoplayHoverPause:true
	});
});
</script>