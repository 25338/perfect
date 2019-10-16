<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$content=getcontent("main_page");
?>
<div class="d-flex align-items-center" >
	<div class="div_slovo_min flex-fill"></div>
	<div class="div_slovo_max flex-fill">
		<div class="div_slovo_text">
			<? echo $content['txt'];?>
		</div>
	</div>
	<div class="div_slovo_min flex-fill"></div>
</div>
