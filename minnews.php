<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$url_news="/".$uri[1]."/news/";

//условия для поворного вызова

function minnews_link(){
	global $kw;
	global $conn;
	global $uri;
	global $url_news;?>

<div style="padding-top: 20px;"></div>
<div class="d-flex align-items-center" >
	<div class="flex-fill"></div>
	<div class="flex-fill div_minnews">
			<span class=news_tit><? echo $kw["news"];?>
			<a class="archive_news" href="<? echo $url_news;?>"><? echo $kw["archive_news"];?></a>
			</span>
<? minnews_body(); ?>
	</div>
	<div class="flex-fill"></div>
</div>
<? }

function minnews_body(){
	global $kw;
	global $conn;
	global $uri;
	global $lang;
?>
<div class="owl-carousel owl-theme two">
<?
$data=getrec("menu","id","where module_name='news'");$id_name=intval($data[0]);
$sql="select id,title_1,title_2,title_3,public_date from pages where id_menu=".$id_name." and visibled=1 order by public_date desc, id desc limit 0,7";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$tit=trim($row[$lang]);
	$public_date=$row['public_date'];
	$d=substr($public_date,6,2);$m=substr($public_date,4,2);$y=substr($public_date,0,4);
	$date=$kw["m".$m].' '.$d.', '.$y;
	$url_new_id="/".$uri[1]."/news/".$row["id"].'/';
	?>
	<div>
        <div class="minnews_date"><? echo $date;?></div>
        <div class="minnews_tit"><? echo $tit;?></div>
        <div ><a href="<? echo $url_new_id;?>" class="a_details"><? echo $kw["details"];?></a></div>
	</div>
	<?
}
?>
</div>

<script>
$(document).ready(function(){
	var owl = $('.two');
	owl.owlCarousel({
		items:3,
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
				items:3,
			}
        }
	});
});
</script>
<?
}

if(!$povtor){
	minnews_link();
}
?>
