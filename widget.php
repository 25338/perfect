<nav class="widget">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active widget_nav" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><? echo $kw['kurs_informer'];?></a>
    <a class="nav-item nav-link widget_nav" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><? echo $kw['gismeteo'];?></a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent" style="width: 240px;">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><? include "kurs_informer.php";?></div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><? include "pogoda.php"; ?></div>
</div>
