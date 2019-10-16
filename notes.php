<?
$txt="";
$today=date("Ymd");
$sql="select id,txt_1,txt_2,txt_3,color_text,font_size from notes where deleted=0 and visibled=1 and end_date>='$today' and begin_date<='$today' order by begin_date desc";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$txt.='<font color="'.$row['color_text'].'">'.$row[$lang].'</font>';
	$txt.=' <div style="display:inline-block;width:50px;text-align:center;"> &sdot; &sdot; &sdot; </div>';
}

if($txt){ ?>
<div class="notes">
<marquee scrollamount="5" class="note"><? echo $txt;?></marquee>
</div>
<? } ?>
