<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

/*
$but[1]="/".$uri[1].'/btn1/';
$but[2]="/".$uri[1].'/btn2/';
$but[3]="/".$uri[1].'/btn3/';
$but[4]="/".$uri[1].'/btn4/';
*/
$but=array();
$txt_but=array();
$i=0;
$data=getrec("menu","id","where module_name='blok'");$id_menu=intval($data['id']);
$res=$conn->query("select module_name,name_1,name_2,name_3 from menu where visibled=1 and parent_id=".$id_menu." order by position");
while($row=$res->fetch_array()){
	$i++;
	$but[$i]='/'.$uri[1].'/'.$row['module_name'].'/';
	$txt_but[$i]=$row[$lang];
}
?>
<div class="container-fluid">
	<div style="padding: 20px 0;text-align: center;">
		<div class="row">
			<div class="col col-lg">
				<a href="<? echo $but[1];?>" class="circle_text">
					<img src="/img/site/spor.png" alt="spor" height="103">
					<div class="circle_text"><? echo $txt_but[1];?></div>
				</a>
			</div>
			<div class="col col-lg">
				<a href="<? echo $but[2];?>" class="circle_text">
					<img src="/img/site/praktika.png" alt="praktika" height="103">
					<div class="circle_text"><? echo $txt_but[2];?></div>
				</a>
			</div>
			<div class="col col-lg">
				<a href="<? echo $but[3];?>" class="circle_text">
					<img src="/img/site/video.png" alt="team" height="103">
					<div class="circle_text"><? echo $txt_but[3];?></div>
				</a>
			</div>
			<div class="col col-lg">
				<a href="<? echo $but[4];?>" class="circle_text">
					<img src="/img/site/team.png" alt="help" height="103">
					<div class="circle_text"><? echo $txt_but[4];?></div>
				</a>
			</div>
		</div>
	</div>
</div>
