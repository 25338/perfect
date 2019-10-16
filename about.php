<?
$content=getcontent("about");
$txt=$content['txt'];

preg_match('/(<img[^>]+>)/i', $txt, $matches);
preg_match_all( '@src="([^"]+)"@' , $matches[0], $img1 ); $src = array_pop($img1);
$img=$src[0];
$txt_1=str_replace($matches[0], "", $txt);

?>
<a id="about"></a>
<div style="height:50px;"></div>
<div class="bg-color">
	<div class="div-about">
		<div class="row">
			<div class="col-auto">
				<img src="<? echo $img;?>" alt="about" class="about-img" >
			</div>
			<div class="col">
				<div class="div-title"><? echo $kw['about'];?></div>
				<div class="about-txt"><? echo $txt_1;?></div>
			</div>
		</div>
	</div>
</div>