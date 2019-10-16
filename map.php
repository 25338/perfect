<?
$data=getrec("iframe","phpcode","where kod='maps'");
echo $data['phpcode'];
/*
<a class="dg-widget-link" href="http://2gis.kz/almaty/firm/9429940001122568/center/76.947674,43.244058/zoom/16?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap">Посмотреть на карте Алматы</a>
<div class="dg-widget-link">
<a href="http://2gis.kz/almaty/center/76.947674,43.244058/zoom/16/routeTab/rsType/bus/to/76.947674,43.244058╎Банковский омбудсман?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Банковский омбудсман</a>
</div>
<script charset="utf-8" src="https://widgets.2gis.com/js/DGWidgetLoader.js"></script>
<script charset="utf-8">new DGWidgetLoader({"width":'100%',"height":'200px',"borderColor":"#a3a3a3","pos":{"lat":43.244058,"lon":76.947674,"zoom":16},"opt":{"city":"almaty"},"org":[{"id":"9429940001122568"}]});</script>
<noscript style="color:#c00;font-size:16px;font-weight:bold;">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>
*/
?>