<?
$content=getcontent("dealer");
$txt=$content['txt'];

preg_match('/(<img[^>]+>)/i', $txt, $matches);
preg_match_all( '@src="([^"]+)"@' , $matches[0], $img1 ); $src = array_pop($img1);
$img=$src[0];
$txt_1=str_replace($matches[0], "", $txt);

?>
<a id="dealer"></a>
<div class="top-padding"></div>
<div >
	<div class="div-dealer">
		<div class="div-title"><? echo $kw['fordealer'];?></div>
		<div class="row">
			<div class="col">
				<div class="about-txt"><? echo $txt_1;?></div>
			</div>
			<div class="col-auto">
				<img src="<? echo $img;?>" alt="dealer" class="dealer-img">
			</div>
		</div>
	</div>
</div>