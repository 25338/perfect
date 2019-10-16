<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$url_appeal="/".$uri[1]."/appeal/";
$url_calendar="/".$uri[1]."/calendar/";
$url_otziv="/".$uri[1]."/review/";

?>
<div class="container-fluid div_request">
	<div class="row text-center">
		<div class="col" >
			<a class="a_request" href="<? echo $url_appeal;?>">
				<img class="img_invert" src="/img/appeal.png" alt="appeal" height="40"> <? echo $kw["appeal"];?></a> 
			<a class="a_request" href="<? echo $url_calendar;?>">
				<img class="img_invert" src="/img/calendar.png" alt="calendar" height="40"> <? echo $kw["calendar"];?></a>
			<a class="a_request" href="<? echo $url_otziv;?>">
				<img class="img_invert" src="/img/review.svg" alt="calendar" height="40"><? echo $kw["review"];?></a>
		</div>
	</div>
</div>
