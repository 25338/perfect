<?
/*
6Lf4F6YUAAAAAAB3ik-wboxcr3hs2WdzHf-mE9XN

6Lf4F6YUAAAAAEIjM80xg6p-as_1m6VDW9EvESm6
*/

require_once "recaptchalib.php";

$secret="6LfDOpcUAAAAAGk_nMga_0U65KueW-RS3tAG3Foi";
$response = null;
// проверка секретного ключа
$reCaptcha = new ReCaptcha($secret);

// if submitted check response
if ($_POST["g-recaptcha-response"]) {
$response = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}

//	if($response != null && $response->success){
function start_capcha(){ ?>
 <script src="https://www.google.com/recaptcha/api.js?render=6Lf4F6YUAAAAAAB3ik-wboxcr3hs2WdzHf-mE9XN"></script>
  <script>
  grecaptcha.ready(function() {
      grecaptcha.execute('6Lf4F6YUAAAAAAB3ik-wboxcr3hs2WdzHf-mE9XN', {action: 'homepage'}).then(function(token) {
      });
  });
  </script>
<?
}
?>