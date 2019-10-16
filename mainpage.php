<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

//подгружаем модуль слайдер
include "slaider.php";
//каталог
include "catalog.php";
//четыре блока
include "blog4.php";
//для диллерам 
include "dealer.php";
//О нас
include "about.php";
//видео
include "video.php";
//обратная связь
include "feedback.php";
//Наши клиенты
include "client.php";
?>

<!-- кнопка вверх -->
<a id="button"><i class="fas fa-angle-up"></i></a>
<script type="text/javascript">
	var btn = $('#button');
	$(window).scroll(function() {
	  if ($(window).scrollTop() > 300) {
	    btn.addClass('show');
	  } else {
	    btn.removeClass('show');
	  }
	});

	btn.on('click', function(e) {
	  e.preventDefault();
	  $('html, body').animate({scrollTop:0}, '300');
	});	
</script>
