<?
$main_page='/ru/';
?>
<div>
	<div class="logo shadow"><div class="row align-items-center">
		<div class="col-auto logo_perfect">
			<a href="<? echo $main_page;?>">
				<img src="/img/site/logo_perfect.png" alt="Perfect Radiator">
			</a>
		</div>
		<div class="menu_perfect">
			<nav class="navbar navbar-expand-lg navbar-dark navmenu">
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			    <? /* <a class="navbar-brand menu_site"><? // echo $kw["menu"];?></a> */ ?>
			  </button>
			  
			  <div class="collapse navbar-collapse"  id="navbarToggler"><div style="margin: auto;">
			    <ul class="navbar-nav mr-auto mt-2 mt-lg-0" >

			<?
			$sql="select id,name_1,name_2,name_3,module_name,url,target from menu where parent_id=0 and visibled=1 order by position";
			$res=$conn->query($sql);
			while($row=$res->fetch_array()){
				$id=intval($row['id']);
				$menu_name=$row[$lang];
				$kod=$row['module_name'];
				$url=$row['url'];
				$target=intval($row['target']);
				
				//создать УРЛ для меню
				$lnk=$kod.'/'; //($kod) ? $kod.'/' : 'page/'.$id.'/';
				$lnk=($url) ? $url.'/' : $lnk;
				$url_lnk='/'.$uri[1].'/'.$lnk;

				//если УРЛ начинается с http 
				if(substr($url,0,4)=="http"){$url_lnk=$url;}
				
				//открыть в новом окне если target=1
				$open_new=($target) ? 'target="_blank"': '';

				//если есть подменю то убираем ссылку 
				$data=getrec("menu","count(*)","where parent_id=$id and visibled=1");
				$count_child=intval($data[0]);
				$count_child=0;

				$url_lnk="#".$kod;
			    $a='<li class="nav-item a_li">';
			    $a.='<a class="nav-link a_menu" href="'.$url_lnk.'" '.$open_new.' >';
				if($count_child>0){
					$a='<li class="nav-item dropdown a_li">';
					$a.='<a class="nav-link a_menu dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
				}
				
			    echo $a;
			    echo $menu_name;
			    echo '</a>';
			    if($count_child>0){  
			      	echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
			      	
			   	    $sql_2="select id,name_1,name_2,name_3,module_name,url,target from menu where parent_id=$id and visibled=1 order by position";
				    $res2=$conn->query($sql_2);
				    while($row2=$res2->fetch_array()) {
						$id=intval($row2['id']);
						$menu_name=$row2[$lang];
						$kod=$row2['module_name'];
						$url=$row2['url'];
						$target=intval($row2['target']);
						
						//создать УРЛ для меню
						$lnk=$kod.'/'; //($kod) ? $kod.'/' : 'page/'.$id.'/';
						$lnk=($url) ? $url.'/' : $lnk;
						$url_lnk='/'.$uri[1].'/'.$lnk;
						
						//если УРЛ начинается с http 
						if(substr($url,0,4)=="http"){$url_lnk=$url;}
						
						//открыть в новом окне если target=1
						$open_new=($target) ? 'target="_blank"': '';

						echo '<a class="dropdown-item" href="'.$url_lnk.'" '.$open_new.'>';
						echo $menu_name;
						echo '</a>';
			        }
			        
			        echo '</div>';
			    }   
			    echo '</li>';
			}
			?>
			    </ul>
			  </div></div>
			</nav>
		</div>
	</div></div>
</div>
<script>
	$(document).ready(function(){
	    $(".a_li").on("click","a", function (event) {
	        event.preventDefault();
	        var id  = $(this).attr('href'),
	            position = $(id).position();
	        $('body,html').animate({scrollTop: position.top}, 1000);
	    });
	});
</script>