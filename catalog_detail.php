<?
include "db.php";
include "function.php";

$rec=intval($_REQUEST['rec']);

$data=getrec("pages","page_name, title_1, annotation, txt_1","where id=".$rec);
$txt=$data['txt_1'];
$tit=$data['title_1'];
$page_name=$data['page_name'];
$annotation=$data['annotation']; $annotation=str_replace("\n", "<br>", $annotation);

preg_match('/(<img[^>]+>)/i', $txt, $matches);
preg_match_all( '@src="([^"]+)"@' , $matches[0], $img1 ); $src = array_pop($img1);
$img=($src[0]) ? $src[0] : '/img/site/radiator.png';

?>
<div class="row">
	<div class="col-auto">
		<img src="<? echo $img;?>" alt="" class="catalog-img">
	</div>
	<div class="col">
		<div class="catalog-tit"><? echo $page_name;?></div>
		<div class="catalog-desc"><? echo $tit;?></div>
		<hr>
		<div class="catalog-desc"><? echo $annotation;?></div>
	</div>
</div>