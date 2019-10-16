<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}
?>
<style type="text/css">
#image {
    width: 200px;
    height: 200px;
    overflow: hidden;
    cursor: pointer;
    background: #000;
    color: #fff;
	text-align:center;
}
#image img {
    visibility: hidden;
}
</style>
 
<script type="text/javascript">
function openKCFinder(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            div.innerHTML = '<div style="margin:5px">Loading...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img" src="' + url + '" />';
				$('#featured_image').val(url);
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    img.style.width = f_w + "px";
                    img.style.height = f_h + "px";
                } else {
                    f_w = o_w;
                    f_h = o_h;
                }
                img.style.marginLeft = 0; //parseInt((div.offsetWidth - f_w) / 2) + 'px';
                img.style.marginTop = 0; //parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.visibility = "visible";
            }
        }
    };
    window.open('/kcfinder/browse.php?type=images',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}
</script>
<?
$text2='<div style="margin:5px">'.$kw["select_foto"].'</div>';
$text=($foto) ? '<img id="img" src="'.$foto.'" height="200" style="visibility:visible;">' : $text2;
?>
<div id="image" onclick="openKCFinder(this)"><? echo $text;?></div>
<a href="#" id="clear_foto" class="btn btn-link btn-sm"><? echo $kw["clear"];?></a>
<input type="hidden" id="featured_image" value="<? echo $foto?> " readonly name="foto" />

<script> 
	$("#clear_foto").click(function(){
		$('#image').html('<? echo $text2;?>');
		$('#featured_image').val("");
	});
</script>
