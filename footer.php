<?
$content=getcontent("contacts");
$txt=$content['txt'];

?>
<a id="contacts"></a>
<div style="height: 20px;"></div>
<div class="bg-color">
	<div class="div-contacts">
		<div class="contacts-txt">
			<? echo $txt;?>
		</div>
	</div>
</div>
<div class="div-footer">
	<div class="footer-txt">
		<? echo $kw['copyright'];?>
	</div>
</div>