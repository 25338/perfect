<a id="client"></a>
<div style="height:40px;"></div>
<div >
	<div class="div-client">
		<div class="div-title"><? echo $kw['client'];?></div>
		<div class="owl-carousel owl-theme three">
<?
		$data=getrec("menu","id","where module_name='client'");$id_name=intval($data[0]);
		$sql="select id, page_name, title_1, txt_1 from pages where id_menu=".$id_name." and visibled=1 order by public_date desc, id desc limit 0,20";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$id=$row['id'];

			$title=$row['page_name'];
			$txt_1=$row['title_1'];
			$txt=$row['txt_1'];

			preg_match('/(<img[^>]+>)/i', $txt, $matches);
			preg_match_all( '@src="([^"]+)"@' , $matches[0], $img1 ); $src = array_pop($img1);
			$img=($src[0]) ? $src[0] : '/img/site/radiator.png';
			?>
			<div class="client-item">
				<div class="divclient-img">
		        	<img src="<? echo $img;?>" alt="" class="client-img">
		        </div>
			</div>
			<?
		}
?>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	var owl = $('.three');
	owl.owlCarousel({
		items:5,
		margin:15,
		loop:true,
		dots: true,
		nav: false,
		autoplay:true,
		autoplaySpeed:2000,
		autoplayTimeout:10000,
		autoplayHoverPause:true,
    	responsiveClass:true,
		responsive:{
			0: {
				items:1,
			},
			640: {
				items:2,
			},
			901: {
				items:5,
			}
        }
	});
});
</script>
