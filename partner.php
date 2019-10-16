<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

?>
<div class="d-flex align-items-center" >
	<div class="flex-fill"></div>
	<div class="flex-fill div_partner">
			<span class=news_tit><? echo $kw["partner"];?></span> 
			<div class="owl-carousel owl-theme three">
				<?
				$sql="select id,foto,url from gallery where gallery_type=2 and visibled=1 order by public_date desc, id desc";
				$res=$conn->query($sql);
				while($row=$res->fetch_array()){
					$foto=$row['foto'];
					$url=trim($row['url']); $url=(!$url) ? '' : 'href="'.$url.'"';
				?>
					<div>
						<a <? echo $url;?> target="_blank"><img src="<? echo $foto;?>" class="three_img"></a>
					</div>
				<? } ?>
			</div>
	</div>
	<div class="flex-fill"></div>
</div>

<script>
$(document).ready(function(){
	var owl = $('.three');
	owl.owlCarousel({
		items:7,
		loop:true,
		dots: true,
		nav: false,
		margin: 5,
		autoplay:true,
		autoplaySpeed:2000,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		responsive:{
        0:{
            items:3,
        },
        701:{
            items:5,
        },
        1000:{
            items:7,
        }
        }
	});
});
</script>