<?
$scrname=$_SERVER['SCRIPT_NAME']; if($scrname!='/index.php') { exit; }
?>
<!DOCTYPE html>
<html>
<head>
<title><? echo $title_site;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="keywords" content="<? echo $keywords;?>" >
<meta name="description" content="<? echo $descriptions; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<link rel="stylesheet" href="/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="/owlcarousel/assets/owl.theme.default.min.css">

<link rel="stylesheet" type="text/css" href="/js/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/js/slick/slick-theme.css"> 

<link rel="stylesheet" href="/fontawesome/css/all.min.css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css" >

<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="/top_menu.css">

<script src="/js/jquery-3.3.1.min.js"></script>
<? include "googleanalitics.php";?>
</head>
<body>
<!-- шапка сайта -->
<? include "logo.php"; ?>
<!-- меню сайта -->
<? include "top_menu.php"; ?>
<!-- тело сайта -->
<? echo $html_body;?>
<!-- подвал сайта -->
<? include "footer.php";?>

<!-- js load -->
<script src="/owlcarousel/owl.carousel.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>