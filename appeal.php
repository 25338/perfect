<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit;}

$tag=1;

$appeal_send=$_POST['appeal_send'];
if($appeal_send){
	$fam=strip_tags($_POST['fam']);
	$imy=strip_tags($_POST['imy']);
	$otc=strip_tags($_POST['otc']);
	$bank=intval($_POST['bank']);
	$txt=htmlspecialchars($_POST['sutraznoglasiya'],ENT_QUOTES);
	$appeal_phone=strip_tags($_POST['appeal_phone']);
	$appeal_email=strip_tags($_POST['appeal_email']);
	$appeal_address=strip_tags($_POST['appeal_address']);
	$appeal_iin=strip_tags($_POST['appeal_iin']);
	$date_create=date("YmdHis");

    $ss='';
    $files='';
    $uploadDirectory = "appeals/";
    $now=time();
    $j=0;
    $afile=array(2,4,7,9);
    //for($i=1;$i<=9;$i++){
    foreach ($afile as $key => $i) {
        $errors = '';
    	$myfile='file'.$i;
	    $fileName = $_FILES[$myfile]['name'];
	    $fileSize = $_FILES[$myfile]['size'];
	    $fileTmpName  = $_FILES[$myfile]['tmp_name'];
	    $fileType = $_FILES[$myfile]['type'];
	    $sss=pathinfo($fileName);
	    $ext=$sss["extension"];

        //if ($fileSize > 2000000) {
        //    $errors = $kw['error_big_file'];
        //}

        $fileName1=$now.'_'.$i.'.'.$ext; 
        $uploadPath = $uploadDirectory . $fileName1;
        
        if ($fileName) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
            	$j++;
            	$ss.='<div class="alert alert-warning">';
                $ss.= $j.'. <span class="alert-link">'.$fileName .'</span> - '. $kw["file_uloaded"];
                $ss.='</div>';
                $files.=", ".$myfile."='".$fileName1."@@".$fileName."'";
            } else {
            	$ss.='<div class="alert alert-danger">';
                $ss.=$kw['error_file'].' <span class="alert-link">'.$fileName.'</span>';
                $ss.='</div>';
            }
        }
	}

	$set=" set fam='$fam', imy='$imy', otc='$otc', txt='$txt', id_bank=$bank, phone='$appeal_phone', email='$appeal_email', address='$appeal_address', iin='$appeal_iin', date_create='$date_create' ".$files;
	$sql="insert into appeals ".$set;
	$conn->query($sql);
	$ss1='<div class="alert alert-primary alert-link">';
	$ss1.=$kw['appeal_success'];
	$ss1.='</div>';
	$ss=$ss1.$ss;
	$tag=2;
	//отправка уведомлений в почту
	$mess =$kw['appeal_text']."<br><br>";
	$mess.=$kw['client_name'].': '.$fam.' '.$imy.' '.$otc.' ('.$kw['appeal_iin'].' '.$appeal_iin.")<br>";
	$mess.=$kw['client_phone'].': '.$appeal_phone."<br>";
	$mess.=$kw['client_email'].': '.$appeal_email."<br>";
	$mess.=$kw['sut-raznoglasiya'].':<br>'.$txt;

	$subj=$kw['subject_appeal'];

	include "mail2.php";

	$fio-$fam.' '.$imy.' '.$otc;
	$email=$appeal_email;
	smtpmail($fio, $email, $kw['title_site'], $kw['text_obr']);
}


?>
<div class="container">
	<div class="row">
		<div class="col">
            <span class="news_tit"><? echo $kw["appeal"].' '.$s;?></span>
            <div class="appeal_info mypadding_top"><? echo $kw["appeal_info"];?></div>
		</div>
	</div>
	<div class="mypadding_top"></div>
