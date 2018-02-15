<?php
/**
 * Created by PhpStorm.
 * User: jeyfost
 * Date: 30.01.2018
 * Time: 13:53
 */

include("connect.php");
include("recaptcha.php");

$req = false;
ob_start();

$name = $mysqli->real_escape_string($_POST['name']);
$email = $mysqli->real_escape_string($_POST['email']);
$phone = $mysqli->real_escape_string($_POST['phone']);
$t = $mysqli->real_escape_string($_POST['message']);

$from = $name." <".$email.">";
$to = CONTACT_EMAIL;
$reply = $email;
$subject = "Письмо с сайта smARTech";

$hash = md5(rand(0, 10000000).date('Y-m-d H:i:s'));

$secret = "6LfBT0MUAAAAAFpKcdVXwcljIzGXIEMZNVao7lL2";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if($_POST['g-recaptcha-response']) {
    $response = $reCaptcha->verifyResponse(
        $_SERVER['REMOTE_ADDR'],
        $_POST['g-recaptcha-response']
    );
}

if($response != null && $response->success) {
    $headers = "From: ".$from."\nReply-To: ".$reply."\nMIME-Version: 1.0";
    $headers .= "\nContent-Type: multipart/mixed; boundary = \"PHP-mixed-".$hash."\"\n\n";

    $text = "
        <div style='width: 100%; height: 100%; background-color: #fafafa; padding-top: 5px; padding-bottom: 20px;'>
            <center>
                <div style='padding: 20px; box-shadow: 0 5px 15px -4px rgba(0, 0, 0, 0.4); background-color: #fff; width: 600px; text-align: left;'>
                    <b>Имя:</b> ".$name."
                    <br />
                    <b>Email:</b> ".$email."
                    <br />
                    <b>Телефон:</b> ".$phone."
                    <br />
                    <br />
			".$t."
			</div>
			<br /><br />
		    </center>
	    </div>
    ";

    $message = "--PHP-mixed-".$hash."\n";
    $message .= "Content-Type: text/html; charset=\"utf-8\"\n";
    $message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message .= $text."\n";
    $message .= "--PHP-mixed-".$hash."\n";

    if(mail($to, $subject, $message, $headers)) {
        echo "ok";
    } else {
        echo "failed";
    }
} else {
    echo "captcha";
}

$req = ob_get_contents();
ob_end_clean();
echo json_encode($req);

exit;