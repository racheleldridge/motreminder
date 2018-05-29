<?php

if(isset($_POST['submit']) && !empty($_POST['submit'])) {
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
$secret = '6Lf8EFwUAAAAALUVa3rtqmF19AzJeSOEEMqpoEkY';
$captcha_response = htmlspecialchars($_POST['g-recaptcha-response']);
$curl = curl_init();


$captcha_verify_url = "https://www.google.com/recaptcha/api/siteverify";


curl_setopt($curl, CURLOPT_URL,$captcha_verify_url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=".$secret."&response=".$captcha_response."&remoteip=".$_SERVER['REMOTE_ADDR']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


$captcha_output = curl_exec ($curl);
curl_close ($curl);

$decoded_captcha = json_decode($captcha_output);
$my_captcha = $decoded_captcha->success;
if($my_captcha === true){
$outMsg = 'Your contact request have submitted successfully.';
} else {


$outMsg = 'Robot verification failed, please try again.';
}
} else {
        $outMsg = 'Please click on the reCAPTCHA box.';
    }
} else {
    $outMsg = 'Enter required fields';
}

echo $outMsg;

print_r($captcha_output);
?>