<? if($tag==1) { ?>
    <form method="POST" enctype="multipart/form-data">
		<div class="row form-group" >
			<div class="col-sm">
			    <label for="bank" class="text_16"><? echo $kw["bank"];?>:</label>
				<select name="bank" class="form-control input_1" id="bank">
				<? echo getoption("bank","id,txt","where visibled=1","");?>
			    </select>
			</div>
		</div>
		<div class="row form-group" >
			<div class="col-sm" >
			    <label for="sut-raznoglasiya" class="text_16"><? echo $kw["sut-raznoglasiya"];?>:</label>
				<textarea id="sut-raznoglasiya" rows=10 required name="sutraznoglasiya" class="form-control input_1"></textarea>
			</div>
		</div>
		<div class="row " >
			<div class="col-sm">
	            <label for="fam" class="text_16"><? echo $kw["fam"];?>:</label>
	        </div>
	        <div class="col-sm">
	            <label for="imy" class="text_16"><? echo $kw["imy"];?>:</label>
	        </div>
	        <div class="col-sm">
	            <label for="otc" class="text_16"><? echo $kw["otc"];?>:</label>
	        </div>
		</div>
		<div class="row form-group" >
			<div class="col-sm">
	            <input id="fam" class="form-control input_1" name="fam" required>
	        </div>
			<div class="col-sm">
	            <input id="imy" class="form-control input_1" name="imy" required>
	        </div>
			<div class="col-sm">
	            <input id="otc" class="form-control input_1" name="otc" >
	        </div>
		</div>
		<div class="row " >
			<div class="col-sm">
	            <label for="appeal_phone" class="text_16"><? echo $kw["appeal_address"]. ' ('.$kw['required'].')';?>:</label>
	        </div>
	        <div class="col-sm">
				<label for="appeal_email" class="text_16"><? echo $kw["appeal_iin"]. ' ('.$kw['required'].')';?>:</label>
			</div>
		</div>
		<div class="row form-group" >
			<div class="col-sm">
	            <input id="appeal_address" class="form-control input_1" name="appeal_address" required>
	        </div>
			<div class="col-sm">
	            <input id="appeal_iin" class="form-control input_1" name="appeal_iin" required type="tel" pattern="[0-9]{12}" maxlength="12" >
	        </div>
		</div>
		<div class="row " >
			<div class="col-sm">
	            <label for="appeal_phone" class="text_16"><? echo $kw["appeal_phone"].' ('.$kw['required'].')';?>:</label>
	        </div>
	        <div class="col-sm">
				<label for="appeal_email" class="text_16"><? echo $kw["appeal_email"];?>:</label>
			</div>
		</div>
		<div class="row form-group" >
			<div class="col-sm">
				<input id="appeal_phone" class="form-control input_1" name="appeal_phone" type="tel" required pattern="[0-9]{11}" maxlength="11" placeholder="8xxxxxxxxxx" size="11">
			</div>
			<div class="col-sm">
	            <input id="appeal_email" class="form-control input_1" name="appeal_email" type="email" required>
	        </div>
		</div>

		<fieldset class="appeal_fieldset">
		    <legend class="appeal_legend"><? echo $kw["appeal_groupbox"];?></legend>
		    <center class="red">(<?=$kw['alert_big_file'];?>)</center>
		    <? /*
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["appeal_udost"];?>:</label>
		        </div>
		        <div class="col-sm">
		            <input type="file" class="form-control-file file" required name="file1">
		        </div>
			</div>
			*/ ?>
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["appeal_bank"];?>:</label>
		        </div>
		        <div class="col-sm">
		        	<input type="radio" name="r_file2" id="f20" onclick="show1('file2');"> <label for="f20"> <?=$kw['no'];?> </label> &nbsp; 
		        	<input type="radio" name="r_file2" id="f21" onclick="show2('file2');"> <label for="f21"> <?=$kw['yes'];?> </label>
		        	<div class="anketa_file" id="file2"> &nbsp; 
		        		<input type="file" class="file" name="file2" id="file2_">
		            </div>
		        </div>
			</div>
			<? /*
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["pismo_v_bank"];?>:</label>
		        </div>
		        <div class="col-sm">
		        	<input type="radio" name="r_file3" id="f30" onclick="show1('file3');"> <label for="f30"> <?=$kw['no'];?> </label> &nbsp; 
		        	<input type="radio" name="r_file3" id="f31"  onclick="show2('file3');"> <label for="f31"> <?=$kw['yes'];?> </label>
		        	<div class="pismobank_file" id="file3"> &nbsp; 
		            	<input type="file" class="file" name="file3" id="file3_">
		            </div>
		        </div>
			</div>
			*/ ?>
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["pismo_ot_banka"];?>:</label>
		        </div>
		        <div class="col-sm">
		        	<input type="radio" name="r_file4" id="f40" onclick="show1('file4');"> <label for="f40"> <?=$kw['no'];?> </label> &nbsp; 
		        	<input type="radio" name="r_file4" id="f41"  onclick="show2('file4');"> <label for="f41"> <?=$kw['yes'];?> </label>
		        	<div class="file4_file" id="file4"> &nbsp; 
		            	<input type="file" class="file" name="file4" id="file4_">
		        	</div>
		        </div>
			</div>
			<? /*
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["appeal_obrashenie"];?>:</label>
		        </div>
		        <div class="col-sm">
		            <input type="file" class="form-control-file file" required name="file5">
		        </div>
			</div>
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["anketa_k_ombudsman"];?>:</label>
		        </div>
		        <div class="col-sm">
		            <input type="file" class="form-control-file file" required name="file6">
		        </div>
			</div>
			*/ ?>
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["dogovor_bank"];?>:</label>
		        </div>
		        <div class="col-sm">
		        	<input type="radio" name="r_file7" id="f70" onclick="show1('file7');"> <label for="f70"> <?=$kw['no'];?> </label> &nbsp; 
		        	<input type="radio" name="r_file7" id="f71"  onclick="show2('file7');"> <label for="f71"> <?=$kw['yes'];?> </label>
		        	<div class="file7_file" id="file7"> &nbsp; 
		            	<input type="file" class="file" name="file7" id="file7_">
		            </div>
		        </div>
			</div>
			<? /*
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["appeal_spravka"];?>:</label>
		        </div>
		        <div class="col-sm">
		            <input type="file" class="form-control-file file" name="file8">
		        </div>
			</div>
			*/ ?>
			<div class="row form-group" >
				<div class="col-sm text-right">
		            <label class="text_16"><? echo $kw["appeal_itd"];?>:</label>
		        </div>
		        <div class="col-sm">
		        	<input type="radio" name="r_file9" id="f90" onclick="show1('file9');"> <label for="f90"> <?=$kw['no'];?> </label> &nbsp; 
		        	<input type="radio" name="r_file9" id="f91"  onclick="show2('file9');"> <label for="f91"> <?=$kw['yes'];?> </label>
		        	<div class="file9_file" id="file9"> &nbsp; 
		            	<input type="file" class="file" name="file9"  id="file9_">
		            </div>
		        </div>
			</div>
		</fieldset>
		<div class="row form-group mypadding_top">
			<div class="col-sm text-center">
		        <input type="submit" name="appeal_send" class="btn btn-primary" value="<? echo $kw["send"];?>">
		    </div>
		</div>
	</form>

	<script type="text/javascript">
	$('.file').change(function() {
	    if(this.files[0].size > 2000000){
	       alert("<?=$kw["error_big_file"];?>");
	       this.value = "";
	    };
	});
	</script>
<? } ?>

<? if($tag==2) {
	//тут будет отображается результаты успешной загрузки
	echo $ss;
}
?>
</div>
<script type="text/javascript">
function show1(tag) {
  document.getElementById(tag).style.display ='none';
  document.getElementById(tag+"_").required = false;
}
function show2(tag){
  document.getElementById(tag).style.display = 'inline-block';
  document.getElementById(tag+"_").required = true;
}	
</script>
