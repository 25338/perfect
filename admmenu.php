<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//подключаем шапку страницы сайта
include_once "admhead.php";

//массив функции админ панели
$menus=array(
	'menu'  =>array($kw['menu_sites'],  'adm_menu.php','1','fas fa-sitemap'),
	'pages' =>array($kw['pages'], 'adm_pages.php','1','fas fa-file-alt'),
	//'notes' =>array($kw['notes'], 'adm_notes.php','1','fas fa-bell'),
	'slider'=>array($kw['slider'],'adm_gallery.php','1','far fa-images'),
	//'client'=>array($kw['client'],'adm_gallery.php','1','far fa-image'),
	//'banner_r'=>array($kw['banner_r'],'adm_gallery.php','1','far fa-image'),
	//'fotoalbum'=>array($kw['fotoalbum'],'adm_gallery.php','1','fas fa-images'),
	//'bank'=>array($kw['bank'],'adm_bank.php','1','fas fa-university'),
	//'appeal'=>array($kw['appeals'],'adm_appeal.php','1','fas fa-envelope-open-text'),
	//'priem'=>array($kw['calendar'],'adm_priem.php','1','far fa-clock'),
	'feedback'=>array($kw['feedback'],'adm_otziv.php','1','fas fa-thumbs-up'),
	'profile'=>array($kw['profile'],'adm_profile.php','0',''),
	'setting'=>array($kw['setting'],'adm_conf.php','1','fas fa-tools'),
	'smtp'=>array($kw['set_mail'],'adm_smtp.php','1','fas fa-at'),
	//'phpcode'=>array($kw['phpcode'],'adm_phpcode.php','1','fas fa-file-code'),
);

?>
<style type="text/css" media="print">
	.noprint{display: none;}
</style>

<div class="row fixed-top noprint" style="background-color:#000;height:40px;line-height:40px;">
	<div class="col-3 " >
		<div style="padding-left:20px;height:40px;white-space:nowrap;overflow:hidden;">
		<a href="/" target="_blank"><img src="/img/browser.png" width="32" title="Open site" align="left" vspace="6"></a>
		<span style="color:#aaa;font-size:30px;padding-left:4px;">Admin Panel</span> 
		<span style="color:#007bff;font-size:13px;">MU</span>
		</div>
	</div>
	<div class="col" style="color:#999; ">
		<?
		//получаем текущую дату и время
		echo $kw["today"].': '.date("d-m-Y").' '.mb_strtolower($day_week[date("N")]).' '; 
		echo '<span class="clock">'.date("H:i:s").'</span> ';
		
		//получаем текущего пользователя
		$data=getrec("u","fio,user_group","where id=$admin_id");
		$fio=$data["fio"];$user_group=intval($data["user_group"]);
		?>
	</div>
	<div class="col-2 ">
		<nav class="profile">
			<ul style="text-align:right;padding-right:10px;height:45px;">
				<li>
				<img src="/img/user.png" height="25" style="-webkit-filter: invert(1);filter: invert(1);"> <? echo $fio;?>
				<ul>
					<li><a href="/login/profile/"><? echo $kw["profile"];?></a></li>
					<li><a href="/exit/" ><? echo $kw["exit"];?></a></li>
				</ul>
				</li>
			</ul>
		</nav>
	</div>
</div>
<div class="row" style="margin: 40px 0 0 0;height:92%;">
	<div class="col-3 noprint" style="background-color:#303D4C;padding-top:10px;overflow-y: auto;height:100%;">
		<?
		//строим меню из массива
		foreach($menus as $key=>$menu){
			if($menu[2]==1){
				$sel=($key==$uri[2]) ? "sel":"";
				echo '<a href="/login/'.$key.'/" style="text-decoration:none;">';
				echo '<li class="left_menu '.$sel.'"> ';
				echo '<i class="'.$menu[3].'" style="width:20px;"></i> ';
				echo $menu[0];
				echo '</li>';
				echo '</a>';
			}
		}
		?>
	</div>
	<div class="col" style="background-color:#E6E8E9;overflow-y: scroll;height:100%;">
	<?
	//проверяем существование файла, если есть подключаем
	$key=$uri[2];
	$sel_file=$menus[$key][1];
	if(file_exists($sel_file)){
		include $sel_file;
	}else{
		include "dashboard.php";
	}
	?>
	</div>
</div>
<script type="text/javascript" src="/js/i18n/datepicker-ru.js"></script>
<script>
setInterval(function(){

        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;
        hours = (hours < 10 ? "0" : "") + hours;

        // Compose the string for display
        var currentTimeString = hours + ":" + minutes + ":" + seconds;
        $(".clock").html(currentTimeString);

},500);

$( function() {
	$( "#begin_date" ).datepicker({	});
	$( "#end_date" ).datepicker({	});
	$( "#public_date" ).datepicker({	});
    $( "#public_date1" ).datepicker({
      changeMonth: true,
      changeYear: true,
	  dateFormat: 'dd-mm-yy',
	  closeText: 'Закрыть',
      prevText: '',
      currentText: 'Сегодня',
      monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                    'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
      monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                    'Июл','Авг','Сен','Окт','Ноя','Дек'],
      dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
      dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
      dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
      weekHeader: 'Не',
      firstDay: 1
    });
});
$( function() {
	$( "#tabs" ).tabs();
} );
</script>