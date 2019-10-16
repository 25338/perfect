<?

$facebook='<i class="fab fa-facebook fa-2x"></i>';
$instagram='<i class="fab fa-instagram fa-2x"></i>';
$skype='<i class="fab fa-skype fa-2x"></i>';
$twitter='<i class="fab fa-twitter-square fa-2x"></i>';

$facebook=($kw['facebook']) ? '<a target="_blank" href="'.$kw['facebook'].'" class="t-social">'.$facebook.'</a>' : $facebook;
$instagram=($kw['instagram']) ? '<a target="_blank" href="'.$kw['instagram'].'" class="t-social">'.$instagram.'</a>' : $instagram;
$skype=($kw['skype']) ? '<a target="_blank" href="'.$kw['skype'].'" class="t-social">'.$skype.'</a>' : $skype;
$twitter=($kw['twitter']) ? '<a target="_blank" href="'.$kw['twitter'].'" class="t-social">'.$twitter.'</a>' : $twitter;

$social ='<span class="left-padding right-padding">'.$facebook.'</span>';
$social.='<span class="left-padding right-padding">'.$instagram.'</span>';
$social.='<span class="left-padding right-padding">'.$skype.'</span>';
$social.='<span class="left-padding right-padding">'.$twitter.'</span>';

$address='<img src="/img/address.png"> &nbsp; '.$kw['address'];
$phone='<img src="/img/phone.png"> &nbsp; '.$kw['phone'];
?>
<div class="div-top bg-color">
	<div class="div-top-content">
		<div class="d-flex justify-content-between">
			<div class="p-2 t-white social">
				<? echo $social;?>
			</div>
			<div class="p-2 t-white">
				<? echo $address;?>
			</div>
			<div class="p-2 t-white">
				<? echo $phone;?>
			</div>
		</div>
	</div>
</div>
<div class="div-padding-top"></div>