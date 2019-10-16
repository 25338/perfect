<a id="catalog"></a>
<div class="top-padding"></div>
<div >
	<div class="div-catalog">
		<div class="div-title"><? echo $kw['catalog'];?></div>
		<div class="owl-carousel owl-theme two">
<?
		$data=getrec("menu","id","where module_name='catalog'");$id_name=intval($data[0]);
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
			<div class="catalog-item">
				<div class="divcatalog-img">
		        	<img src="<? echo $img;?>" alt="" class="catalog-img" style="cursor: pointer;" onclick="details(<? echo $id;?>);" >
		        </div>
		        <div class="catalog-tit">
		        	<? echo $title;?>
		        	<? echo $txt_1;?>
		        </div> 
		        <? /*<div class="catalog-desc">
		        	<? echo $title;?>
		        	<? echo $txt_1;?>
		        </div>
		        */
		        ?>
			</div>
			<?
		}
?>
		</div>
	</div>
</div>

<?
echo dialog($kw['catalog'],'<div class="data"></div>','','data');
?>
<script>
$(document).ready(function(){
	var owl = $('.two');
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
function details(id){
    $.ajax({
		url: "/catalog_detail.php", // Куда отправляем данные (обработчик)
		type: "post",
		data: {
			"rec": id,
		},
		success: function(data) {		
			$(".data").html(data); // Выводим результат
		}			
	});
	$('#data').modal('show');
}
</script>
