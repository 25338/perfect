<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

?>
<div class="d-flex align-items-center" >
	<div class="flex-fill dostijenie">
		<table border="0" width="100%">
			<tr class="dostijenie_number">
				<? /* <td class="number" data-num="<? echo $kw['blog_1_number'];?>">0 class="spincrement"</td> 
				<td class="number" data-num="<? echo $kw['blog_2_number'];?>">0</td>
				*/?>
				<td class="spincrement number"><? echo $kw['blog_1_number'];?></td>
				<td class="spincrement number"><? echo $kw['blog_2_number'];?></td>
				<td class="spincrement number"><? echo $kw['blog_3_number'];?></td>
				<td class="spincrement number"><? echo $kw['blog_4_number'];?></td>
			</tr>
			<tr class="dostijenie_text">
				<td class="animate"><? echo $kw['blog_1_text'];?></td>
				<td class="animate"><? echo $kw['blog_2_text'];?></td>
				<td class="animate"><? echo $kw['blog_3_text'];?></td>
				<td class="animate"><? echo $kw['blog_4_text'];?></td>
			</tr>
		</table>
	</div>
</div>
<script src="/js/jquery.spincrement.js"></script>

<script type="text/javascript">
<? /*
var time=1, cc=1;
$(window).scroll(function(){
	var e_top = $('.number').offset().top;
	var w_top = $(window).scrollTop();
	if( e_top < w_top + 500 && cc <2) {
		$('.number').addClass('viz');
		$('.animate').addClass('animated bounceInLeft viz');
		$('.number').each(function(){
			var
			i=1,
			num=$(this).data('num'),
			step=100*time/num,
			that=$(this),
			int=setInterval(function(){
				if (i<=num) {
					that.html(i);
				}
				else {
					cc=cc+2;
					clearInterval(int);
				}
				i++;
			}, step);
		});
	}
});
*/ ?>
var time=1, cc=1;
$(window).scroll(function(){
	var e_top = $('.number').offset().top;
	var w_top = $(window).scrollTop();
	if( e_top < w_top + 500 && cc <2) {
		$('.number').addClass('viz');
		$('.animate').addClass('animated bounceInLeft viz');

		$(".spincrement").spincrement({
		    decimalPlaces: 0,
		    decimalPoint: ".",
		    thousandSeparator: " ",
		    duration: 5000
		});
		cc=cc+2;
	}
});

</script>
