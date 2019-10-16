<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;
$url_otziv="/".$uri[1]."/testimonials/";
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

?>

<div class="container">
	<div class="row">
		<div class="col">
			<span class="news_tit"><? echo $kw["testimonials"];?></span>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>

<div class="container">
<div class="row"><div class="col">

<div class="container" >
<? 
$p=($page-1)*$max_view;
$sql="select id,txt,fio,date_create from otziv where visibled=1 order by date_create desc, id desc limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$public_date=$row['date_create'];
	$d=substr($public_date,6,2);$m=substr($public_date,4,2);$y=substr($public_date,0,4);
	$date=$kw["m".$m].' '.$d.', '.$y;
	$txt=$row['txt'];
	$fio=$row['fio'];
?>
	<div class="row">
        <div class="col-lg mypadding_top">
            <div class="testimonial_date"><? echo $date;?></div>
            <div class="testimonial_fio"><? echo $fio;?></div>
            <div class="testimonial_text"><? echo $txt;?></div>
        </div>
    </div>
<?
} 
echo '<div class="mypadding"></div>';

//нумерация страниц
$url1="/".$uri[1]."/testimonials/?";
$tables="otziv";
$where="where visibled=1 ";
$data=getrec($tables,"count(*)",$where);
$maxrec=intval($data[0]);
$max_page=$maxrec/$max_view+1;
if($max_page>2){ 
	echo navLinks($maxrec,$page,$url1);
}
?>
</div>
</div>
<div class="col-md-3">
	<? include "right.php"; ?>
</div>

</div>
</div>