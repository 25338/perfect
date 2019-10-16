<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$s='';
$tag=1;
$url_news="/".$uri[1]."/news/";
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

$id_news=intval($uri[3]);
if($id_news>0) {
	$tag=2;
	$s='<a class="archive_news" href="'.$url_news.'">'.$kw["archive_news"].'</a>';
}
?>
<div class="container">
	<div class="row">
		<div class="col">
			<span class="news_tit"><? echo $kw["news"].' '.$s;?></span>
		</div>
	</div>
</div>

<? if($tag==1) { ?>
<div class="container" >
 <? 
    $i=0;
    $data=getrec("menu","id","where module_name='news'");$id_menu=intval($data[0]);
    $p=($page-1)*$max_view;
	$sql="select id,title_1,title_2,title_3,public_date from pages where id_menu=".$id_menu." and visibled=1 order by public_date desc, id desc limit $p,$max_view";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		$i++;
		$tit=trim($row[$lang]);
		$public_date=$row['public_date'];
		$d=substr($public_date,6,2);$m=substr($public_date,4,2);$y=substr($public_date,0,4);
		$date=$kw["m".$m].' '.$d.', '.$y;
		$url_new_id="/".$uri[1]."/news/".$row["id"].'/';
		if($i==1) { echo '<div class="row ">'; }
		?>
        <div class="col-lg-4 mypadding_top">
            <div class="minnews_date"><? echo $date;?></div>
            <div class="minnews_tit"><? echo $tit;?></div>
            <div style="border-bottom: 1px solid #eee;"><a href="<? echo $url_new_id;?>" class="a_details"><? echo $kw["details"];?></a></div>
        </div>
        <? if($i==3) { echo '</div>'; $i=0; }
    } 
    if($i<3 && $i>0) { echo '</div>'; $i=0; }

	//нумерация страниц
	$url1="/".$uri[1]."/news/?";
	$tables="pages";
	$where="where id_menu=".$id_menu." and visibled=1 ";
	$data=getrec($tables,"count(*)",$where);
	$maxrec=intval($data[0]);
	$max_page=$maxrec/$max_view+1;
	if($max_page>2){ 
		echo navLinks($maxrec,$page,$url1);
	}

    ?>
</div>
<? 
} 
//конец tag=1


//tag=2
if($tag==2) {
	$data=getrec("pages","id,txt_1,txt_2,txt_3,public_date","where id=".$id_news);
	$txt=$data[$lang];
	$public_date=$data['public_date'];
	$d=substr($public_date,6,2);$m=substr($public_date,4,2);$y=substr($public_date,0,4);
	$date=$kw["m".$m].' '.$d.', '.$y;
	echo '<div class="container">';
	echo '<div class="row mypadding">';
	echo '<div class="col">';
	echo '<div class="minnews_date">'.$date.'</div>';
	echo '<div class="div_maxnews">'.$txt.'</div>';
	echo '</div>';
	echo '</div>';
	include "social.php";
	echo '</div>';

	$povtor=1;
	include "minnews.php";
	echo '<div class="container" >';
	echo '<div class="row">';
	echo '<div class="col"><div class="news_tit">'.$kw["other_news"].'</div>';
	minnews_body();
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
?>
<div class="mypadding"></div>